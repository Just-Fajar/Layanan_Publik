<?php

namespace App\Models;

use App\Models\Esport\TournamentRegistration;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'game', 'date', 'location', 'description', 'image', 'status', 'organizer_contact',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    protected $appends = ['name', 'start_date'];

    public function registrations()
    {
        return $this->hasMany(TournamentRegistration::class);
    }

    public function getNameAttribute(): ?string
    {
        return $this->title;
    }

    public function getStartDateAttribute()
    {
        return $this->date;
    }

    public function scopeFilter($q, array $filters)
    {
        $q->when($filters['game'] ?? null, fn ($qq, $v) => $qq->where('game', 'like', "%$v%"));
        $q->when($filters['status'] ?? null, fn ($qq, $v) => $qq->where('status', $v));
        $q->when(
            $filters['q'] ?? null,
            fn ($qq, $v) => $qq->where(fn ($w) => $w->where('title', 'like', "%$v%")->orWhere('location', 'like', "%$v%"))
        );
    }
}
