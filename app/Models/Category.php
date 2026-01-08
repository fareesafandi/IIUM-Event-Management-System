<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'icon',
        'slug',
    ];

    /**
     * Get all events in this category
     *
     * @return BelongsToMany
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_categories')
            ->withTimestamps();
    }

    /**
     * Get the route key for the model (for route model binding with slug)
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}