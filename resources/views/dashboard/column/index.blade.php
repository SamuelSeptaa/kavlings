@extends('layout.dashboard.index')
@section('dashboardcontent')
<div class="content-wrapper">
    <div class="grid-margin stretch-card">
        <div class="col-lg-8 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        {{$title}}
                    </h4>
                    <div class="row mb-3 justify-content-end pr-3">
                        <a href="{{route('add-column')}}" class="btn btn-primary">Tambah</a>
                    </div>
                    @if (session('success'))
                    <div class="alert alert-success ">
                        {{ session('success') }}
                    </div>
                    @endif
                    <div class="table-responsive mt-2">
                        <table class="table table-striped" id="data-column" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>
                                        Action
                                    </th>
                                    <th>
                                        Urutan Block/Column
                                    </th>
                                    <th>
                                        Jumlah Kavling
                                    </th>
                                    <th>
                                        Jumlah Kavling Terjual
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