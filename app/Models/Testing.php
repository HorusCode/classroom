<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testing extends Model
{
    protected $fillable = ['title', 'questions', 'time'];

    protected $casts = [
        'questions' => 'array',
    ];

    public function works(){
        return $this->morphMany(Work::class, 'task');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
