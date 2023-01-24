@extends('layout.index')
@section('content')
<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>TPU Kristen</p>
                    <h1>List Kavling</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- kavling section -->
<div class="mt-150 mb-150">
    <div class="container">
        <div class="h6">Keterangan Hasil Pencarian :</div>
        <div class="mb-3">
            <div class="row">
                <div class="col-md-3">Nama yang dimakamkan </div>
                <div class="col-md-9">: {{$nama_terkubur}}</div>
            </div>
            <div class="row">
                <div class="col-md-3">Nomor Kavling</div>
                <div class="col-md-9">: @foreach ($kavlingName as $k) {{"Nomor $k,"}}
                    @endforeach</div>
            </div>
            <div class="row">
                <div class="col-md-3">Block Kavling</div>
                <div class="col-md-9">: @foreach ($blockNames as $b) {{"Block $b,"}}
                    @endforeach</div>
            </div>
        </div>
        <div class="mb-3">
            <div class="d-flex align-items-center mb-2">
                <div class="kavling-keterangan mr-3"></div>
                <p>Kavling Tersedia</p>
            </div>
            <div class="d-flex align-items-center mb-2">
                <div class="kavling searched mr-3"></div>
                <p>Kavling Anda</p>
            </div>
        </div>

        <div class="kavling-list">
            <div class="street">
                <h5>Jalan Yusuf Arimatea</h5>
            </div>
            <div class="denah-scrollable">
                @foreach ($row as $r)
                <div class="{{$r->classname}}">
                    @foreach ($r->blocks as $b)
                    <div class="text-center mt-2">
                        <h5>{{$b->block_name}}</h5>
                    </div>
                    <div class="{{$r->classname}}i p-1 my-2">
                        @if ($b->is_parking == 'YES')
                        <div class="parking-area">
                            <div class="parking-text">
                                PARKING AREA
                            </div>
                        </div>
                        @endif
                        @foreach ($b->kavlings as $a)
                        <div class="kavling @if (in_array($a->id, $kavlingId)) searched @endif" data-id="{{$a->id}}">
                            <div class="nama-kavling">{{$a->nama_kavling}}</div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach

                </div>
                @endforeach
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