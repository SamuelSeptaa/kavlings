<?php

namespace App\Http\Controllers;

use Cart;
use App\Models\Block;
use App\Models\RowBlock;
use Illuminate\Http\Request;

class Kavlings extends Controller
{

    public function index()
    {
        Cart::clear();
        $row1 = RowBlock::with('blocks')->find(1);
        $row2 = RowBlock::with('blocks')->find(2);
        $row3 = RowBlock::with('blocks')->find(3);
        $row4 = RowBlock::with('blocks')->find(4);
        $row5 = RowBlock::with('blocks')->find(5);
        $this->data['row1'] = $row1;
        $this->data['row2'] = $row2;
        $this->data['row3'] = $row3;
        $this->data['row4'] = $row4;
        $this->data['row5'] = $row5;


        // $block = Block::with('kavlings')->find(1);
        // dd($block->kavlings);
        $this->data['script']      = 'guest.script_kavling';
        return view('guest.kavling', $this->data);
    }
}
