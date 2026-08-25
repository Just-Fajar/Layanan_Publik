<?php

namespace App\Models\CalendarEvent;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EventRegistration extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return \Database\Factories\EventRegistrationFactory::new();
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_registrations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'event_id',
        'status',
        'attendance_code',
        'attended_at',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'attended_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Generate attendance code when creating registration
        static::creating(function ($registration) {
            if (empty($registration->attendance_code)) {
                $registration->attendance_code = strtoupper(Str::random(10));
            }
        });
    }

    /**
     * Get the user that owns the registration.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the event for the registration.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Scope a query to only include registered.
     */
    public function scopeRegistered($query)
    {
        return $query->where('status', 'registered');
    }

    /**
     * Scope a query to only include attended.
     */
    public function scopeAttended($query)
    {
        return $query->where('status', 'attended');
    }

    /**
     * Scope a query to only include cancelled.
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Check if registration is active (registered).
     */
    public function isRegistered(): bool
    {
        return $this->status === 'registered';
    }

    /**
     * Check if user has attended.
     */
    public function hasAttended(): bool
    {
        return $this->status === 'attended';
    }

    /**
     * Check if registration is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Get QR code representation/attendance code.
     */
    public function getQrCodeAttribute(): ?string
    {
        return $this->attendance_code;
    }

    /**
     * Mark as attended.
     */
    public function markAttended()
    {
        $this->update([
            'status' => 'attended',
            'attended_at' => now(),
        ]);
    }
}
