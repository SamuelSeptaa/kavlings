<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kavling extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kavling',
        'status',
        'block_id',
    ];

    public function block()
    {
        return $this->belongsTo(Block::class);
    }
}
