<!-- header -->
<div class="top-header-area" id="sticker">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12 text-center">
                <div class="main-menu-wrap">
                    <!-- logo -->
                    <div class="site-logo">
                        <a href="index.html">
                            <img src="{{asset('img/logo.png')}}" alt="">
                        </a>
                    </div>
                    <!-- logo -->

                    <!-- menu start -->
                    <nav class="main-menu">
                        <ul>
                            <li><a href="{{route('index')}}">Beranda</a></li>
                            <li><a href="{{route('about')}}">Tentang</a></li>
                            <li><a href="{{route('ulasan')}}">Ulasan</a></li>
                            <li><a href="{{route('kavling')}}">Kavlings</a>
                            </li>
                            <li>
                                <button class="mobile-hide search-bar-icon btn text-white" data-toggle="modal"
                                    data-target="#exampleModal"><i class="fas fa-search"></i></button>
                            </li>
                        </ul>
                    </nav>
                    <a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
                    <div class="mobile-menu"></div>
                    <!-- menu end -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end header -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cari Kavling Anda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('cari-kavling')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="nomor_invoice">Nomor Invoice</label>
                        <input type="text" required class="form-control" id="nomor_invoice" name="nomor_invoice"
                            placeholder="Masukkan nomor Invoice Pembelian Anda">
                        <div class="invalid-feedback" for="nomor_invoice"></div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Cari</button>
                </form>
            </div>
        </div>
    </div>
</div>