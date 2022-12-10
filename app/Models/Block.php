<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;
    protected $fillable = [
        'block_name',
        'is_parking',
        'row_block_id'
    ];

    public function kavlings()
    {
        return $this->hasMany(Kavling::class);
    }

    public function kavlingCounts($id)
    {
        $kavlings = Kavling::where('block_id', $id)->count();
        return $kavlings;
    }

    public function kavlingSoldCounts($id)
    {
        $kavlings = Kavling::where('block_id', $id)->where('status', 'UNAVAILABLE')->count();
        return $kavlings;
    }

    public function rowblocks()
    {
        return $this->belongsTo(RowBlock::class, 'row_block_id', 'id');
    }
}
