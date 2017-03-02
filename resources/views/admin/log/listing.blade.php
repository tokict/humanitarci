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
                            <table class="table table-striped table-bordered table-hover organizations-table" >
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Type</th>
                                    <th>Admin</th>
                                    <th>Donor</th>
                                    <th>Data</th>
                                    <th>Time</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($logs as $log)
                                    <tr class="gradeX">
                                        <td>{{ $log->id }}</td>
                                        <td class="center">{{ $log->type }}</td>
                                        <td>
                                        @if(isset($log->admin))
                                        <a href="/admin/person/view/{{ $log->admin->user->person->id}}"> {{ $log->admin->user->person->first_name }} {{ $log->admin->user->person->last_name }}</a>
                                        @endif
                                        </td>
                                        <td>
                                        @if(isset($log->donor))
                                        <a href="/admin/donor/view/{{ $log->donor->user->person->id}}"> {{ $log->donor->user->person->first_name }} {{ $log->donor->user->person->last_name }}</a>
                                        @endif
                                        </td>
                                        <td style="max-width: 500px; overflow: auto;"><p>{!!  is_array(unserialize($log->data))?print_r(unserialize($log->data)):$log->data !!}</p></td>
                                        <td>{{ $log->created_at }}</td>
                                        <td class="center">
                                            <a href="/admin/log/view/{{$log->id}}"
                                                class="btn btn-sm btn-default">
                                                <i class="fa fa-list"></i> Details</a>
                                        </td>
                                    </tr>

                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Type</th>
                                    <th>Admin</th>
                                    <th>Donor</th>
                                    <th>Data</th>
                                    <th>Time</th>
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