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
                                    <th>Title</th>
                                    <th>First name</th>
                                    <th>Middle name</th>
                                    <th>Last Name</th>
                                    <th>Gender</th>
                                    <th>Social id</th>
                                    <th>City</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Social accounts</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($persons as $person)
                                    <tr class="gradeX">
                                        <td>{{ $person->title }}</td>
                                        <td>{{ $person->first_name }}</td>
                                        <td class="center">{{ $person->middle_name }}</td>
                                        <td>{{ $person->last_name }}</td>
                                        <td class="center">{{ $person->gender }}</td>
                                        <td class="center">{{ $person->social_id }}</td>
                                        <td class="center">{{ $person->city->name }}</td>
                                        <td class="center">{{ $person->address }}</td>
                                        <td class="center">{{ $person->contact_phone }}</td>
                                        <td class="center">{{ $person->contact_email }}</td>
                                        <td class="center">{{ $person->social_accounts }}</td>
                                        <td class="center">
                                            <a href="/admin/person/view/{{$person->id}}"
                                               target="_blank" class="btn btn-sm btn-default">
                                                <i class="fa fa-list"></i> Details</a>
                                            <a href="/admin/person/edit/{{$person->id}}"
                                               class="btn btn-sm btn-default"><i class="fa fa-edit"></i> Edit</a>
                                        </td>
                                    </tr>

                                @endforeach




                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Title</th>
                                    <th>First name</th>
                                    <th>Middle name</th>
                                    <th>Last Name</th>
                                    <th>Gender</th>
                                    <th>Social id</th>
                                    <th>City</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Social accounts</th>
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