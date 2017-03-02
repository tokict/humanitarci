@extends('layouts.admin')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Create new admin</h5>
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
                        {!! Form::open(['url' => '/admin/user/create', 'class' => 'form-horizontal']) !!}
                        {{Form::token()}}
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Organization</label>
                            <div class="col-sm-5">
                                <div class="col-sm-10">
                                    {{Form::select('organization_id', ["" => 'Select'], null, ['class' => 'form-control selectOrganization'])}}
                                    <span class="help-block m-b-none">Admins organization</span>
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <label class="col-sm-2 control-label">Person</label>
                                <div class="col-sm-10">
                                    {{Form::select('person_id', ["" => 'Select'], null, ['class' => 'form-control selectPerson'])}}
                                </div>
                            </div>

                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group"><label class="col-sm-2 control-label">E-mail</label>
                            <div class="col-sm-3">
                                {{Form::text('email', null,['class' =>'form-control' ] )}}
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                                <label class="control-label"></label>
                                <div class="i-checks"><label>
                                        {{Form::checkbox('super_admin' )}}
                                        <i></i> Super admin </label></div>
                                <span class="help-block m-b-none">Is the user superadmin?</span>
                            </div>
                            <label class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-2">
                                {{Form::text('username',null,['class' =>'form-control' ])}}
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
