<?php
$user = auth('admin')->user();
$pict = asset($config->get('assets_path') . '/img/admin.png');
?>


<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
{{--            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span>
                        <img alt="image" class="img-circle" src="img/profile_small.jpg"/>
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">{!! $user->name !!}</strong>
                             </span>
                            <span class="text-muted text-xs block">Art Director
                                <b class="caret"></b>
                            </span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="login.html">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li class="active">
                <a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">Overviews</span> <span
                            class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="active"><a href="index.html">Campaigns</a></li>
                    <li><a href="dashboard_2.html">Donations</a></li>
                    <li><a href="dashboard_3.html">New users</a></li>
                    <li><a href="dashboard_4_1.html">Distribution</a></li>
                    <li><a href="dashboard_5.html">Incomes </a></li>
                </ul>
            </li>
            <li class="active">
                <a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">Users</span> <span
                            class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="active"><a href="index.html">Persons</a></li>
                    <li><a href="dashboard_2.html">Donors</a></li>
                    <li><a href="dashboard_3.html">Beneficiaries</a></li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">Administration</span><span
                            class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="#">Third Level <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="#">Third Level Item</a>
                            </li>
                            <li>
                                <a href="#">Third Level Item</a>
                            </li>
                            <li>
                                <a href="#">Third Level Item</a>
                            </li>

                        </ul>
                    </li>
                    <li><a href="dashboard_4_1.html">Persons</a></li>
                    <li><a href="dashboard_5.html">Legal entities </a></li>
                    <li>
                        <a href="/admin/users">Admins</a></li>
                </ul>
            </li>--}}
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">David Williams</strong>
                             </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="#">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            {!! $navigation->render('sidebar', '\Terranet\Administrator\Navigation\Presenters\Bootstrap\SidebarMenuPresenter') !!}
        </ul>

    </div>
</nav>


@section('scaffold.js')
    <script>
        // implement search feature
    </script>
@append
