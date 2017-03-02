@extends('layouts.admin')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Create new bank</h5>
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
                        {!! Form::open(['url' => '/admin/group/create', 'class' => 'form-horizontal']) !!}
                        {{Form::token()}}
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>

                                <div class="col-sm-5"><label class="control-label">Name</label>
                                    {{Form::text('name', null,['class' =>'form-control' ] )}}
                                </div>

                                <div class="col-sm-4"><label class="control-label">Description</label>
                                    {{Form::textarea('description', null,['class' =>'form-control' ] )}}
                                </div>

                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-lg-5">
                                    <label class="control-label">Representing legal entity</label>
                                    {{Form::select('representing_entity_id', [], null, ['class' => 'form-control selectEntity'])}}
                                </div>
                                <div class="col-lg-5">
                                    <label class="control-label">Representing person</label>
                                    {{Form::select('representing_person_id', [], null, ['class' => 'form-control selectPerson'])}}
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <a class="btn btn-white" href="/admin/group/listing">Cancel</a>
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
