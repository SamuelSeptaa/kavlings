<?php

namespace Database\Seeders;

use App\Models\RowBlock;
use Illuminate\Database\Seeder;

class RowBlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        RowBlock::insert([
            ['rowname' => 1],
            ['rowname' => 2],
            ['rowname' => 3],
            ['rowname' => 4],
            ['rowname' => 5],
        ]);
    }
}
