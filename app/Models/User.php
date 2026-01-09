<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'matric_no',
        'phone_number',
        'role',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Automatically hash the password when setting it.
     * Only hash if the value has changed and is not already hashed.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value): void
    {
        // Only hash if the value is provided and not already hashed
        if ($value) {
            // Check if already hashed (bcrypt hashes start with $2y$ and are 60 chars)
            if (strlen($value) === 60 && strpos($value, '$2y$') === 0) {
                $this->attributes['password'] = $value;
            } else {
                $this->attributes['password'] = Hash::make($value);
            }
        }
    }

    /**
     * User roles constants
     */
    public const ROLE_PUBLIC = 'public';
    public const ROLE_EVENT_MANAGER = 'event_manager';

    /**
     * Get all events created by this user (as event manager)
     *
     * @return HasMany
     */
    public function managedEvents(): HasMany
    {
        return $this->hasMany(Event::class, 'manager_id');
    }

    /**
     * Get all events the user has registered for
     *
     * @return BelongsToMany
     */
    public function registeredEvents(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_registrations')
            ->withPivot('status', 'created_at', 'updated_at')
            ->withTimestamps();
    }

    /**
     * Check if user is an event manager
     *
     * @return bool
     */
    public function isEventManager(): bool
    {
        return $this->role === self::ROLE_EVENT_MANAGER;
    }

    /**
     * Check if user is a public user
     *
     * @return bool
     */
    public function isPublicUser(): bool
    {
        return $this->role === self::ROLE_PUBLIC || $this->role === null;
    }

    /**
     * Check if user has registered for a specific event
     *
     * @param int $eventId
     * @return bool
     */
    public function hasRegisteredForEvent(int $eventId): bool
    {
        return $this->registeredEvents()->where('events.id', $eventId)->exists();
    }

    /**
     * Get the profile picture URL
     *
     * @return string
     */
    public function getProfilePictureUrlAttribute(): string
    {
        if (!$this->profile_picture) {
            return asset('images/default-avatar.png');
        }

        if (filter_var($this->profile_picture, FILTER_VALIDATE_URL)) {
            return $this->profile_picture;
        }

        return asset('storage/' . $this->profile_picture);
    }
}
