<?php

namespace App\Providers;

use App\Models\Announcement;
use App\Models\User;
use App\Observers\AnnouncementObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Gate;
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

        Gate::define('is-your-announcement', function (User $user, Announcement $announcement) {
            if ($user->id === $announcement->user_id) {
                return true;
            }

            return false;
        });
    }
}
