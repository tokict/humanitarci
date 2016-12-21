@extends('layouts.admin')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Create new person</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
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
                        {!! Form::open(['url' => '/admin/person/create', 'class' => 'form-horizontal']) !!}
                        {{Form::token()}}
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-1">
                                <label class="control-label">Title</label>
                                {{Form::text('title', null,['class' =>'form-control' ] )}}
                                <span class="help-block m-b-none">(Mr. Ms. , etc..)</span>
                            </div>

                            <div class="col-sm-2"><label class="control-label">First name</label>
                                {{Form::text('first_name', null,['class' =>'form-control' ] )}}
                            </div>

                            <div class="col-sm-2"><label class="control-label">Middle name</label>
                                {{Form::text('middle_name', null,['class' =>'form-control' ] )}}
                            </div>

                            <div class="col-sm-2"><label class="control-label">Last name</label>
                                {{Form::text('last_name', null,['class' =>'form-control' ] )}}
                            </div>
                            <div class="col-sm-2"><label class="control-label">Gender</label>
                                {{Form::select('gender', $person->getEnumValues('gender'), null, ['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group"><label class="col-sm-2 control-label">Social ID</label>
                            <div class="col-sm-3">
                                {{Form::text('social_id', null,['class' =>'form-control' ] )}}
                                <span class="help-block m-b-none">ID that government uses to identify this person (Social security or tax number i.e)</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group"><label class="col-sm-2 control-label">Current city</label>
                            <div class="col-sm-5">
                                {{Form::select('city_id', ["" => 'Select'], null, ['class' => 'form-control selectCity'])}}
                                <span class="help-block m-b-none">City of residence</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group"><label class="col-sm-2 control-label">Address</label>
                            <div class="col-sm-4">
                                {{Form::text('address', null,['class' =>'form-control' ] )}}
                                <span class="help-block m-b-none">Current address</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group"><label class="col-sm-2 control-label">Phone</label>
                            <div class="col-sm-2">
                                {{Form::text('contact_phone', null,['class' =>'form-control' ] )}}
                                <span class="help-block m-b-none">Contact phone</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group"><label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-3">
                                {{Form::email('contact_email', null,['class' =>'form-control' ] )}}
                                <span class="help-block m-b-none">Contact email</span>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a class="btn btn-white" href="/admin/person/listing">Cancel</a>
                                <button class="btn btn-primary" type="submit">Save changes</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
