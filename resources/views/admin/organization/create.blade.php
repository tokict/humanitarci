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
                        <form method="post" class="form-horizontal" action="/admin/organization/create">
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

                                <div class="col-sm-3">
                                    <label class="control-label">Parent company</label>
                                    <select class="form-control selectEntity" name="legal_entity_id">
                                        <option value="">Select</option>

                                    </select>
                                    <span class="help-block m-b-none">Legal entity taht operates it</span>
                                </div>


                                <div class="col-sm-3">
                                    <label class="control-label">City</label>
                                    <select class="form-control citySelect" name="city_id">
                                        <option value="">Select</option>

                                    </select>
                                    <span class="help-block m-b-none">City of operations</span>
                                </div>

                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-3">
                                    <label class="control-label">Donations address</label>
                                    <input type="text"
                                           class="form-control"
                                           name="address"
                                           maxlength="150">
                                    <span class="help-block m-b-none">Where does it accept donations</span>
                                </div>
                                <div class="col-sm-2">
                                    <label class="control-label">Phone</label>
                                    <input type="text"
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
                                    <label class="control-label">Represented by</label>
                                    <select class="form-control selectPerson" name="represented_by">
                                        <option value="">Select</option>
                                    </select>
                                    <span class="help-block m-b-none">Responsible person</span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-2">
                                    <label class="control-label">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="">Select</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-6">
                                    <label class="control-label">Logo</label>
                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                        <div class="form-control" data-trigger="fileinput"><i
                                                    class="glyphicon glyphicon-file fileinput-exists"></i> <span
                                                    class="fileinput-filename"></span></div>
                                        <span class="input-group-addon btn btn-default btn-file"><span
                                                    class="fileinput-new">Select file</span><span
                                                    class="fileinput-exists">Change</span><input type="file" name="image"></span>
                                        <a href="#" class="input-group-addon btn btn-default fileinput-exists"
                                           data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-10">
                                    <label class="control-label">Description</label>
                                    <textarea
                                           class="form-control"
                                           name="description"
                                           ></textarea>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-10">
                                    <label class="control-label">Donations coordinates</label>
                                    <input class="form-control" name="donations_coordinates">
                                    <div class="coordinatesPicker" style="height:400px"></div>

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
