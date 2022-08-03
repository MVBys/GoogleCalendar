<?php

namespace App\Models;

use App\Jobs\FetchGoogleEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'calendar_id', 'name', 'color', 'timezone',
    ];

    public function googleAccount()
    {
        return $this->belongsTo(GoogleAccount::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($calendar) {
            FetchGoogleEvent::dispatch($calendar);
        });
    }
}
