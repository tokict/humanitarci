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
                        <form method="post" class="form-horizontal" action="/admin/person/create">
                            {{csrf_field()}}
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-1">
                                    <label class="control-label">Title</label>
                                    <input type="text" class="form-control" name="title">
                                    <span class="help-block m-b-none">(Mr. Ms. , etc..)</span>
                                </div>

                                <div class="col-sm-2"><label class="control-label">First name</label>
                                    <input type="text"
                                           class="form-control"
                                           name="first_name">
                                </div>

                                <div class="col-sm-2"><label class="control-label">Middle name</label>
                                    <input type="text"
                                           class="form-control"
                                           name="middle_name">
                                </div>

                                <div class="col-sm-2"><label class="control-label">Last name</label>
                                    <input type="text"
                                           class="form-control"
                                           name="last_name">
                                </div>
                                <div class="col-sm-2"><label class="control-label">Gender</label>
                                    <select class="form-control m-b" name="gender">
                                        <option value="-1">Select</option>
                                        <option value="0">Male</option>
                                        <option value="1">Female</option>

                                    </select>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">Social ID</label>
                                <div class="col-sm-10">
                                    <input type="text"
                                           class="form-control"
                                           name="social_id">
                                    <span class="help-block m-b-none">ID that government uses to identify this person (Social security or tax number i.e)</span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">Current city</label>
                                <div class="col-sm-10">
                                    <input type="text"
                                           class="form-control"
                                           name="city_id">
                                    <span class="help-block m-b-none">City of residence</span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">Address</label>
                                <div class="col-sm-10">
                                    <input type="text"
                                           class="form-control"
                                           name="address">
                                    <span class="help-block m-b-none">Current address</span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">Phone</label>
                                <div class="col-sm-10">
                                    <input type="number"
                                           class="form-control"
                                           name="contact_phone">
                                    <span class="help-block m-b-none">Contact phone</span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email"
                                           class="form-control"
                                           name="contact_email">
                                    <span class="help-block m-b-none">Contact email</span>
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


<th>Social id</th>
<th>City</th>
<th>Address</th>
<th>Phone</th>
<th>Email</th>
<th>Social accounts</th>