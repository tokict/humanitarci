@inject('config', 'scaffold.config')
@inject('module', 'scaffold.module')
@inject('template', 'scaffold.template')
@inject('breadcrumbs', 'scaffold.breadcrumbs')
@inject('navigation', 'scaffold.navigation')
        <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ strip_tags($config->get('title')) }}
        @if ($module && ($title = $module->title()))
        &raquo; {{ $title }}
        @endif
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset($config->get('assets_path') . '/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- date picker -->
    <link rel="stylesheet" href="{{ asset($config->get('assets_path') . '/plugins/datepicker/datepicker3.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet"
          href="{{ asset($config->get('assets_path') . '/plugins/daterangepicker/daterangepicker-bs3.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset($config->get('assets_path') . '/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset($config->get('assets_path') . '/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset($config->get('assets_path') . '/css/extended.css') }}">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->


    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset($config->get('assets_path') . '/plugins/iCheck/square/blue.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet"
          href="{{ asset($config->get('assets_path') . '/plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}"
          type="text/css" media="screen"/>

    <style>
        [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
            display: none !important;
        }
    </style>

    @yield('scaffold.headjs')
</head>
<body>
<body>
<div id="wrapper">
    @include($template->menu('sidebar'))

    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    <form role="search" class="navbar-form-custom" action="search_results.html">
                        <div class="form-group">
                            <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                        </div>
                    </form>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <span class="m-r-sm text-muted welcome-message">Welcome to INSPINIA+ Admin Theme.</span>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                        </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="img/a7.jpg">
                                    </a>
                                    <div class="media-body">
                                        <small class="pull-right">46h ago</small>
                                        <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                        <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="img/a4.jpg">
                                    </a>
                                    <div class="media-body ">
                                        <small class="pull-right text-navy">5h ago</small>
                                        <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                        <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="img/profile.jpg">
                                    </a>
                                    <div class="media-body ">
                                        <small class="pull-right">23h ago</small>
                                        <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                        <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="text-center link-block">
                                    <a href="mailbox.html">
                                        <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li>
                                <a href="mailbox.html">
                                    <div>
                                        <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="profile.html">
                                    <div>
                                        <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                        <span class="pull-right text-muted small">12 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="grid_options.html">
                                    <div>
                                        <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="text-center link-block">
                                    <a href="notifications.html">
                                        <strong>See All Alerts</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>


                    <li>
                        <a href="login.html">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                    <li>
                        <a class="right-sidebar-toggle">
                            <i class="fa fa-tasks"></i>
                        </a>
                    </li>
                </ul>

            </nav>
        </div>
        <div class="row  border-bottom white-bg dashboard-header">
            @if ($module)

                @yield('scaffold.create')

                <div style="float:none; clear: left;">
                    @include($template->partials('breadcrumbs'))
                </div>


            @endif

            <div class="box">
                @yield('scaffold.filter')

                <div class="box-body">
                    @yield('scaffold.content')
                </div>

                <div class="box-footer">
                    @yield('scaffold.content-footer')
                </div>
            </div>



        </div>


    </div>



</div>



<!-- Flot -->
<script src="/administrator/js/plugins/flot/jquery.flot.js"></script>
<script src="/administrator/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="/administrator/js/plugins/flot/jquery.flot.spline.js"></script>
<script src="/administrator/js/plugins/flot/jquery.flot.resize.js"></script>
<script src="/administrator/js/plugins/flot/jquery.flot.pie.js"></script>

<!-- Peity -->
<script src="/administrator/js/plugins/peity/jquery.peity.min.js"></script>


<!-- Custom and plugin javascript -->



<!-- jQuery UI -->
<script src="/administrator/js/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- GITTER -->
<script src="/administrator/js/plugins/gritter/jquery.gritter.min.js"></script>

<!-- Sparkline -->
<script src="/administrator/js/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- ChartJS-->
<script src="/administrator/js/plugins/chartJs/Chart.min.js"></script>

<!-- Toastr -->
<script src="/administrator/js/plugins/toastr/toastr.min.js"></script>


<script>
    $(document).ready(function() {
        setTimeout(function () {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 4000
            };
            toastr.success('Responsive Admin Theme', 'Welcome to INSPINIA');

        }, 1300);
    });

</script>
</body>
{{--<div id="wrapper">

    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i>
                    </a>
                    <form role="search" class="navbar-form-custom" action="search_results.html">
                        <div class="form-group">
                            <input type="text" placeholder="Search for something..." class="form-control"
                                   name="top-search"
                                   id="top-search">
                        </div>
                    </form>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <span class="m-r-sm text-muted welcome-message">Welcome to INSPINIA+ Admin Theme.</span>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-envelope"></i> <span class="label label-warning">16</span>
                        </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="img/a7.jpg">
                                    </a>
                                    <div class="media-body">
                                        <small class="pull-right">46h ago</small>
                                        <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>.
                                        <br>
                                        <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="img/a4.jpg">
                                    </a>
                                    <div class="media-body ">
                                        <small class="pull-right text-navy">5h ago</small>
                                        <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica
                                            Smith</strong>.
                                        <br>
                                        <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="img/profile.jpg">
                                    </a>
                                    <div class="media-body ">
                                        <small class="pull-right">23h ago</small>
                                        <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                        <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="text-center link-block">
                                    <a href="mailbox.html">
                                        <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell"></i> <span class="label label-primary">8</span>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li>
                                <a href="mailbox.html">
                                    <div>
                                        <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="profile.html">
                                    <div>
                                        <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                        <span class="pull-right text-muted small">12 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="grid_options.html">
                                    <div>
                                        <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="text-center link-block">
                                    <a href="notifications.html">
                                        <strong>See All Alerts</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>


                    <li>
                        <a href="login.html">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                    <li>
                        <a class="right-sidebar-toggle">
                            <i class="fa fa-tasks"></i>
                        </a>
                    </li>
                </ul>

            </nav>
        </div>
        <!-- Left side column. contains the logo and sidebar -->


        <!-- Right side column. Contains the navbar and content of the page -->
        <div class="row  border-bottom white-bg dashboard-header">
            <!-- Content Header (Page header) -->
            @if ($module)

                @yield('scaffold.create')

                <div style="float:none; clear: left;">
                    @include($template->partials('breadcrumbs'))
                </div>


                @endif


                        <!-- Main content -->
                <section class="content">

                    <div class="box">
                        @yield('scaffold.filter')

                        <div class="box-body">
                            @yield('scaffold.content')
                        </div>

                        <div class="box-footer">
                            @yield('scaffold.content-footer')
                        </div>
                    </div>
                    <!-- /.box -->
                </section><!-- /.content -->

        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 3.0
            </div>
            <strong>
                Copyright &copy; {{ date('Y')-1 }} - {{ date('Y') }}
                <a href="http://terranet.md">Terranet.md</a>.
            </strong> All rights reserved.
        </footer>
    </div>
</div>--}}
<!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="{{ asset($config->get('assets_path') . '/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ asset($config->get('assets_path') . '/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset($config->get('assets_path') . '/plugins/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset($config->get('assets_path') . '/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- metisMenu -->
<script src="{{ asset($config->get('assets_path') . '/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset($config->get('assets_path') . '/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
{{--<!-- FastClick -->--}}
{{--<script src="{{ asset($config->get('assets_path') . '/plugins/fastclick/fastclick.min.js') }}"></script>--}}

        <!-- date-picker -->
<script src="{{ asset($config->get('assets_path') . '/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
@if ('en' !== config('app.locale'))
    <script src="{{ asset($config->get('assets_path') . '/plugins/datepicker/locales/bootstrap-datepicker.'.config("app.locale").'.js') }}"></script>
@endif

<script type="text/javascript"
        src="{{ asset($config->get('assets_path') . '/plugins/fancybox/source/jquery.fancybox.pack.js?v=2.1.5') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset($config->get('assets_path') . '/js/inspinia.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset($config->get('assets_path') . '/js/plugins/pace/pace.min.js') }}"></script>

@section('scaffold.js')
    <script>
        $(function () {
            $('.fancybox').fancybox({
                afterLoad: function () {
                    var width, height;
                    if (width = $(this.element).data('width')) {
                        this.width = width;
                    }

                    if (height = $(this.element).data("height")) {
                        this.height = height;
                    }
                }
            });
        });
    </script>
@append

@yield('scaffold.js')
</body>
</html>
