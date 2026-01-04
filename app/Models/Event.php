<?php

namespace App\Models;

use App\Models\CalendarEvent\EventRegistration;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'category',
        'organizer',
        'contact_email',
        'contact_phone',
        'image',
        'status',
        'max_participants',
        'registration_deadline',
        'is_public',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'registration_deadline' => 'datetime',
        'is_public' => 'boolean',
        'max_participants' => 'integer',
    ];

    /**
     * The attributes that should be appended to arrays.
     *
     * @var array<int, string>
     */
    protected $appends = ['image_url', 'status_badge', 'is_upcoming'];

    /**
     * Get event categories from config.
     */
    public static function getCategories(): array
    {
        return config('calendar_event.categories', []);
    }

    /**
     * Get event statuses from config.
     */
    public static function getStatuses(): array
    {
        return config('calendar_event.statuses', []);
    }

    /**
     * Event status constants.
     */
    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    public const STATUS_CANCELLED = 'cancelled';

    public const STATUS_COMPLETED = 'completed';

    /**
     * Get the image URL attribute.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        return asset('storage/' . $this->image);
    }

    /**
     * Get status badge HTML from config.
     */
    public function getStatusBadgeAttribute(): string
    {
        $badges = config('calendar_event.status_badges', []);

        return $badges[$this->status] ?? '<span class="badge bg-light">Unknown</span>';
    }

    /**
     * Check if event is upcoming.
     */
    public function getIsUpcomingAttribute(): bool
    {
        return $this->start_date->isFuture() && $this->status === self::STATUS_PUBLISHED;
    }

    /**
     * Scope for published events.
     */
    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    /**
     * Scope for upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now())
            ->where('status', self::STATUS_PUBLISHED);
    }

    /**
     * Scope for filtering events.
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['category'] ?? null, function ($q, $category) {
            $q->where('category', $category);
        });

        $query->when($filters['status'] ?? null, function ($q, $status) {
            $q->where('status', $status);
        });

        $query->when($filters['month'] ?? null, function ($q, $month) use ($filters) {
            $year = $filters['year'] ?? now()->year;
            $q->whereMonth('start_date', $month)
                ->whereYear('start_date', $year);
        });

        $query->when($filters['search'] ?? null, function ($q, $search) {
            $q->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        });
    }

    /**
     * Get registrations for this event.
     */
    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Get users who registered for this event.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'event_registrations')
            ->withPivot('status', 'attendance_code', 'attended_at', 'notes')
            ->withTimestamps();
    }
}
