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
                <ul class="nav nav-tabs tpl-minimal-tabs">

                    <li class="active">
                        <a href="#mini-one" data-toggle="tab">Registracija</a>
                    </li>

                    <li>
                        <a href="#mini-two" data-toggle="tab">Zašto registracija?</a>
                    </li>

                </ul>
            </div>
            <!-- End Nav Tabs -->

            <!-- Tab panes -->
            <div class="tab-content tpl-minimal-tabs-cont section-text">

                <div class="tab-pane fade in active" id="mini-one">

                    <!-- Registry Form -->
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">

                            {!! Form::open(['url' => '/'.trans('routes.front.donors').'/'.trans('routes.actions.registration'), 'class' => 'form-horizontal']) !!}

                            {{Form::token()}}
                            <div class="clearfix">

                                <!-- Email -->
                                <div class="form-group">
                                    <input type="text" name="email" id="email" class="input-md round form-control"
                                           placeholder="Email" pattern=".{3,100}" required>
                                </div>

                                <!-- Username -->
                                <div class="form-group">
                                    <input type="text" name="username" id="username" class="input-md round form-control"
                                           placeholder="Korisničko ime" pattern=".{6,100}" required>
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <input type="password" name="password" id="password"
                                           class="input-md round form-control" placeholder="Lozinka" pattern=".{5,100}"
                                           required>
                                </div>

                                <!-- Re-enter Password -->
                                <div class="form-group">
                                    <input type="password" name="re-password" id="re-password"
                                           class="input-md round form-control" placeholder="Ponovi lozinku"
                                           pattern=".{5,100}" required>
                                </div>

                            </div>

                            <!-- Send Button -->
                            <div class="pt-10">
                                <button class="submit_btn btn btn-mod btn-medium btn-round btn-full" id="reg-btn">
                                    Potvrdi
                                </button>
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
                    <!-- End Registry Form -->

                </div>

                <div class="tab-pane fade" id="mini-two">

                    Zato sta je caca reka tako!
                </div>

            </div>

        </div>
    </section>
    <!-- End Section -->
@endsection
