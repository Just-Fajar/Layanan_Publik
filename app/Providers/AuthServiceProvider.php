<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\News;
use App\Models\Tournament;
use App\Policies\CalendarEvent\EventPolicy;
use App\Policies\Esport\NewsPolicy;
use App\Policies\Esport\TournamentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Event::class => EventPolicy::class,
        Tournament::class => TournamentPolicy::class,
        News::class => NewsPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
