@extends('layouts.admin')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Create new organization</h5>
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
                            {!! Form::open(['url' => '/admin/organization/create', 'class' => 'form-horizontal']) !!}
                            {{Form::model($organization)}}
                            {{Form::token()}}
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>

                                <div class="col-sm-2"><label class="control-label">Name</label>
                                    {{Form::text('name', null,['class' =>'form-control' ] )}}
                                </div>

                                <div class="col-sm-3">
                                    <label class="control-label">Parent company</label>
                                    {{Form::select('legal_entity_id', ["" => 'Select'], null, ['class' => 'form-control selectEntity'])}}
                                    <span class="help-block m-b-none">Legal entity that operates it</span>
                                </div>


                                <div class="col-sm-3">
                                    <label class="control-label">City</label>
                                    {{Form::select('city_id', ["" => 'Select'], null, ['class' => 'form-control selectCity'])}}
                                    <span class="help-block m-b-none">City of operations</span>
                                </div>

                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-3">
                                    <label class="control-label">Donations address</label>
                                    {{Form::text('address', null,['class' =>'form-control' ] )}}
                                    <span class="help-block m-b-none">Where does it accept donations</span>
                                </div>
                                <div class="col-sm-2">
                                    <label class="control-label">Phone</label>
                                    {{Form::text('contact_phone', null,['class' =>'form-control' ] )}}
                                    <span class="help-block m-b-none">Contact phone</span>
                                </div>

                                <div class="col-sm-3">
                                    <label class="control-label">Email</label>
                                    {{Form::email('contact_email', null,['class' =>'form-control' ] )}}
                                    <span class="help-block m-b-none">Contact email</span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-2">
                                    <label class="control-label">Represented by</label>
                                    {{Form::select('represented_by', ["" => 'Select'], null, ['class' => 'form-control selectPerson'])}}
                                    <span class="help-block m-b-none">Responsible person</span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-2">
                                    <label class="control-label">Status</label>
                                    {{Form::select('status', [$organization->getEnumvalues('status')], null, ['class' => 'form-control'])}}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-6">
                                    <label class="control-label">Logo</label>
                                    {{Form::hidden('image')}}
                                    <button type="button" class=" btn btn-default fileSelect" data-toggle="modal" data-target="#fileModal">Select</button>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-10">
                                    <label class="control-label">Description</label>
                                    {{Form::textarea('description', null,['class' =>'form-control' ] )}}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-10">
                                    <label class="control-label">Donations coordinates</label>
                                    {{Form::text('donations_coordinates', null,['class' =>'form-control' ] )}}
                                    <div class="coordinatesPicker" style="height:400px"></div>

                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="/admin/bank/listing">Cancel</a>
                                    <button class="btn btn-primary" type="submit">Save changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
