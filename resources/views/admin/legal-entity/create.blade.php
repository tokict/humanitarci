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
                        <form method="post" enctype="multipart/form-data" class="form-horizontal" action="/admin/legal-entity/create">
                            {{csrf_field()}}
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>

                                <div class="col-sm-2"><label class="control-label">Name</label>
                                    <input type="text"
                                           class="form-control"
                                           name="name"
                                           maxlength="30">
                                </div>

                                <div class="col-sm-2"><label class="control-label">Tax id</label>
                                    <input type="text"
                                           class="form-control"
                                           name="tax_id"
                                           maxlength="30">
                                </div>


                                <div class="col-sm-3">
                                    <label class="control-label">Current city</label>
                                    <select class="form-control citySelect" name="city_id">
                                        <option value="">Select</option>

                                    </select>
                                    <span class="help-block m-b-none">City of residence</span>
                                </div>


                                <div class="col-sm-3">
                                    <label class="control-label">Address</label>
                                    <input type="text"
                                           class="form-control"
                                           name="address"
                                           maxlength="150">
                                    <span class="help-block m-b-none">Headquarters address</span>
                                </div>

                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-2">
                                    <label class="control-label">Phone</label>
                                    <input type="number"
                                           class="form-control"
                                           name="contact_phone">
                                    <span class="help-block m-b-none">Contact phone</span>
                                </div>

                                <div class="col-sm-3">
                                    <label class="control-label">Email</label>
                                    <input type="email"
                                           class="form-control"
                                           name="contact_email"
                                           maxlength="100">
                                    <span class="help-block m-b-none">Contact email</span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-2">
                                    <label class="control-label">Bank</label>
                                    <select class="form-control" name="bank_id">
                                        <option value="">Select</option>
                                        @foreach($banks as $bank)
                                            <option value="{{$bank->id}}">{{$bank->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block m-b-none">Select bank</span>
                                </div>

                                <div class="col-sm-3">
                                    <label class="control-label">Bank account</label>
                                    <input type="text"
                                           class="form-control"
                                           name="bank_acc"
                                           maxlength="100">
                                    <span class="help-block m-b-none">Bank acc number</span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-2">
                                    <label class="control-label">Represented by</label>
                                    <select class="form-control selectPerson" name="represented_by">
                                        <option value="">Select</option>
                                    </select>
                                    <span class="help-block m-b-none">Responsible person</span>
                                </div>
                            </div>


                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-white" type="submit">Cancel</button>
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
