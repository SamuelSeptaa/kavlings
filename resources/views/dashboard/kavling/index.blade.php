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
                    <div class="row justify-content-end">
                        <div class="col-lg-8 col-md-10 col-sm-12 row">
                            <label class="col-sm-4 col-form-label">Search</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" name="search" id="search">
                            </div>
                        </div>
                    </div>
                    <div class="col-form-label">Filter Blok</div>
                    <div class="filter-list">
                        <button type="button" class="btn btn-outline-info mr-1 my-1 btn-sm btn-filter"
                            data-block_id="all">Semua Blok</button>
                        @foreach ($blocks as $b)
                        <button type="button" class="btn btn-outline-info mr-1 my-1 btn-sm btn-filter"
                            data-block_id="{{$b->id}}">Blok {{$b->block_name}}</button>
                        @endforeach
                    </div>
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped" id="data-kavling" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>
                                        Action
                                    </th>
                                    <th>
                                        Nama Kavling
                                    </th>
                                    <th>
                                        Status Kavling
                                    </th>
                                    <th>
                                        Block Kavling
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