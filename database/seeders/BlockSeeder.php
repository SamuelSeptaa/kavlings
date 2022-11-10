<?php

namespace Database\Seeders;

use App\Models\Block;
use Illuminate\Database\Seeder;

class BlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Block::insert([
            [
                'block_name'    =>  'AI-1',
                'row_block_id'    =>  1,
            ],
            [
                'block_name'    =>  'AI-2',
                'row_block_id'    =>  1,

            ],
            [
                'block_name'    =>  'AI-3',
                'row_block_id'    =>  1,
            ],
            [
                'block_name'    =>  'A',
                'row_block_id'    =>  2,
            ],
            [
                'block_name'    =>  'A-1',
                'row_block_id'    =>  2,
            ],
            [
                'block_name'    =>  'A-2',
                'row_block_id'    =>  2,
            ],
            [
                'block_name'    =>  'B-1',
                'row_block_id'    =>  3,
            ],
            [
                'block_name'    =>  'B-2',
                'row_block_id'    =>  3,
            ],
            [
                'block_name'    =>  'B-3',
                'row_block_id'    =>  3,
            ],
            [
                'block_name'    =>  'C-1',
                'row_block_id'    =>  4,
            ],
            [
                'block_name'    =>  'C-2',
                'row_block_id'    =>  4,
            ],
            [
                'block_name'    =>  'C-3',
                'row_block_id'    =>  4,
            ],
            [
                'block_name'    =>  'D-1',
                'row_block_id'    =>  5,
            ],
            [
                'block_name'    =>  'D-2',
                'row_block_id'    =>  5,
            ],
            [
                'block_name'    =>  'D-3',
                'row_block_id'    =>  5,
            ],
        ]);
    }
}
