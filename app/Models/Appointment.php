<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'meeting_date', 'duration_time', 'duration_unit', 'comment', 'user_id', 'type', 'status', 'calendar_id'
    ];

    public function calendar() {
        return $this->belongsTo('App\Models\Calendar');
    }

    public function users() {
        return $this->belongsToMany('App\Models\User')->withPivot('type');
    }

    public function requestor()
    {
        return $this->users()->wherePivot('type', 'requestor')->get();
    }

    public function trainer()
    {
        return $this->users()->wherePivot('type', 'trainer')->first();
    }

    public function setMeetingDateAttribute($value)
    {
        $this->attributes['meeting_date'] = Carbon::parse($value)
            ->format('Y-m-d H:i:s');
    }
}
