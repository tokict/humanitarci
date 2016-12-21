<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="/front/images/humanitarci-icon.png">

    <title>Add title
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="/administrator/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/administrator/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- date picker -->
    <link rel="stylesheet" href="/administrator/plugins/datepicker/datepicker3.css">

    <link href="/administrator/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/administrator/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <!-- daterange picker -->
    <link rel="stylesheet"
          href="/administrator/plugins/daterangepicker/daterangepicker-bs3.css">

    {{--jasny--}}
    <link href="/administrator/css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">
    {{--Select2--}}
    <link href="/administrator/css/plugins/select2/select2.min.css" rel="stylesheet">

    {{--summernote--}}
    <link href="/administrator/css/plugins/summernote/summernote.css" rel="stylesheet">
    <link href="/administrator/css/plugins/summernote/summernote-bs3.css" rel="stylesheet">

    {{--ClockPicker--}}
    <link href="/administrator/css/plugins/clockpicker/clockpicker.css" rel="stylesheet">

    {{--DatePicker--}}
    <link href="/administrator/css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    <link href="/administrator/css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">

    <!-- FooTable -->
    <link href="/administrator/css/plugins/footable/footable.core.css" rel="stylesheet">



    <!-- Theme style -->
    <link rel="stylesheet" href="/administrator/css/animate.css">
    <link rel="stylesheet" href="/administrator/css/style.css">
    <link rel="stylesheet" href="/administrator/css/extended.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->


    <!-- iCheck -->
    <link rel="stylesheet" href="/administrator/plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet"
          href="/administrator/plugins/fancybox/source/jquery.fancybox.css?v=2.1.5"
          type="text/css" media="screen"/>

    <style>
        [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
            display: none !important;
        }
    </style>
    <!-- jQuery 2.1.4 -->
    <script src="/administrator/plugins/jQuery/jQuery-2.1.4.min.js"></script>
