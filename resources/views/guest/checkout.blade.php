@extends('layout.index')
@section('content')
<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>TPU KRISTEN</p>
                    <h1>Check Out Kavlings</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- check out section -->
<div class="checkout-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="checkout-accordion-wrap">
                    <div class="accordion" id="accordionExample">
                        <div class="card single-accordion">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Billing Detail
                                    </button>
                                </h5>
                            </div>
                            <form id="form-place-order">
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="email_pemesan">Email address</label>
                                            <input type="text" class="form-control" id="email_pemesan"
                                                name="email_pemesan" placeholder="Enter email">
                                            <div class="invalid-feedback" for="email_pemesan"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_pemesan">Nama</label>
                                            <input type="text" class="form-control" id="nama_pemesan"
                                                name="nama_pemesan" placeholder="Enter nama">
                                            <div class="invalid-feedback" for="nama_pemesan"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="nomor_pemesan">Nomor HP</label>
                                            <input type="text" class="form-control" id="nomor_pemesan"
                                                name="nomor_pemesan" placeholder="Enter nomor HP">
                                            <div class="invalid-feedback" for="nomor_pemesan"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_terkubur">Nama yang dimakamkan (Opsional)</label>
                                            <input type="text" class="form-control" id="nama_terkubur"
                                                name="nama_terkubur"
                                                placeholder="Masukkan nama yang akan dimakamkan, pisahkan dengan koma">
                                            <div class="invalid-feedback" for="nama_terkubur"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_terkubur">Tanggal Pemakaman (estimasi)</label>
                                            <input type="date" class="form-control" id="tanggal_pemakaman"
                                                name="tanggal_pemakaman" placeholder="Tanggal Pemakaman"
                                                min="{{date('Y-m-d')}}">
                                            <div class="invalid-feedback" for="tanggal_pemakaman"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_terhibah">Nama Terhibah (Opsional)</label>
                                            <input type="text" class="form-control" id="nama_terhibah"
                                                name="nama_terhibah" placeholder="Enter nama terhibah">
                                            <div class="invalid-feedback" for="nama_terhibah"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="nomor_hp_terhibah">Nomor HP Terhibah (Opsional)</label>
                                            <input type="text" class="form-control" id="nomor_hp_terhibah"
                                                name="nomor_hp_terhibah" placeholder="Enter nomor hp terhibah">
                                            <div class="invalid-feedback" for="nomor_hp_terhibah"></div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="card single-accordion">
                            <div class="card-header" id="headingAddons">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                        data-target="#collapseAddOns" aria-expanded="false"
                                        aria-controls="collapseAddOns">
                                        Add Ons
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseAddOns" class="collapse" aria-labelledby="headingAddons"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    @foreach ($addons as $a)
                                    <input name="add_ons[]" type="checkbox" id="{{'addons_'.$a->id}}"
                                        data-harga="{{$a->harga}}" data-name="{{$a->nama_add_on}}" value="{{$a->id}}">
                                    <label for="{{'addons_'.$a->id}}">{{"$a->nama_add_on"}} -
                                        {{currencyIDR($a->harga)}}/Kavling
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        </form>
                        <div class="card single-accordion">
                            <div class="card-header" id="headingTwo">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                        data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Payment Method
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="shipping-address-form">
                                        <div class="d-flex">
                                            <button type="button"
                                                class="btn btn-outline-info mr-1 my-1 btn-sm btn-metode-pembayaran active"
                                                data-metode="TRANSFER">TRANSFER</button>
                                            <button type="button"
                                                class="btn btn-outline-info mr-1 my-1 btn-sm btn-metode-pembayaran"
                                                data-metode="CASH">CASH</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-4">
                <div class="order-details-wrap">
                    <table class="order-details">
                        <thead>
                            <tr>
                                <th>Your order Details</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody class="order-details-body">
                            @foreach ($carts as $cart)
                            <tr>
                                <td>{{$cart->name}}</td>
                                <td>{{currencyIDR($cart->getPriceSum())}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tbody class="addons-details">

                        </tbody>
                        <tbody class="total">
                            <tr>
                                <td>Total</td>
                                <td id="total-harga">{{currencyIDR($total)}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <button id="place-order" class="btn boxed-btn mt-2">Place Order</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end check out section -->
@endsection