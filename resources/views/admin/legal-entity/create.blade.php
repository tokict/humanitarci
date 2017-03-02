@extends('layouts.admin')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Create new legal entity</h5>
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
                        {!! Form::open(['url' => '/admin/legal-entity/create', 'class' => 'form-horizontal']) !!}

                        {{Form::token()}}
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>

                            <div class="col-sm-2"><label class="control-label">Name</label>
                                {{Form::text('name', null,['class' =>'form-control' ] )}}
                            </div>

                            <div class="col-sm-2"><label class="control-label">Tax id</label>
                                {{Form::text('tax_id', null,['class' =>'form-control' ] )}}
                            </div>


                            <div class="col-sm-3">
                                <label class="control-label">Current city</label>
                                {{Form::select('city_id', [], null, ['class' => 'form-control selectCity'])}}
                                <span class="help-block m-b-none">City of residence</span>
                            </div>


                            <div class="col-sm-3">
                                <label class="control-label">Address</label>
                                {{Form::text('address', null,['class' =>'form-control' ] )}}
                                <span class="help-block m-b-none">Headquarters address</span>
                            </div>

                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-2">
                                <label class="control-label">Phone</label>
                                {{Form::text('contact_phone', null,['class' =>'form-control' ] )}}
                                <span class="help-block m-b-none">Contact phone</span>
                            </div>

                            <div class="col-sm-3">
                                <label class="control-label">Email</label>
                                {{Form::text('contact_email', null,['class' =>'form-control' ] )}}
                                <span class="help-block m-b-none">Contact email</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-5">
                                <label class="control-label">Bank</label>
                                {{Form::select('bank_id', $banks, null, ['class' => 'form-control'])}}
                                <span class="help-block m-b-none">Select bank</span>
                            </div>

                            <div class="col-sm-3">
                                <label class="control-label">Bank account</label>
                                {{Form::text('bank_acc', null,['class' =>'form-control' ] )}}
                                <span class="help-block m-b-none">Bank acc number</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-2">
                                <label class="control-label">Represented by</label>
                                {{Form::select('represented_by', [], null, ['class' => 'form-control selectPerson'])}}
                                <span class="help-block m-b-none">Responsible person</span>
                            </div>
                        </div>


                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a class="btn btn-white" href="/admin/legal-entity/listing">Cancel</a>
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
