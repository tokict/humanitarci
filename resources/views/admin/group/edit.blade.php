@extends('layouts.admin')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Edit bank</h5>
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
                            {!! Form::open(['url' => '/admin/group/edit/'.$group->id, 'class' => 'form-horizontal']) !!}
                            {{Form::model($group)}}
                            {{Form::token()}}
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>

                                <div class="col-sm-5"><label class="control-label">Name</label>
                                    {{Form::text('name', null,['class' =>'form-control' ] )}}
                                </div>

                                <div class="col-sm-4"><label class="control-label">Swift</label>
                                    {{Form::textarea('description', null,['class' =>'form-control' ] )}}
                                </div>

                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                    <div class="col-lg-5">
                                        <label class="control-label">Representing legal entity</label>
                                        @if($group->legalEntity)
                                            {{Form::select('representing_entity_id',
                                            [
                                            $group->legalEntity->id => $group->legalEntity->name],
                                            $group->legalEntity->id, ['class' => 'form-control selectEntity'])}}
                                        @else
                                            {{Form::select('representing_entity_id', ["" => "Select"], null, ['class' => 'form-control selectEntity'])}}
                                        @endif


                                    </div>
                                <div class="col-lg-5">
                                    <label class="control-label">Representing person</label>
                                    @if($group->representingPerson)
                                        {{Form::select('representing_person_id',
                                        [
                                        $group->representingPerson->id => $group->representingPerson->first_name.' '.$group->representingPerson->last_name],
                                        $group->representingPerson->id, ['class' => 'form-control selectPerson'])}}
                                    @else
                                        {{Form::select('representing_person_id', ["" => "Select"], null, ['class' => 'form-control selectPerson'])}}
                                    @endif

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
