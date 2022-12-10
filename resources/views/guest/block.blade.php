@extends('layout.index')
@section('content')
<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>TPU Kristen</p>
                    <h1>List Kavling Block {{$block->block_name}}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- kavling section -->
<div class="mt-150 mb-150">
    <div class="container">
        <div class="h6">Keterangan :</div>
        <div class="mb-3">
            <div class="d-flex align-items-center mb-2">
                <div class="kavling-keterangan mr-3"></div>
                <p>Kavling Tersedia</p>
            </div>
            <div class="d-flex align-items-center mb-2">
                <div class="kavling nonactive mr-3"></div>
                <p>Kavling Tidak Tersedia</p>
            </div>
        </div>

        <div class="kavling-list">
            <div class="denah-scrollable d-flex justify-content-center">
                <div class="{{$block->rowblocks->classname}}">
                    <div class="text-center mt-2">
                        <h5>{{$block->block_name}}</h5>
                    </div>
                    <div class="{{$block->rowblocks->classname}}i p-1 my-2">
                        @if ($block->is_parking == 'YES')
                        <div class="parking-area">
                            <div class="parking-text">
                                PARKING AREA
                            </div>
                        </div>
                        @endif
                        @foreach ($block->kavlings as $a)
                        <div class="kavling @if ($a->status=='UNAVAILABLE') nonactive @endif" data-id="{{$a->id}}">
                            <div class="nama-kavling">{{$a->nama_kavling}}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5 justify-content-end">
            <button href="{{route('kavling')}}" id="checkout" class="btn cart-btn"><i class="fas fa-shopping-cart"></i>
                Pesan
                Sekarang (<span id="jumlah-dipilih">0</span>)</button>
        </div>
    </div>
</div>
<!-- end kavling form -->
<!-- end featured section -->
@endsection