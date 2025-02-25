<?php

namespace App\Observers;

use App\Models\Announcement;
use Illuminate\Support\Str;

class AnnouncementObserver
{

    public function creating(Announcement $announcement): void
    {
        $announcement->slug = Str::slug($announcement->title) . "-" . Str::random();
    }

    /**
     * Handle the Announcement "updated" event.
     */
    public function updating(Announcement $announcement): void
    {
        $announcement->slug = Str::slug($announcement->title) . "-" . Str::random();
        $announcement->save();
    }

    /**
     * Handle the Announcement "deleted" event.
     */
    public function deleted(Announcement $announcement): void
    {
        //
    }

    /**
     * Handle the Announcement "restored" event.
     */
    public function restored(Announcement $announcement): void
    {
        //
    }

    /**
     * Handle the Announcement "force deleted" event.
     */
    public function forceDeleted(Announcement $announcement): void
    {
        //
    }
}
