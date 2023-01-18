@extends('layout.dashboard.index')
@section('dashboardcontent')
<div class="content-wrapper">
    <div class="grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    {{$title}}
                </h4>
                <div class="row justify-content-between">
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-6 col-lg-4 col-form-label">Filter Tahun</label>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <input type="text" class="form-control yearpicker" name="year" id="year"
                                    value="{{date('Y')}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive mt-2">
                    <table class="table table-striped" id="data-report" style="width: 100%">
                        <thead>
                            <tr>
                                <th>
                                    January
                                </th>
                                <th>
                                    February
                                </th>
                                <th>
                                    Maret
                                </th>
                                <th>
                                    April
                                </th>
                                <th>
                                    Mei
                                </th>
                                <th>
                                    Juni
                                </th>
                                <th>
                                    Juli
                                </th>
                                <th>
                                    Agustus
                                </th>
                                <th>
                                    September
                                </th>
                                <th>
                                    Oktober
                                </th>
                                <th>
                                    November
                                </th>
                                <th>
                                    December
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

                <h4 class="card-title mt-5">
                    Jumlah Penjualan Kavling Bulanan Perblock
                </h4>
                <div class="table-responsive mt-2">
                    <table class="table table-striped" id="data-report-block" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    Nama Block
                                </th>
                                <th>
                                    January
                                </th>
                                <th>
                                    February
                                </th>
                                <th>
                                    Maret
                                </th>
                                <th>
                                    April
                                </th>
                                <th>
                                    Mei
                                </th>
                                <th>
                                    Juni
                                </th>
                                <th>
                                    Juli
                                </th>
                                <th>
                                    Agustus
                                </th>
                                <th>
                                    September
                                </th>
                                <th>
                                    Oktober
                                </th>
                                <th>
                                    November
                                </th>
                                <th>
                                    December
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