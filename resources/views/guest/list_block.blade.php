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
        <div class="shipping-address-form">
            <div class="breadcrumb-text text-center">
                <p>Silahkan Pilih Block Terlebih Dahulu</p>
            </div>
            <div class="row justify-content-center">
                @foreach ($blocks as $b)
                <a href="{{route('kavling-list', 'block_id='.$b->id)}}" class="btn btn-outline-info mr-2 my-1
                    btn-sm
                    btn-list-block">Block {{$b->block_name}}</a>
                @endforeach
                <a href="{{route('all-kavling')}}" class="btn btn-outline-info mr-2 my-1
                    btn-sm
                    btn-list-block">Full Denah</a>
            </div>
        </div>
    </div>
</div>
<!-- end kavling form -->
<!-- end featured section -->
@endsection