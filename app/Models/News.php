<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['title','content','category','image'];

    public function scopeFilter($q, array $filters)
    {
        $q->when($filters['category'] ?? null, fn($qq,$v) => $qq->where('category',$v));
        $q->when($filters['q'] ?? null, fn($qq,$v) =>
            $qq->where(fn($w) => $w->where('title','like',"%$v%")->orWhere('content','like',"%$v%"))
        );
    }
}
