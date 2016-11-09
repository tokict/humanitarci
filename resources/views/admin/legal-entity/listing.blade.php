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
                                    <th>Tax id</th>
                                    <th>City</th>
                                    <th>Address</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Bank</th>
                                    <th>Bank acc</th>
                                    <th>Roles</th>
                                    <th>Represented by</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($legalEntities as $entity)
                                    <tr class="gradeX">
                                        <td>{{ $entity->name }}</td>
                                        <td class="center">{{ $entity->tax_id }}</td>
                                        <td>{{ $entity->city->name }}</td>
                                        <td>{{ $entity->address }}</td>
                                        <td>{{ $entity->contact_email }}</td>
                                        <td>{{ $entity->contact_phone }}</td>
                                        <td>{{ isset( $entity->bank)?$entity->bank->name:"" }}</td>
                                        <td class="center">{{ $entity->bank_acc }}</td>
                                        <td>{{ $entity->roles }}</td>
                                        <td>{{ $org->person->first_name }} {{$org->person->last_name}}</td>


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
                                    <th>Tax id</th>
                                    <th>City</th>
                                    <th>Address</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Bank</th>
                                    <th>Bank acc</th>
                                    <th>Roles</th>
                                    <th>Represented by</th>
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