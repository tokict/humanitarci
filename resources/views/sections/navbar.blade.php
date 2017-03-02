<!-- Menu Wrapper -->
<div class="container">

    <!-- Divider -->
    <hr class="mt-0 mb-0 "/>
    <!-- End Divider -->
    <!-- Navigation panel -->
    <nav class="main-nav mn-centered not-top mb-30">
        <div class="relative clearfix">

            <div class="mobile-nav">
                <i class="fa fa-bars"></i>
            </div>

            <!-- Main Menu -->
            <div class="inner-nav desktop-nav">
                <ul class="clearlist">
                    <li>
                        <a href="/"><img src="/front/images/logo-header.png" width="38" height="55" alt=""/></a>
                    </li>
                    <!-- Item With Sub -->
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <!-- End Item With Sub -->

                    <!-- Item With Sub -->
                    <li>
                        <a href="#" class="mn-has-sub active">Akcije <i class="fa fa-angle-down"></i></a>

                        <!-- Sub -->
                        <ul class="mn-sub">
                            <li><a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}">Sve</a> </li>
                            <li><a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.campaignTypes.food')}}">Hrana</a></li>
                            <li><a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.campaignTypes.medicine')}}">Troškovi liječenja</a></li>
                            <li><a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.campaignTypes.groceries')}}">Namirnice</a></li>
                            <li><a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.campaignTypes.heating')}}">Ogrjev</a></li>
                            <li><a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.campaignTypes.bills')}}">Računi</a></li>
                            <li><a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.campaignTypes.clothing')}}">Odjeća i Obuća</a></li>
                            <li><a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.campaignTypes.books')}}">Knjige za školu</a></li>
                        </ul>
                        <!-- End Sub -->

                    </li>
                    <!-- End Item With Sub -->

                    <li>
                        <a href="#" class="mn-has-sub">O nama <i class="fa fa-angle-down"></i></a>

                        <!-- Sub -->
                        <ul class="mn-sub">
                            <li><a href="/{{trans('routes.front.pages')}}/{{trans('routes.actions.mission')}}">Misija</a></li>
                            <li><a href="/{{trans('routes.front.pages')}}/{{trans('routes.actions.team')}}">Tim</a></li>
                            <li><a href="/{{trans('routes.front.pages')}}/{{trans('routes.actions.history')}}">Dosadašnji rad</a></li>
                            <li><a href="/{{trans('routes.front.pages')}}/{{trans('routes.actions.media')}}">U medijima</a></li>
                        </ul>
                        <!-- End Sub -->
                    </li>

                    <li>
                        <a href="/blog">Blog</a>
                    </li>

                    <li>
                        <a href="/{{trans('routes.front.pages')}}/{{trans('routes.actions.contacts')}}">Kontakt</a>
                    </li>

                    <li>
                        <a href="#" style="height: 75px; line-height: 75px;"><span class="mn-soc-link tooltip-bot"
                                                                                   title=""
                                                                                   data-original-title="Facebook"><i
                                        class="fa fa-facebook"></i></span></a>
                        <a href="#" style="height: 75px; line-height: 75px;"><span class="mn-soc-link tooltip-bot"
                                                                                   title=""
                                                                                   data-original-title="Twitter"><i
                                        class="fa fa-twitter"></i></span></a>
                    </li>

                    <!-- Search -->
                    <li>
                        <a href="#" class="mn-has-sub"><i class="fa fa-search"></i> Traži</a>
                        <ul class="mn-sub">
                            <li>
                                <div class="mn-wrap">
                                    <form method="post" class="form" action="/{{trans('routes.front.search')}}/{{trans('routes.actions.all')}}">
                                        <div class="search-wrap">
                                            <button class="search-button animate" type="submit" title="Start Search">
                                                <i class="fa fa-search"></i>
                                            </button>
                                            <input type="text" class="form-control search-field" placeholder="Traži..." name="query">
                                        </div>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- End Search -->
                    @if(\Illuminate\Support\Facades\Auth::User() == null)
                    <li><a href="/{{trans('routes.front.donors')}}/{{trans('routes.actions.registration')}}" style="height: 75px; line-height: 75px;"><span
                                    class="btn btn-mod btn-circle">Želim pomoći</span></a></li>
                        @else
                        <li><a href="/{{trans('routes.front.donors')}}/{{trans('routes.actions.profile')}}" style="height: 75px; line-height: 75px;"><span
                                    class="btn btn-mod btn-circle btn-gray"> Profil</span></a></li>
                    @endif
                    @if(\Illuminate\Support\Facades\Auth::User())
                    <li><a href="/{{trans('routes.front.donors')}}/{{trans('routes.actions.logout')}}"style="height: 75px; line-height: 75px;"><span
                                    class="btn btn-mod btn-circle btn-gray"><i
                                        class="fa fa-user"></i> Odjava</span></a></li>
                        @else
                        <li><a href="/{{trans('routes.front.donors')}}/{{trans('routes.actions.login')}}"style="height: 75px; line-height: 75px;"><span
                                        class="btn btn-mod btn-circle btn-gray"><i
                                            class="fa fa-user"></i> Prijava</span></a></li>
                    @endif
                    <li><a href="/{{trans('routes.front.donations')}}/{{trans('routes.actions.cart')}}"style="height: 75px; line-height: 75px;"><span
                                    class="btn btn-mod btn-circle btn-gray"><i
                                        class="fa fa-heart"></i> Košarica @if(count(session('donations'))) ({{count(session('donations'))}}) @endif</span></a></li>


                </ul>
            </div>
            <!-- End Main Menu -->
        </div>
    </nav>
    <!-- End Navigation panel -->
</div>
<!-- End Menu Wrapper -->
