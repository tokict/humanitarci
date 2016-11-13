@extends('layouts.admin')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Persons listing</h5>
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

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover persons-table" >
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Identifier</th>
                                    <th>Profile image</th>
                                    <th>Donors</th>
                                    <th>Funds used</th>
                                    <th>Person</th>
                                    <th>Group</th>
                                    <th>Entity</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Created by</th>
                                    <th>Public members</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($beneficiaries as $beneficiary)
                                    <tr class="gradeX">
                                        <td>{{ $beneficiary->name }}</td>
                                        <td>{{ $beneficiary->identifier }}</td>
                                        <td class="center">{{ $beneficiary->profile_image_id }}</td>
                                        <td>{{ $beneficiary->donor_number }}</td>
                                        <td>{{ $beneficiary->funds_used }}</td>
                                        <td class="center">{{ isset($beneficiary->person)?$beneficiary->person->first_name:"" }}
                                            {{ isset($beneficiary->person)?$beneficiary->person->last_name:""}}</td>
                                        <td class="center">{{ isset($beneficiary->group)?$beneficiary->group->name:"" }}</td>
                                        <td class="center">{{ isset($beneficiary->entity)?$beneficiary->entity->name:"" }}</td>
                                        <td class="center">{{ $beneficiary->contact_phone }}</td>
                                        <td class="center">{{ $beneficiary->contact_email }}</td>
                                        <td class="center">{{ $beneficiary->creator->user->person->first_name }}
                                        {{ $beneficiary->creator->user->person->last_name }}</td>
                                        <td class="center">{{ isset($beneficiary->members_public)?"Yes":"No" }}</td>
                                        <td class="center">
                                            <a href="#" class="btn btn-sm btn-primary">View</a>
                                            <a href="#" class="btn btn-sm btn-primary">Edit</a>
                                            <a href="#" class="btn btn-sm btn-primary">Lock</a>
                                        </td>
                                    </tr>

                                @endforeach




                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Identifier</th>
                                    <th>Profile image</th>
                                    <th>Donors</th>
                                    <th>Funds used</th>
                                    <th>Person</th>
                                    <th>Group</th>
                                    <th>Entity</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Created by</th>
                                    <th>Public members</th>
                                    <th>Actions</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection