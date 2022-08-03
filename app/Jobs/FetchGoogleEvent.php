<?php

namespace App\Jobs;

use App\Jobs\FetchGoogleResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchGoogleEvent extends FetchGoogleResource implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $calendar;

    public function __construct($calendar)
    {
        $this->calendar = $calendar;
    }

    public function getGoogleService()
    {
        return app(Google::class)
            ->connectUsing($this->calendar->googleAccount->token)
            ->service('Calendar');
    }

    public function getGoogleRequest($service, $options)
    {
        return $service->events->listEvents(
            $this->calendar->google_id, $options
        );
    }

    public function syncItem($googleEvent)
    {
        if ($googleEvent->status === 'cancelled') {
            return $this->calendar->events()
                ->where('event_id', $googleEvent->id)
                ->delete();
        }

        $this->calendar->events()->updateOrCreate(
            [
                'event_id' => $googleEvent->id,
            ],
            [
                'name' => $googleEvent->summary,
                'description' => $googleEvent->description,
                'allday' => !$googleEvent->start->dateTime && !$googleEvent->end->dateTime,
                'started_at' => $googleEvent->start,
                'ended_at' => $googleEvent->end,
            ]
        );
    }
}
