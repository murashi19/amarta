<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Verified;
use App\Listeners\MarkUserAsVerified;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Verified::class => [
            MarkUserAsVerified::class,
        ],
    ];

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
