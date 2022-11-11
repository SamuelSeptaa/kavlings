@extends('layout.dashboard.index')
@section('dashboardcontent')
<div class="content-wrapper">
    <div class="grid-margin stretch-card">
        <div class="col-lg-8 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        Kavling List
                    </h4>
                    <div class="row mb-3 justify-content-end pr-3">
                        <a href="{{route('add-add-ons')}}" class="btn btn-primary">Tambah</a>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-lg-8 col-md-10 col-sm-12 row">
                            <label class="col-sm-3 col-form-label">Search</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm" name="search" id="search">
                            </div>
                        </div>
                    </div>
                    <div class="col-form-label">Filter Status</div>
                    <div class="filter-list mb-2">
                        <button type="button" class="btn btn-outline-info mr-1 my-1 btn-sm btn-filter"
                            data-block_id="all">Semua</button>
                        @foreach ($filter as $f)
                        <button type="button" class="btn btn-outline-info mr-1 my-1 btn-sm btn-filter"
                            data-block_id="{{$f}}">Status {{$f}}</button>
                        @endforeach
                    </div>
                    @if (session('success'))
                    <div class="alert alert-success ">
                        {{ session('success') }}
                    </div>
                    @endif
                    <div class="table-responsive mt-2">
                        <table class="table table-striped" id="data-add-ons" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>
                                        Action
                                    </th>
                                    <th>
                                        Nama Add On
                                    </th>
                                    <th>
                                        Harga
                                    </th>
                                    <th>
                                        Status
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

</div>
<!-- content-wrapper ends -->
@endsection