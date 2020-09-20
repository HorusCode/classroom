<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testing extends Model
{
    protected $fillable = ['title', 'questions', 'time'];

    protected $casts = [
        'questions' => 'array',
    ];

    public function rates()
    {
        return $this->morphMany(Rating::class, 'work');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
