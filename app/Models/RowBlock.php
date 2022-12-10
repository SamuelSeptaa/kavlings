<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RowBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'rowname',
        'classname',
    ];

    public function blocks()
    {
        return $this->hasMany(Block::class);
    }

    public function kavlingCounts($id)
    {
        $block = Block::where('row_block_id', $id)->get();
        $totalKavling = 0;
        foreach ($block as $b) {
            $kavlings = Kavling::where('block_id', $b->id)->count();
            $totalKavling += $kavlings;
        }

        return $totalKavling;
    }

    public function kavlingSoldCounts($id)
    {
        $block = Block::where('row_block_id', $id)->get();
        $totalKavling = 0;
        foreach ($block as $b) {
            $kavlings = Kavling::where('block_id', $b->id)->where('status', 'UNAVAILABLE')->count();
            $totalKavling += $kavlings;
        }

        return $totalKavling;
    }
}
