<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\NotificationTemplate;

class AddNotificationTemplatesToBusiness
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
    public function handle($business)
    {
        $notification_templates = NotificationTemplate::defaultNotificationTemplates($business->id);
        
        foreach ($notification_templates as $notification_template) {
            NotificationTemplate::create($notification_template);
        }
    }
}
