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
                        <form method="post" class="form-horizontal" action="/admin/campaign/create">
                            {{csrf_field()}}
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>

                                <div class="col-sm-4"><label class="control-label">Name</label>
                                    <input type="text"
                                           class="form-control"
                                           name="name"
                                           maxlength="30">
                                </div>

                                <div class="col-sm-3">
                                    <label class="control-label">Beneficiary</label>
                                    <select class="form-control selectBeneficiary" name="beneficiary_id">
                                        <option value="">Select</option>
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                    <label class="control-label">Organization</label>
                                    <select class="form-control selectOrganization" name="organization_id">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-2">
                                    <label class="control-label">Type</label>
                                    <select class="form-control" name="type">
                                        <option value="">Select</option>
                                        <option value="cash">Money</option>
                                        <option value="goods">Goods</option>
                                        <option value="service">Service</option>
                                    </select>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-2"><label class="control-label">Target amount</label>
                                    <input type="number"
                                           class="form-control"
                                           name="target_amount"
                                           maxlength="30">
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
                                    <textarea
                                            class="form-control summernote"
                                            name="short_description"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-10"><label class="control-label">Full description</label>
                                    <textarea
                                            class="form-control summernote"
                                            name="full_description"></textarea>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-2">
                                    <label class="control-label">Cover photo</label>
                                    <select class="form-control" name="cover_photo_id">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <label class="control-label">Campaign photos</label>
                                    <select class="form-control" name="media_info">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-2">
                                    <label class="control-label">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="">Select</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="goal_reached">Goal reached</option>
                                        <option value="goal_failed">Goal failed</option>
                                        <option value="blocked">Blocked</option>
                                        <option value="ended">Ended</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <label class="control-label">Priority</label>
                                    <select class="form-control" name="priority">
                                        <option value="">Select</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
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
