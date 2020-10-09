<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{

    protected $fillable = ['title', 'description', 'complete_in'];

    public function task(){
        return $this->morphTo();
    }

    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function calendarEvent() {
        return $this->morphOne(CalendarEvent::class, 'parent');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
