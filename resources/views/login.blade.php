@extends('layouts.minimal')
@section('content')
<!-- Page Wrap -->
<div class="loginColumns animated fadeInDown">
    <div class="row">

        <div class="col-md-6">
            <h2 class="font-bold">Welcome to IN+</h2>

            <p>
                Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.
            </p>

            <p>
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
            </p>

            <p>
                When an unknown printer took a galley of type and scrambled it to make a type specimen book.
            </p>

            <p>
                <small>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</small>
            </p>

        </div>
        <div class="col-md-6">
            <div class="ibox-content">
                <form class="m-t" role="form" action="login" method="post">
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Username" required="" name="email">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" required="" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
                    <input type="hidden" name="_Token" value="{{ csrf_token() }}">


                    <a href="#">
                        <small>Forgot password?</small>
                    </a>

                    <p class="text-muted text-center">
                        <small>Do not have an account?</small>
                    </p>
                    <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a>
                </form>
                <p class="m-t">
                    <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small>
                </p>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-md-6">
            Copyright Example Company
        </div>
        <div class="col-md-6 text-right">
            <small>© 2014-2015</small>
        </div>
    </div>
</div>




<!-- Footer -->
<footer class="small-section bg-gray-lighter footer pb-60">
    <div class="container">


        <!-- Social Links -->
        <div class="footer-social-links mb-50 mb-xs-50">
            <a href="https://web.facebook.com/humanitarci.hr/?ref=bookmarks" title="Facebook" target="_blank"><i
                        class="fa fa-facebook"></i></a>
        </div>
        <!-- End Social Links -->

        <!-- Footer Text -->
        <div class="footer-text">
            <!-- Copyright -->
            <div class="footer-copy font-alt">
                <a href="http://themeforest.net/user/theme-guru/portfolio" target="_blank">© humanitarci.hr 2016</a>.
            </div>
            <!-- End Copyright -->
            <div class="footer-made">
                Da bismo lakše pomagali jedni drugima.
            </div>
        </div>
        <!-- End Footer Text -->

    </div>


    <!-- Top Link -->
    <div class="local-scroll">
        <a href="#top" class="link-to-top"><i class="fa fa-caret-up"></i></a>
    </div>
    <!-- End Top Link -->

</footer>
<!-- End Foter -->

@endsection
