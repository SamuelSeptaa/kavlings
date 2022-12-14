@extends('layout.index')
@section('content')
<!-- hero area -->
<div class="hero-area hero-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 offset-lg-2 text-center">
                <div class="hero-text">
                    <div class="hero-text-tablecell">
                        <p class="subtitle">Tempat Pemakaman Umum</p>
                        <h1>Kristen Protestan</h1>
                        <div class="hero-btns">
                            <a href="/kavling" class="boxed-btn">Daftar Kavling</a>
                            <a href="/ulasan" class="bordered-btn">Ulasan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end hero area -->

<!-- features list section -->
<div class="list-section pt-80 pb-80">
    <div class="container">

        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <div class="list-box d-flex align-items-center">
                    <div class="list-icon">
                        <i class="fas fa-list-alt"></i>
                    </div>
                    <div class="content">
                        <h3>Add On Available</h3>
                        <p>Setiap Pemesanan Kavling</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <div class="list-box d-flex align-items-center">
                    <div class="list-icon">
                        <i class="fas fa-phone-volume"></i>
                    </div>
                    <div class="content">
                        <h3>24/7 Support</h3>
                        <p>Dapatkan Bantuan 24 Jam</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="list-box d-flex justify-content-start align-items-center">
                    <div class="list-icon">
                        <i class="fas fa-sync"></i>
                    </div>
                    <div class="content">
                        <h3>Refund</h3>
                        <p>Dapat refund dalam 3 hari!</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- end features list section -->

<!-- product section -->
<div class="product-section mt-150 mb-150">
    <div class="container">
        <div class="row ">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="section-title">
                    <h3><span class="orange-text">Our</span> Services</h3>
                    <p>Kami Menyediakan Kavling yang dapat dipesan secara online melalui laman website ini.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 text-center">
                <div class="single-product-item">
                    <h3>Kavling</h3>
                    <p class="product-price"><span>Per Kavling</span> {{currencyIDR(1500000)}} </p>
                    <a href="{{route('kavling')}}" class="cart-btn"><i class="fas fa-shopping-cart"></i> Pesan
                        Sekarang</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 text-center">
                <div class="single-product-item">
                    <h3>Add On</h3>
                    <p class="product-price"><span>Mulai dari</span> {{currencyIDR(250000)}} </p>
                    <a href="{{route('kavling')}}" class="cart-btn"><i class="fas fa-shopping-cart"></i> Pesan
                        Sekarang</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end product section -->

<!-- testimonail-section -->
<div class="testimonail-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1 text-center">
                <div class="testimonial-sliders">
                    @foreach ($testimonials as $t)
                    <div class="single-testimonial-slider">
                        <div class="client-meta">
                            <h3>{{$t->nama}}</h3>
                            <p class="testimonial-body">
                                " {{$t->testimonial_text}} "
                            </p>
                            <div class="last-icon">
                                <i class="fas fa-quote-right"></i>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end testimonail-section -->

<!-- end latest news -->
@endsection