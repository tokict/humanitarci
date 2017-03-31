@extends('layouts.full')
@section('content')
        <!-- Page Wrap -->
<div class="page" id="top">
    <!-- Contact Section -->
    <section class="page-section" id="contact">
        <div class="container relative">

            <h2 class="section-title font-alt mb-70 mb-sm-40">
                Imate pitanja?
            </h2>

            <!-- Contact Form -->
            <div class="row">
                <div class="col-md-8 col-md-offset-2 m-b-n-lg">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
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
                        @if(session()->has('success'))
                            <div class="alert alert-danger">
                                <ul>
                                    <li>Vaša poruka je uspješno poslana!</li>
                                </ul>
                            </div>
                        @endif
                    {!! Form::open(['url' => "/".trans('routes.front.pages')."/".trans('routes.actions.contacts'), 'class' => 'form contact-form', 'id' => 'contact_form']) !!}
                    {{Form::token()}}
                        <div class="clearfix">

                            <div class="cf-left-col">

                                <!-- Name -->
                                <div class="form-group">
                                    <input type="text" name="name" id="name" class="input-md round form-control" placeholder="Ime i prezime" pattern=".{3,100}" required>
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="input-md round form-control" placeholder="Email" pattern=".{5,100}" required>
                                </div>

                            </div>

                            <div class="cf-right-col">

                                <!-- Message -->
                                <div class="form-group m-b-100">
                                    <textarea name="message" id="message" class="input-md round form-control" style="height: 84px;" placeholder="Poruka"></textarea>
                                </div>

                            </div>

                        </div>

                        <div class="clearfix">

                            <div class="cf-left-col">

                                <!-- Inform Tip -->
                                <div class="form-tip pt-20">
                                    <i class="fa fa-info-circle"></i> Sva polja su obavezna!
                                </div>

                            </div>

                            <div class="cf-right-col">

                                <!-- Send Button -->
                                <div class="align-right pt-10">
                                    <button class="submit_btn btn btn-mod btn-medium btn-round" id="submit_btn">Pošalji poruku</button>
                                </div>
                            </div>


                        </div>



                        <div id="result"></div>
                        {!! Recaptcha::render()  !!}
                    {!!  Form::close()!!}

                </div>
            </div>
            <!-- End Contact Form -->

        </div>
    </section>
    <!-- End Contact Section -->



</div>
<!-- End Page Wrap -->
@endsection