@extends('layout.dashboard.index')
@section('dashboardcontent')
<div class="content-wrapper">
    <div class="grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    {{$title}}
                </h4>
                <div class="row mb-3 justify-content-end pr-3">
                    <a href="{{route('add-orders')}}" class="btn btn-primary">Tambah</a>
                </div>
                <div class="row justify-content-between">
                    <div class="col-lg-5 col-md-8 col-sm-12">
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-4 col-lg-3 col-form-label">Filter Tanggal</label>
                            <div class="col-sm-12 col-md-8 col-lg-9">
                                <input type="text" class="form-control" name="daterange" id="daterange">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-8 col-sm-12">
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-4 col-lg-3 col-form-label">Search</label>
                            <div class="col-sm-12 col-md-8 col-lg-9">
                                <input type="text" class="form-control" name="search" id="search">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-form-label">Filter Status</div>
                <div class="filter-list mb-2">
                    <button type="button" class="btn btn-outline-info mr-1 my-1 btn-sm btn-filter"
                        data-status="ALL">Semua</button>
                    @foreach ($filter_status as $fs)
                    <button type="button" class="btn btn-outline-info mr-1 my-1 btn-sm btn-filter"
                        data-status="{{$fs}}">{{$fs}}</button>
                    @endforeach
                </div>
                @if (session('success'))
                <div class="alert alert-success ">
                    {{ session('success') }}
                </div>
                @endif
                <div class="table-responsive mt-2">
                    <table class="table table-striped" id="data-orders" style="width: 100%">
                        <thead>
                            <tr>
                                <th>
                                    Action
                                </th>
                                <th>
                                    Tanggal Pemesanan
                                </th>
                                <th>
                                    Status Pesanan
                                </th>
                                <th>
                                    Nomor Invoice
                                </th>
                                <th>
                                    Nama Pemesan
                                </th>
                                <th>
                                    Kontak Pemesan
                                </th>
                                <th>
                                    Total
                                </th>
                                <th>
                                    Metode Pembayaran
                                </th>
                                <th>
                                    Status Pembayaran
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- content-wrapper ends -->
@endsection