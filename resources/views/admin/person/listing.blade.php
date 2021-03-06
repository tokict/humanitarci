@extends('layouts.admin')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Persons listing</h5>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <div class="col-md-12 text-center">
                                {{$persons->appends($input)->links()}}
                            </div>
                            <table class="table table-striped table-bordered table-hover" >
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
                                        <td class="center">{{ $person->city }}</td>
                                        <td class="center">{{ $person->address }}</td>
                                        <td class="center">{{ $person->contact_phone }}</td>
                                        <td class="center">{{ $person->contact_email }}</td>
                                        <td class="center">{{ $person->social_accounts }}</td>
                                        <td class="center">
                                            <a href="/admin/person/view/{{$person->id}}"
                                                class="btn btn-sm btn-default">
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
                            <div class="col-md-12 text-center">
                                {{$persons->appends($input)->links()}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection