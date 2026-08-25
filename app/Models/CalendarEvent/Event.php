<?php

namespace App\Models\CalendarEvent;

use App\Models\Event as BaseEvent;

/**
 * Alias for App\Models\Event
 * This exists for better organization and namespace clarity
 */
class Event extends BaseEvent
{
    protected static function newFactory()
    {
        return \Database\Factories\EventFactory::new();
    }
}
