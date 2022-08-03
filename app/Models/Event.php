<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_id',
        'name',
        'description',
        'allday',
        'started_at',
        'ended_at',
    ];
    protected $with = [
        'calendar',
    ];
    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }
}
