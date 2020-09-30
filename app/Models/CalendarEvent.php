<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    protected $guarded = [];

    protected $with = ['parent'];

    public function parent() {
        return $this->morphTo();
    }


}
