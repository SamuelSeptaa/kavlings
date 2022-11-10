<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // $this->call([
        //     UserSeeder::class,
        //     BlockSeeder::class,
        //     RowBlockSeeder::class
        // ]);
        $path = base_path() . '/database/seeders/database.sql';
        $sql = file_get_contents($path);
        DB::unprepared($sql);
        // User::factory(20)->create();
    }
}