</head>
<body>
<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <span>
                            <img alt="image" class="img-responsive" src="/front/images/humanitarci-logo-small.png" />
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                        <span class="clear">
                                            <span class="block m-t-xs">
                                                <strong class="font-bold">{{\Illuminate\Support\Facades\Auth::User()->username}}</strong>
                                             </span>
                                            <span class="text-muted text-xs block">{{\Illuminate\Support\Facades\Auth::User()->super_admin?'Super Admin':'Admin'}}
                                                <b class="caret"></b>
                                            </span>
                                        </span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="profile.html">Profile</a></li>
                            <li><a href="contacts.html">Contacts</a></li>
                            <li><a href="mailbox.html">Mailbox</a></li>
                            <li class="divider"></li>
                            <li><a href="/auth/logout">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
                <li class="{{$controller == 'AdminController'?'active':''}}">
                    <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Weekly overviews</span> <span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level {{$controller == 'AdminController'?'collapse in':''}}">
                        <li class="{{$controller == 'AdminController' && $action == 'campaigns'?'active':''}}"><a href="/admin/overview/campaigns">Campaigns</a></li>
                        <li class="{{$controller == 'AdminController' && $action == 'donations'?'active':''}}"><a href="/admin/overview/donations">Donations</a></li>
                        <li class="{{$controller == 'AdminController' && $action == 'donors'?'active':''}}"><a href="/admin/overview/donors">Donors</a></li>
                        <li class="{{$controller == 'AdminController' && $action == 'distributions'?'active':''}}"><a href="/admin/overview/distributions">Distribution</a></li>
                        <li class="{{$controller == 'AdminController' && $action == 'incomes'?'active':''}}"><a href="/admin/overview/incomes">Incomes </a></li>
                        <li class="{{$controller == 'AdminController' && $action == 'transactions'?'active':''}}"><a href="/admin/overview/incomes">Internal transactions </a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-dot-circle-o"></i> <span class="nav-label">Campaigns</span> <span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level {{$controller == 'CampaignController'?'collapse in':''}}">
                        <li class="{{$controller == 'CampaignController' && $action == 'create'?'active':''}}"><a
                                    href="/admin/campaign/create">New campaign</a></li>
                        <li class="{{$controller == 'CampaignController' && $action == 'listing'?'active':''}}"><a
                                    href="/admin/campaign/listing">List</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-heart"></i> <span class="nav-label">Donations</span> <span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level {{$controller == 'DonationController'?'collapse in':''}}">
                        <li class="{{$controller == 'DonationController' && $action == 'listing'?'active':''}}"><a
                                    href="/admin/donation/listing">List</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-user-circle-o"></i> <span class="nav-label">Beneficiaries</span> <span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level {{$controller == 'BeneficiaryController'?'collapse in':''}}">
                        <li class="{{$controller == 'BeneficiaryController' && $action == 'create'?'active':''}}"><a
                                    href="/admin/beneficiary/create">New beneficiary</a></li>
                        <li class="{{$controller == 'BeneficiaryController' && $action == 'listing'?'active':''}}"><a
                                    href="/admin/beneficiary/listing">List</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-handshake-o"></i> <span class="nav-label">Donors</span> <span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level {{$controller == 'DonorController'?'collapse in':''}}">
                        <li class="{{$controller == 'DonorController' && $action == 'create'?'listing':''}}"><a
                                    href="/admin/donor/listing">List</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Persons</span> <span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level {{$controller == 'PersonController'?'collapse in':''}}">
                        <li class="{{$controller == 'PersonController' && $action == 'create'?'active':''}}"><a
                                    href="/admin/person/create">New person</a></li>
                        <li class="{{$controller == 'PersonController' && $action == 'create'?'listing':''}}"><a
                                    href="/admin/person/listing">List</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-bank"></i> <span class="nav-label">Legal entities</span> <span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level {{$controller == 'LegalEntityController'?'collapse in':''}}">
                        <li class="{{$controller == 'LegalEntityController' && $action == 'create'?'active':''}}"><a
                                    href="/admin/legal-entity/create">New entity</a></li>
                        <li class="{{$controller == 'LegalEntityController' && $action == 'listing'?'active':''}}"><a
                                    href="/admin/legal-entity/listing">List</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-list-alt"></i> <span class="nav-label">Reports</span> <span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">

                    </ul>
                </li>
                @if(Auth::User()->super_admin)
                <li>
                    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">Administration</span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse in">
                        <li>
                            <a href="#">Banks <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level {{$controller == 'BankController'?'collapse in':''}}">
                                <li class="{{$controller == 'BankController' && $action == 'create'?'active':''}}">
                                    <a href="/admin/bank/create">New bank</a>
                                </li>
                                <li class="{{$controller == 'BankController' && $action == 'listing'?'active':''}}">
                                    <a href="/admin/bank/listing">List</a>
                                </li>

                            </ul>
                        </li>
                        <li>
                            <a href="#">Organizations <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level {{$controller == 'OrganizationController'?'collapse in':''}}">
                                <li class="{{$controller == 'OrganizationController' && $action == 'create'?'active':''}}">
                                    <a href="/admin/organization/create">New organization</a>
                                </li>
                                <li class="{{$controller == 'OrganizationController' && $action == 'listing'?'active':''}}">
                                    <a href="/admin/organization/listing">List</a>
                                </li>

                            </ul>
                        </li>
                        <li>
                            <a href="#">Users <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level {{$controller == 'UserController'?'collapse in':''}}">
                                <li class="{{$controller == 'UserController' && $action == 'create'?'active':''}}">
                                    <a href="/admin/user/create">New administrator</a>
                                </li>
                                <li class="{{$controller == 'UserController' && $action == 'listing'?'active':''}}">
                                    <a href="/admin/user/listing">List</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Logs <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level {{$controller == 'LogController'?'collapse in':''}}">
                                <li class="{{$controller == 'LogController' && $action == 'listing'?'active':''}}">
                                    <a href="/admin/log/listing">List</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <li>
                        <a href="/admin/settings/all">Settings </a>

                    </li>
                </li>
                @endif
            </ul>

        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">

                    <form role="search" class="navbar-form-custom" action="search_results.html">
                        <div class="form-group">
                            <input type="text" placeholder="Search for something..." class="form-control"
                                   name="top-search" id="top-search">
                        </div>
                    </form>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <span class="m-r-sm text-muted welcome-message">{{Auth::User()->admin->organization->name}}</span>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-envelope"></i> <span class="label label-warning">16</span>
                        </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
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
                                    </a>
                                    <div class="media-body ">
                                        <small class="pull-right text-navy">5h ago</small>
                                        <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica
                                            Smith</strong>. <br>
                                        <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
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
                        <a href="{{ url('logout') }}">
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
        @yield('content')
    </div>
    <div class="modal inmodal fade" id="fileModal" tabindex="-1" role="dialog" aria-hidden="true">
        <script type="text/javascript">
            var modal;
            var dir;
            var selectedFiles = [];
            var invoker;
            var input;
            var filterType = 'all';
            var page = 1;
        </script>
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="height: 600px; overflow: auto;">
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>



