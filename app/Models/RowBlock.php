<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RowBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'rowname',
    ];

    public function blocks()
    {
        return $this->hasMany(Block::class);
    }
}
