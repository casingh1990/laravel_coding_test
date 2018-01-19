<?php

namespace App\Listeners;

use App\Events\CreatedPrescriber;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Audit;

class CreatedPrescriberNotification
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
     * @param  CreatedPrescriber  $event
     * @return void
     */
    public function handle(CreatedPrescriber $event)
    {
        $audit = new Audit();
        $audit->table = "prescribers";
        $audit->action = "create";
        $audit->data = $event->prescriber->id;
        $audit->description = "created";
        $audit->save();
        return false;
    }
}
