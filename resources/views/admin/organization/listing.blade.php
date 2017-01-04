@extends('layouts.admin')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover organizations-table" >
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Company</th>
                                    <th>City</th>
                                    <th>Donations address</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Represented by</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($organizations as $org)
                                    <tr class="gradeX">
                                        <td>{{ $org->name }}</td>
                                        <td class="center">{{ $org->legalEntity->name }}</td>
                                        <td>{{ $org->legalEntity->city->name }}</td>
                                        <td>{{ $org->donations_address }}</td>
                                        <td>{{ $org->contact_email }}</td>
                                        <td>{{ $org->contact_phone }}</td>
                                        <td>{{ $org->person->first_name }} {{$org->person->last_name}}</td>
                                        <td class="center">{{ $org->status }}</td>
                                        <td class="center">
                                            <a href="/{{trans('routes.front.organizations')}}/{{trans('routes.actions.view')}}/{{$org->id}}"
                                               target="_blank" class="btn btn-sm btn-default">
                                                <i class="fa fa-eye"></i> Go To</a>
                                            <a href="/admin/organization/view/{{$org->id}}"
                                                class="btn btn-sm btn-default">
                                                <i class="fa fa-list"></i> Details</a>
                                            <a href="/admin/organization/edit/{{$org->id}}"
                                               class="btn btn-sm btn-default"><i class="fa fa-edit"></i> Edit</a>
                                        </td>
                                    </tr>

                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Company</th>
                                    <th>City</th>
                                    <th>Donations address</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Represented by</th>
                                    <th>Status</th>
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