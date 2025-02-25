<?php

namespace App\Providers;

use App\Models\Announcement;
use App\Observers\AnnouncementObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::morphMap([
            'users'=>'App\Models\User',
            'categories'=>'App\Models\Category',
            'attachments'=>'App\Models\Announcement'
        ]);

        Announcement::observe(AnnouncementObserver::class);
    }
}
