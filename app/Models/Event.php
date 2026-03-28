<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'venue',
        'date',
        'time',
        'poster_image',
        'status',
        'max_participants',
        'manager_id',
        'organizer_name',
        'organizer_contact',
        'organizer_email',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
    ];

    /**
     * Event status constants
     */
    public const STATUS_OPEN = 'open';
    public const STATUS_CLOSED = 'closed';
    public const STATUS_FULL = 'full';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_UPCOMING = 'upcoming';

    /**
     * Get the event manager (user who created this event)
     *
     * @return BelongsTo
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Get all users registered for this event
     *
     * @return BelongsToMany
     */
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_registrations')
            ->withPivot('status', 'created_at', 'updated_at')
            ->withTimestamps();
    }

    /**
     * Get all categories this event belongs to
     *
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'event_categories')
            ->withTimestamps();
    }

    /**
     * Scope: Get upcoming events (date >= today)
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('date', '>=', Carbon::today());
    }

    /**
     * Scope: Get past events (date < today)
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePast(Builder $query): Builder
    {
        return $query->where('date', '<', Carbon::today());
    }

    /**
     * Scope: Filter events by status
     *
     * @param Builder $query
     * @param string $status
     * @return Builder
     */
    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Filter events by category
     *
     * @param Builder $query
     * @param int $categoryId
     * @return Builder
     */
    public function scopeByCategory(Builder $query, int $categoryId): Builder
    {
        return $query->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('categories.id', $categoryId);
        });
    }

    /**
     * Scope: Search events by title or description
     *
     * @param Builder $query
     * @param string $searchTerm
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $searchTerm): Builder
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'like', "%{$searchTerm}%")
              ->orWhere('description', 'like', "%{$searchTerm}%")
              ->orWhere('venue', 'like', "%{$searchTerm}%")
              ->orWhere('organizer_name', 'like', "%{$searchTerm}%");
        });
    }

    /**
     * Scope: Get events that are open for registration
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOpenForRegistration(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_OPEN)
            ->upcoming()
            ->where(function ($q) {
                $q->whereNull('max_participants')
                  ->orWhereRaw('max_participants > (
                      SELECT COUNT(*) 
                      FROM event_registrations 
                      WHERE event_registrations.event_id = events.id 
                      AND event_registrations.status = ?
                  )', ['confirmed']);
            });
    }

    /**
     * Get the count of confirmed participants
     *
     * @return int
     */
    public function getConfirmedParticipantsCountAttribute(): int
    {
        return $this->participants()->wherePivot('status', 'confirmed')->count();
    }

    /**
     * Get available slots for this event
     *
     * @return int|null
     */
    public function getAvailableSlotsAttribute(): ?int
    {
        if ($this->max_participants === null) {
            return null; // Unlimited slots
        }

        return max(0, $this->max_participants - $this->confirmed_participants_count);
    }

    /**
     * Check if event is full
     *
     * @return bool
     */
    public function isFull(): bool
    {
        if ($this->max_participants === null) {
            return false; // Unlimited capacity
        }

        return $this->confirmed_participants_count >= $this->max_participants;
    }

    /**
     * Check if event is in the past
     *
     * @return bool
     */
    public function isPast(): bool
    {
        return $this->date < Carbon::today();
    }

    /**
     * Check if event can accept registrations
     *
     * @return bool
     */
    public function canAcceptRegistrations(): bool
    {
        if ($this->status !== self::STATUS_OPEN) {
            return false;
        }

        if ($this->isPast()) {
            return false;
        }

        if ($this->isFull()) {
            return false;
        }

        return true;
    }

    /**
     * Get the full poster image URL
     *
     * @return string
     */
    public function getPosterImageUrlAttribute(): string
    {
        if (!$this->poster_image) {
            return asset('images/default-event-poster.jpg');
        }

        if (filter_var($this->poster_image, FILTER_VALIDATE_URL)) {
            return $this->poster_image;
        }

        return asset('storage/' . $this->poster_image);
    }
}