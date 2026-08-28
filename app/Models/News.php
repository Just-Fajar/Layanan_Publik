<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'category', 'image'];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }

    public function scopeFilter($q, array $filters)
    {
        $q->when($filters['category'] ?? null, fn ($qq, $v) => $qq->where('category', $v));
        $q->when(
            $filters['q'] ?? null,
            fn ($qq, $v) => $qq->where(fn ($w) => $w->where('title', 'like', "%$v%")->orWhere('content', 'like', "%$v%"))
        );
    }
}
