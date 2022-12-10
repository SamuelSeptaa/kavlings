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
        $this->data['blocks']   = Block::all();
        return view('guest.list_block', $this->data);
    }

    public function list_kavling()
    {
        Cart::clear();

        $row = RowBlock::with('blocks')->orderBy('id', 'asc')->get();
        $this->data['row'] = $row;

        // $block = Block::with('kavlings')->find(1);
        // dd($block->kavlings);
        $this->data['script']      = 'guest.script_kavling';
        return view('guest.kavling', $this->data);
    }

    public function block_kavling(Request $request)
    {
        Cart::clear();

        $block_id   = $request->block_id;

        $block = Block::with(['kavlings', 'rowblocks'])->findOrFail($block_id);
        $this->data['block'] = $block;
        $this->data['script']      = 'guest.script_kavling';
        return view('guest.block', $this->data);
    }
}
