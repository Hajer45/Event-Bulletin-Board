<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'user_id',
        'title',
        'description',
        'location',
        'event_date',
        'registration_deadline',
        'max_participants',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'event_date' => 'datetime',
        'registration_deadline' => 'datetime',
    ];

    /**
     * Get the user that owns the event.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include published events.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope a query to only include upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>', now());
    }

    /**
     * Check if the given user owns this event.
     */
    public function isOwnedBy(User $user): bool
    {
        return $this->user_id === $user->id;
    }

    /**
     * Check if registration is still open.
     */
    public function isRegistrationOpen(): bool
    {
        if ($this->registration_deadline) {
            return now()->isBefore($this->registration_deadline);
        }

        return now()->isBefore($this->event_date);
    }

    /**
     * Get formatted event date.
     */
    public function getFormattedEventDateAttribute(): string
    {
        return $this->event_date->format('F j, Y \a\t g:i A');
    }

    /**
     * Get formatted registration deadline.
     */
    public function getFormattedRegistrationDeadlineAttribute(): ?string
    {
        return $this->registration_deadline?->format('F j, Y \a\t g:i A');
    }

    /**
     * Check if event is in the past.
     */
    public function isPast(): bool
    {
        return $this->event_date->isPast();
    }

    /**
     * Check if event is published.
     */
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    /**
     * Check if event is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }
}
