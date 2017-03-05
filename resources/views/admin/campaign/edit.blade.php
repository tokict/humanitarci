@extends('layouts.admin')
@section('content')


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Edit campaign</h5>
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
                                    @if(session()->has('error'))
                                        <li>{{session('error')}}</li>
                                    @endif
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
                        {!! Form::open(['url' => '/admin/campaign/edit/'.$campaign->id, 'class' => 'form-horizontal']) !!}
                        {{Form::model($campaign)}}
                        {{Form::token()}}
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>

                            <div class="col-sm-4"><label class="control-label">Name</label>
                                {{Form::text('name', null,['class' =>'form-control' ] )}}
                            </div>

                            <div class="col-sm-3">
                                <label class="control-label">Beneficiary</label>
                                {{Form::select('beneficiary_id', [$campaign->beneficiary->id => $campaign->beneficiary->name], $campaign->beneficiary->name, ['class' => 'form-control selectBeneficiary'])}}

                            </div>

                            <div class="col-sm-3">
                                <label class="control-label">Organization</label>
                                {{Form::select('organization_id', [$campaign->organization->id =>$campaign->organization->name], $campaign->organization->name, ['class' => 'form-control selectOrganization'])}}
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
                                    <input type="text" class="form-control datepicker" name="start_date"
                                           value="{{date('Y-m-d', strtotime($campaign->starts))}}">
                                </div>
                                <div class="input-group clockpicker" data-autoclose="true">
                                    <input type="text" class="form-control" name="start_time"
                                           value="{{date('H:i', strtotime($campaign->starts))}}">
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">End time</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control datepicker" name="end_date"
                                           value="{{date('Y-m-d', strtotime($campaign->ends))}}">
                                </div>
                                <div class="input-group clockpicker" data-autoclose="true">
                                    <input type="text" class="form-control" name="end_time"
                                           value="{{date('H:i', strtotime($campaign->ends))}}">
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <label class="control-label">Delivery time</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control datepicker" name="action_by_date"
                                           value="{{date('Y-m-d', strtotime($campaign->action_by_date))}}">
                                </div>
                                <div class="input-group clockpicker" data-autoclose="true">
                                    <input type="text" class="form-control" name="action_by_time"
                                           value="{{date('H:i', strtotime($campaign->action_by_date))}}">
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
                                {{Form::textarea('description_short', null,['class' =>'form-control' ] )}}

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
                            <div class="col-sm-4">
                                <label class="control-label">Cover photo</label>
                                {{Form::hidden('cover_photo_id')}}
                                <button type="button" class=" btn btn-default fileSelect" data-toggle="modal"
                                        data-target="#fileModal">Select
                                </button>
                                <div class="row">
                                    <div class="col-md-3 p-b-5">
                                        <img src="{{$campaign->cover->getPath('thumb')}}" class="img-responsive">
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">Campaign photos</label>
                                {{Form::hidden('media_info')}}
                                <button type="button" class="btn btn-default fileSelect" data-toggle="modal"
                                        data-target="#fileModal">Select
                                </button>
                                <div class="row">
                                    @foreach($campaign->campaign_media as $image)
                                        <div class="col-md-3 p-b-5">
                                            <img src="{{$image->getPath('thumb')}}" class="img-responsive">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-2">
                                <label class="control-label">Status</label>
                                {{Form::select('status', $campaign->getEnumValues('status'), null, ['class' => 'form-control'])}}
                            </div>
                            <div class="col-sm-2">
                                <label class="control-label">Priority</label>
                                {{Form::select('priority', [1,2,3,4,5], null, ['class' => 'form-control'])}}
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a class="btn btn-white" href="/admin/bank/listing">Cancel</a>
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