<!-- Bootstrap 3.3.5 -->
<script src="/administrator/bootstrap/js/bootstrap.min.js"></script>
{{--Datatables --}}
<script src="/administrator/js/plugins/dataTables/datatables.min.js" type="text/javascript"></script>
<!-- Flot -->
<script src="/administrator/js/plugins/flot/jquery.flot.js"></script>
<script src="/administrator/js/plugins/flot/jquery.flot.categories.js"></script>
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

<!-- Jasny -->
<script src="/administrator/js/plugins/jasny/jasny-bootstrap.min.js"></script>


<!-- Toastr -->
<script src="/administrator/js/plugins/toastr/toastr.min.js"></script>

<script src="/administrator/plugins/daterangepicker/moment.min.js"></script>
<script src="/administrator/plugins/daterangepicker/daterangepicker.js"></script>
<!-- metisMenu -->
<script src="/administrator/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<!-- SlimScroll -->
<script src="/administrator/plugins/slimScroll/jquery.slimscroll.min.js"></script>
{{--<!-- FastClick -->--}}
{{--<script src="/administrator/plugins/fastclick/fastclick.min.js"></script>--}}

        <!-- Select2 -->
<script src="/administrator/js/plugins/select2/select2.full.min.js"></script>


<!-- date-picker -->
<script src="/administrator/plugins/datepicker/bootstrap-datepicker.js"></script>

<script type="text/javascript"
        src="/administrator/plugins/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

{{--iCheck--}}
<script src="/administrator/js/plugins/iCheck/icheck.min.js"></script>

<!-- SUMMERNOTE -->
<script src="/administrator/js/plugins/summernote/summernote.min.js"></script>

<!-- Clock picker -->
<script src="/administrator/js/plugins/clockpicker/clockpicker.js"></script>

<!-- Data picker -->
<script src="/administrator/js/plugins/datapicker/bootstrap-datepicker.js"></script>

<script type="text/javascript"
        src="/administrator/js/plugins/jQuery-File-Upload-master/js/jquery.fileupload.js"></script>

<!-- FooTable -->
<script src="/administrator/js/plugins/footable/footable.all.min.js"></script>


<!-- AdminLTE App -->
<script src="/administrator/js/inspinia.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/administrator/js/plugins/pace/pace.min.js"></script>
<script src="/administrator/js/pages/listings.js"></script>
<script src="/administrator/js/pages/create.js"></script>
<script src="/administrator/js/shared.js"></script>
<script src="/administrator/js/filemanager.js"></script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAw-IJobkXTjBne6HW-naXFKbXZ_BqqbVM&callback=initMap">
</script>

</body>
</html>