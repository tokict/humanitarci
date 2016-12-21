@extends('layouts.full')

@section('content')
        <!-- Page Loader -->
<div class="page-loader">
    <div class="loader">Loading...</div>
</div>
<!-- End Page Loader -->

<!-- Page Wrap -->
<div class="page" id="top">

    <!-- Section -->
    <section class="page-section">
        <div class="container relative">

            <!-- Nav Tabs -->
            <div class="align-center mb-40 mb-xxs-30">



                        <h4>Prijava</h4>



            </div>
            <!-- End Nav Tabs -->

            <!-- Tab panes -->
            <div class="tab-content tpl-minimal-tabs-cont section-text">

                <div class="tab-pane fade in active" id="mini-one">
                    <!-- Login Form -->
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">

                            {!! Form::open(['url' => '/'.trans('routes.front.donors').'/'.trans('routes.actions.login'), 'class' => 'form-horizontal']) !!}

                            {{Form::token()}}
                            <div class="clearfix">

                                <!-- Username -->
                                <div class="form-group">
                                    <input type="text" name="email" id="email" class="input-md round form-control"
                                           placeholder="Email" pattern=".{3,100}" required>
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <input type="password" name="password" id="password"
                                           class="input-md round form-control" placeholder="Password" pattern=".{5,100}"
                                           required>
                                </div>

                            </div>

                            <div class="clearfix">

                                <div class="cf-left-col">

                                    <!-- Inform Tip -->
                                    <div class="form-tip pt-20">
                                        <a href="">Zaboravljena lozinka?</a>
                                    </div>

                                </div>

                                <div class="cf-right-col">

                                    <!-- Send Button -->
                                    <div class="align-right pt-10">
                                        <button class="submit_btn btn btn-mod btn-medium btn-round" id="login-btn">
                                            Prijava
                                        </button>
                                    </div>
                                </div>

                            </div>

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)

                                            <li>{{ trans('errors.login.'.substr($error,0, strlen($error)-1)) }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(session()->has('error'))
                                <div class="alert alert-danger">
                                    <ul>
                                        <li>{{session('error')}}</li>
                                    </ul>
                                </div>
                            @endif

                            {!! Form::close() !!}

                        </div>
                    </div>
                    <!-- End Login Form -->
                </div>
                <div class="align-center pt-100">
                    <a href="/{{trans('routes.front.donors')}}/{{trans('routes.actions.registration')}}" >
                       <button class="btn btn-medium btn-round"> Registracija</button>
                    </a>
                </div>
            </div>

        </div>
    </section>
    <!-- End Section -->
@endsection
