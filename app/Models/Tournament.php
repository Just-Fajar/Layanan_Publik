<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'game', 'date', 'location', 'description', 'image', 'status', 'organizer_contact',
    ];

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
