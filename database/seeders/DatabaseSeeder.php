<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Attachment;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Attachment::factory(20)->create();
    }
}
