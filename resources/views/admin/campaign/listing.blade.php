@extends('layouts.admin')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Campaigns listing</h5>
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
                            <table class="table table-striped table-bordered table-hover campaigns-table" >
                                <thead> <tr>
                                    <th>Name</th>
                                    <th>Beneficiary</th>
                                    <th>Organization</th>
                                    <th>Target amount</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Cover image</th>
                                    <th>Starts</th>
                                    <th>Ends</th>
                                    <th>Action by</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($campaigns as $campaign)
                                    <tr class="gradeX">
                                        <td>{{ $campaign->name }}</td>
                                        <td class="center">{{ $campaign->beneficiary->name }}</td>
                                        <td>{{ $campaign->organization->name }}</td>
                                        <td>{{ $campaign->target_amount }}</td>
                                        <td>{{ $campaign->status }}</td>
                                        <td>{{ $campaign->priority }}</td>
                                        <td><img src="{{ $campaign->cover->getPath() }}"></td>
                                        <td>{{ $campaign->starts }}</td>
                                        <td>{{ $campaign->ends }}</td>
                                        <td>{{ $campaign->action_by_date }}</td>

                                        <td class="center">
                                            <a href="#" class="btn btn-sm btn-primary">View</a>
                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#fileModal">Edit</a>
                                            <a href="#" class="btn btn-sm btn-primary">Lock</a>
                                        </td>
                                    </tr>

                                @endforeach




                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Beneficiary</th>
                                    <th>Organization</th>
                                    <th>Target amount</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Cover image</th>
                                    <th>Starts</th>
                                    <th>Ends</th>
                                    <th>Action by</th>
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