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
                        <form method="post"   enctype="multipart/form-data" class="form-horizontal" action="/admin/beneficiary/create">
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

                                <div class="col-sm-2"><label class="control-label">Phone</label>
                                    <input type="text"
                                           class="form-control"
                                           name="contact_phone"
                                           maxlength="30">
                                </div>

                                <div class="col-sm-3"><label class="control-label">Mail</label>
                                    <input type="text"
                                           class="form-control"
                                           name="contact_email"
                                           maxlength="30">
                                </div>
                                <div class="col-sm-3"><label class="control-label">Profile image</label>
                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                        <div class="form-control" data-trigger="fileinput"><i
                                                    class="glyphicon glyphicon-file fileinput-exists"></i> <span
                                                    class="fileinput-filename"></span></div>
                                        <span class="input-group-addon btn btn-default btn-file"><span
                                                    class="fileinput-new">Select file</span><span
                                                    class="fileinput-exists">Change</span><input type="file" name="profile_image"></span>
                                        <a href="#" class="input-group-addon btn btn-default fileinput-exists"
                                           data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-3">
                                    <label class="col-sm-2 control-label">Person</label>
                                    <select class="form-control selectPerson" name="person_id">
                                        <option value="">Select</option>

                                    </select>
                                    <span class="help-block m-b-none">Select person if beneficiary is one person</span>
                                </div>

                                <div class="col-sm-3">
                                    <label class="col-sm-2 control-label">Entity</label>
                                    <select class="form-control selectEntity" name="entity_id">
                                        <option value="">Select</option>

                                    </select>
                                    <span class="help-block m-b-none">Select entity if beneficiary is a legal entity</span>
                                </div>


                                <div class="col-sm-3"><label class="control-label">Group</label>
                                    <select class="form-control selectGroup" name="group_id">
                                        <option value="">Select</option>

                                    </select>
                                    <span class="help-block m-b-none">Select group of persons or entities</span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-2"><label class="control-label">Status</label>
                                <select class="form-control m-b" name="status">
                                    <option value="">Select</option>
                                    <option value="0">Active</option>
                                    <option value="1">Inactive</option>

                                </select>
                            </div>
                            <div class="col-sm-4 pull-right">
                                <label class="control-label"></label>
                                <div class="i-checks"><label> <input type="checkbox" value="" name="members_public"> <i></i> Public members </label></div>
                                <span class="help-block m-b-none">Should we show who the members are to public?</span>
                            </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-10"><label class="control-label">Description</label>
                                    <textarea type="text"
                                           class="summernote"
                                           name="description"
                                           ></textarea>
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
