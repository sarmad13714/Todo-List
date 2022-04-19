<?php

namespace App\Models;


use App\Traits\FormatDates;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use FormatDates;

    public function getDeadlineAttribute($value) {
        // do something with value, or not
        return FormatDates::convertTimeToUSERzone($value, FormatDates::get_local_time());
    }
}
