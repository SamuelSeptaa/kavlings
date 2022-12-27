<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Skydash Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('skydash/vendors/feather/feather.css')}}">
    <link rel="stylesheet" href="{{asset('skydash/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('skydash/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('skydash/css/vertical-layout-light/style.css')}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{asset('skydash/images/favicon.png')}}" />
</head>

<body>
    <div class="lds-circle">
        <div></div>
    </div>
    <div class="container-scroller">

        <div class="container-fluid page-body-wrapper full-page-wrapper">

            <div class="content-wrapper d-flex align-items-center auth px-0">

                <div class="row w-100 mx-0">

                    <div class="col-lg-4 mx-auto">

                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="{{asset('skydash/images/logo.png')}}" alt="logo">
                            </div>
                            <h4>Hello! let's get started</h4>
                            <h6 class="font-weight-light">Sign in to continue.</h6>

                            <form class="pt-3" id="login-form" method="POST" action="{{route('sign-in')}}">
                                @csrf
                                @if(Session::has('failed'))
                                <div class="alert alert-danger" role="alert">
                                    {{session('failed')}}
                                </div>
                                @endif
                                <div class="form-group">
                                    <input type="text"
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="Email">
                                    @error('email')
                                    <div class="invalid-feedback" for="email">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password"
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Password">
                                    @error('password')
                                    <div class="invalid-feedback" for="password">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" id="remember_me" name="remember_me"
                                                class="form-check-input">
                                            Keep me signed in
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit"
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN
                                        IN</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{asset('skydash/vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{asset('skydash/js/off-canvas.js')}}"></script>
    <script src="{{asset('skydash/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('skydash/js/template.js')}}"></script>
    <script src="{{asset('skydash/js/settings.js')}}"></script>
    <script src="{{asset('skydash/js/todolist.js')}}"></script>
    <script src="{{asset('skydash/vendors/jquery/jquery-3.5.1.min.js')}}"></script>
    <script src="{{asset('skydash/js/script.js')}}"></script>
    <!-- endinject -->
</body>
<script>
    $(document).ready(function(e){
        $("#login-form").find('input').on('input change'. function(e) {
            $(this).removeClass('is-invalid');
        })
    })
</script>

</html>