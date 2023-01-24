<?php

namespace App\Http\Controllers;

use Cart;
use App\Models\Block;
use App\Models\Kavling;
use App\Models\Order;
use App\Models\RowBlock;
use Illuminate\Http\Request;

class Kavlings extends Controller
{

    public function index()
    {
        $this->data['blocks']   = Block::all();
        return view('guest.list_block', $this->data);
    }

    public function full_denah()
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

    public function cari_kavling(Request $request)
    {
        $nama_terkubur = $request->nama_terkubur;

        $order = Order::with('orderDetail')->where('nama_terkubur', 'like', "%$nama_terkubur%")->firstOrFail();

        $kavlingId = array();
        $kavlingName = array();
        $blockNames = array();
        foreach ($order->orderDetail as $od) {
            if ($od->kavling_id != null) {
                array_push($kavlingId, $od->kavling_id);
                array_push($kavlingName, $od->nama);
                $blockName = Kavling::where('id', $od->kavling_id)->first();
                array_push($blockNames, $blockName->block->block_name);
            }
        }

        $this->data['nama_terkubur']    = $nama_terkubur;
        $this->data['kavlingId']    = $kavlingId;
        $this->data['kavlingName']    = $kavlingName;
        $this->data['blockNames']    = array_unique($blockNames);

        $row = RowBlock::with('blocks')->orderBy('id', 'asc')->get();
        $this->data['row'] = $row;
        return view('guest.kavling_search', $this->data);
    }
}
