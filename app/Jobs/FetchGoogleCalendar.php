<?php

namespace App\Jobs;

use App\Jobs\FetchGoogleResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchGoogleCalendar extends FetchGoogleResource implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $googleAccount;

    public function __construct($googleAccount)
    {
        $this->googleAccount = $googleAccount;
    }

    public function getGoogleService()
    {
        return app(Google::class)
            ->connectUsing($this->googleAccount->token)
            ->service('Calendar');
    }

    public function getGoogleRequest($service, $options)
    {
        return $service->calendarList->listCalendarList($options);
    }

    public function syncItem($googleCalendar)
    {
        $this->googleAccount->calendars()->updateOrCreate(
            [
                'calendar_id' => $googleCalendar->id,
            ],
            [
                'name' => $googleCalendar->summary,
                'color' => $googleCalendar->backgroundColor,
                'timezone' => $googleCalendar->timeZone,
            ]
        );
    }
}
