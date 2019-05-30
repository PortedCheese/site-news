<?php

namespace PortedCheese\SiteNews\Listeners;

use App\News;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClearCacheOnUpdateImage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $morph = $event->morph;
        if (!empty($morph) && get_class($morph) == News::class) {
            $morph->forgetCache(true);
        }
    }
}
