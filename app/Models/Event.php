<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'google_id',
        'name',
        'description',
        'allday',
        'started_at',
        'ended_at',
    ];
}
