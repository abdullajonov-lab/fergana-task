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
    // since   PHP Fatal error:  Allowed memory size of 134217728 bytes exhausted (tried to allocate 262144 bytes) in /srv/http/SideProjects/fergana-task/vendor/laravel/framework/src/Illuminate/Support/Str.php on line 122 error I AM DELTEING all funcs
}
