<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expression extends Model
{
    use HasFactory;

    protected $fillable = [
        'visitor_id',
        'expression',
        'confidence',
    ];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }
}
