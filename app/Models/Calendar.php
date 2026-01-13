<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;
    protected $fillable = [
        'beginning_hour', 'ending_hour', 'slot_duration_time', 'availability_type', 'slot_duration_unit', 'description', 'user_id',
        'friday', 'is_off', 'return_date', 'saturday', 'sunday', 'thursday', 'tuesday', 'user_id', 'wednesday', 'monday'
    ];

    protected $casts = [
        'monday'     => 'boolean',    // devient true/false
        'tuesday'      => 'boolean',
        'wednesday'  => 'boolean',
        'thursday'     => 'boolean',
        'friday'     => 'boolean',
        'saturday'     => 'boolean',
        'sunday'     => 'boolean',
        'is_off'     => 'boolean'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function appointments() {
        return $this->hasMany('App\Models\Appointment');
    }

    public function setReturnDateAttribute($value)
    {
        $this->attributes['return_date'] = Carbon::parse($value)
            ->format('Y-m-d H:i:s');
    }
}
