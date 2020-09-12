<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public $fillable = ['course', 'slug'];

    public function groups()
    {
        return $this->belongsToMany(Group::class)->withTimestamps();
    }
}
