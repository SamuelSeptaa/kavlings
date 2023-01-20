@extends('layout.dashboard.index')
@section('dashboardcontent')
<div class="content-wrapper">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    {{$title}}
                </h4>
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <h4 class="card-title">
                            Informasi Pemesan
                        </h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>Nama Pemesan</td>
                                        <td>{{$order->nama_pemesan}}</td>
                                    </tr>
                                    <tr>
                                        <td>Email Pemesan</td>
                                        <td><a href="mailto:{{$order->email_pemesan}}">{{$order->email_pemesan}}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nomor HP Pemesan</td>
                                        <td><a href="tel:{{$order->nomor_pemesan}}">{{$order->nomor_pemesan}}</a></td>
                                    </tr>
                                    <tr>
                                        <td>Nama yang dimakamkan</td>
                                        <td>{{($order->nama_terkubur) ? $order->nama_terkubur :
                                            '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Pemakaman (Estimasi)</td>
                                        <td>{{($order->tanggal_pemakaman) ? $order->tanggal_pemakaman :
                                            '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td>Nama Terhibah</td>
                                        <td>{{($order->nama_terhibah) ? $order->nama_terhibah : '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Hp Terhibah</td>
                                        <td>{{($order->nomor_hp_terhibah) ? $order->nomor_hp_terhibah : '-'}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <h4 class="card-title">
                            Informasi Pembayaran
                        </h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>Metode Pembayaran</td>
                                        <td>{{$order->metode_pembayaran}}</td>
                                    </tr>
                                    <tr>
                                        <td>Status Pembayaran</td>
                                        <td>
                                            @if ($order->status_pembayaran == 'PENDING')
                                            <span class="badge badge-warning">{{$order->status_pembayaran}}</span>
                                            @elseif ($order->status_pembayaran == 'SUCCESS')
                                            <span class="badge badge-success">{{$order->status_pembayaran}}</span>
                                            @elseif ($order->status_pembayaran == 'FAILED')
                                            <span class="badge badge-danger">{{$order->status_pembayaran}}</span>
                                            @elseif ($order->status_pembayaran == 'CANCELED')
                                            <span class="badge badge-danger">{{$order->status_pembayaran}}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Pembayaran</td>
                                        <td>{{($order->tanggal_pembayaran) ? parseTanggal($order->tanggal_pembayaran) :
                                            'Belum Dibayar'}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @if ($order->metode_pembayaran == 'CASH' && $order->status_pembayaran == "PENDING")
                        <div class="mt-3">
                            <form method="POST" action="{{route('verifikasi-cash')}}">
                                @csrf
                                <input type="hidden" name="orderid" value="{{$order->id}}">
                                <button type="submit" class="btn btn-primary mr-2">Verifikasi</button>
                                <p class="card-description mt-2">
                                    <b>Catatan</b>: Klik verifikasi <code>HANYA</code> ketika pemesan sudah membayar.
                                </p>
                            </form>
                        </div>
                        @endif
                        @if ($order->status != "BATAL")
                        <div class="mt-3">
                            <form method="POST" action="{{route('cancel-order')}}">
                                @csrf
                                <input type="hidden" name="orderid" value="{{$order->id}}">
                                <button type="submit" class="btn btn-danger mr-2">Cancel Pesanan</button>
                                <p class="card-description mt-2">
                                    <b>Catatan</b>: Klik Cancel Pesanan <code>HANYA</code> ketika ada pesanan yang
                                    prioritas.
                                </p>
                            </form>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-12 col-lg-6 mt-5">
                        <h4 class="card-title">
                            Informasi Pesanan
                        </h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            Nama Pesanan
                                        </th>
                                        <th>
                                            Jumlah
                                        </th>
                                        <th>
                                            Subtotal
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderDetail as $od)
                                    <tr>
                                        <td>
                                            {{$od->nama}}
                                        </td>
                                        <td>
                                            {{$od->jumlah}}
                                        </td>
                                        <td>
                                            {{currencyIDR($od->subtotal)}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-right">Total</th>
                                        <th>{{currencyIDR($order->total)}}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->
@endsection