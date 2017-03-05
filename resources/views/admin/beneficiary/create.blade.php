@extends('layouts.admin')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Create new beneficiary</h5>
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
                        {!! Form::open(['url' => '/admin/beneficiary/create', 'class' => 'form-horizontal']) !!}
                        {{Form::token()}}
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>

                            <div class="col-sm-2"><label class="control-label">Name</label>
                                {{Form::text('name', null,['class' =>'form-control' ] )}}
                            </div>

                            <div class="col-sm-2"><label class="control-label">Phone</label>
                                {{Form::text('contact_phone', null,['class' =>'form-control' ] )}}
                            </div>

                            <div class="col-sm-3"><label class="control-label">Mail</label>
                                {{Form::text('contact_email', null,['class' =>'form-control' ] )}}
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-3">
                                <label class="control-label">Profile image</label><br/>
                                {{Form::hidden('profile_image_id')}}
                                <button type="button" class=" btn btn-default fileSelect" data-toggle="modal"
                                        data-target="#fileModal">Select image
                                </button>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">Beneficiary photos</label><br/>
                                {{Form::hidden('media_info')}}
                                <button type="button" class=" btn btn-default fileSelect" data-toggle="modal"
                                        data-target="#fileModal">Select images
                                </button>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-3">
                                <label class="col-sm-2 control-label">Person</label>
                                {{Form::select('person_id', ["" => 'Select'], null, ['class' => 'form-control selectPerson'])}}
                                <span class="help-block m-b-none">Select person if beneficiary is one person</span>
                            </div>

                            <div class="col-sm-3">
                                <label class="col-sm-2 control-label">Entity</label>
                                {{Form::select('entity_id', ["" => 'Select'], null, ['class' => 'form-control selectEntity'])}}
                                <span class="help-block m-b-none">Select entity if beneficiary is a legal entity</span>
                            </div>


                            <div class="col-sm-3"><label class="control-label">Group</label>
                                {{Form::select('group_id', ["" => 'Select'], null, ['class' => 'form-control selectGroup'])}}
                                <span class="help-block m-b-none">Select group of persons or entities</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-2"><label class="control-label">Status</label>
                                {{Form::select('status', $beneficiary->getEnumValues('status'), null, ['class' => 'form-control'])}}
                            </div>
                            <div class="col-sm-4 pull-right">
                                <label class="control-label"></label>
                                <div class="i-checks"><label>
                                        {{Form::checkbox('members_public' )}}
                                        <i></i> Public members </label></div>
                                <span class="help-block m-b-none">Should we show who the members are to public?</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-10"><label class="control-label">Description</label>
                                {{Form::textarea('description', null, [] )}}

                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a class="btn btn-white" href="/admin/beneficiary/listing">Cancel</a>
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
