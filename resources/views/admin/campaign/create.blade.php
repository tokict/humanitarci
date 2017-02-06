@extends('layouts.admin')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Create new campaign</h5>
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
                        {!! Form::open(['url' => '/admin/campaign/create', 'class' => 'form-horizontal']) !!}
                        {{Form::token()}}
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>

                            <div class="col-sm-4"><label class="control-label">Name</label>
                                {{Form::text('name', null,['class' =>'form-control' ] )}}
                            </div>

                            <div class="col-sm-3">
                                <label class="control-label">Beneficiary</label>
                                {{Form::select('beneficiary_id', ["" => 'Select'], null, ['class' => 'form-control selectBeneficiary'])}}
                            </div>

                            <div class="col-sm-3">
                                <label class="control-label">Organization</label>
                                {{Form::select('organization_id', ["" => 'Select'], null, ['class' => 'form-control selectOrganization'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-2"><label class="control-label">Classification</label>
                                {{Form::select('classification_code', $campaign->getEnumValues('classification_code'), null, ['class' =>'form-control' ] )}}
                            </div>
                            <div class="col-sm-2"><label class="control-label">Registration code</label>
                                {{Form::text('registration_code', null,['class' =>'form-control' ] )}}
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-2">
                                <label class="control-label">Type</label>
                                {{Form::select('type', $campaign->getEnumValues('type'), null, ['class' => 'form-control'])}}
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">Iban</label>
                                {{Form::text('iban', null,['class' =>'form-control' ] )}}
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-2"><label class="control-label">Target amount</label>
                                {{Form::number('target_amount', null,['class' =>'form-control' ] )}}
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-3">
                                <label class="control-label">Start time</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control datepicker" name="start_date">
                                </div>
                                <div class="input-group clockpicker" data-autoclose="true">
                                    <input type="text" class="form-control" name="start_time">
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">End time</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control datepicker" name="end_date">
                                </div>
                                <div class="input-group clockpicker" data-autoclose="true">
                                    <input type="text" class="form-control" name="end_time">
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <label class="control-label">Delivery time</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control datepicker" name="action_by_date">
                                </div>
                                <div class="input-group clockpicker" data-autoclose="true">
                                    <input type="text" class="form-control" name="action_by_time">
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-10"><label class="control-label">Short description</label>
                                {{Form::textarea('description_short', null,['class' =>'form-control summernote' ] )}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-10"><label class="control-label">Full description</label>
                                {{Form::textarea('description_full', null,['class' =>'form-control summernote' ] )}}
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-3">
                                <label class="control-label">Cover photo</label>
                                {{Form::hidden('cover_photo_id')}}
                                <button type="button" class=" btn btn-default fileSelect" data-toggle="modal"
                                        data-target="#fileModal" data-single="true">Select
                                </button>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">Campaign photos</label>
                                {{Form::hidden('media_info')}}
                                <button type="button" class="btn btn-default fileSelect" data-toggle="modal"
                                        data-target="#fileModal">Select
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-3">
                                <label class="control-label">Registration request</label>
                                {{Form::hidden('registration_request_doc_id')}}
                                <button type="button" class=" btn btn-default fileSelect" data-toggle="modal"
                                        data-target="#fileModal" data-single="true">Select
                                </button>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">Registration approval</label>
                                {{Form::hidden('registration_doc_id')}}
                                <button type="button" class="btn btn-default fileSelect" data-toggle="modal"
                                        data-target="#fileModal" data-single="true">Select
                                </button>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">Action plan</label>
                                {{Form::hidden('action_plan_doc_id')}}
                                <button type="button" class="btn btn-default fileSelect" data-toggle="modal"
                                        data-target="#fileModal" data-single="true">Select
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-3">
                                <label class="control-label">Distribution plan</label>
                                {{Form::hidden('distribution_plan_doc_id')}}
                                <button type="button" class=" btn btn-default fileSelect" data-toggle="modal"
                                        data-target="#fileModal" data-single="true">Select
                                </button>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">Beneficiary request</label>
                                {{Form::hidden('beneficiary_request_doc_id')}}
                                <button type="button" class="btn btn-default fileSelect" data-toggle="modal"
                                        data-target="#fileModal" data-single="true">Select
                                </button>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            @if(\Illuminate\Support\Facades\Auth::User()->super_admin)
                            <div class="col-sm-2">
                                <label class="control-label">Status</label>

                                {{Form::select('status', $campaign->getEnumValues('status'), 'inactive', ['class' => 'form-control'])}}

                            </div>
                            @endif
                            <div class="col-sm-2">
                                <label class="control-label">Priority</label>
                                {{Form::select('priority', [1,2,3,4,5], null, ['class' => 'form-control'])}}
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a class="btn btn-white" href="/admin/campaign/listing">Cancel</a>
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
