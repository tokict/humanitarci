@extends('layouts.admin')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Donation listing</h5>
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
                            <div class="col-md-12 text-center">
                                {{$donations->appends($input)->links()}}
                            </div>
                            <table class="table table-striped table-bordered table-hover campaigns-table">
                                <thead>
                                <tr>
                                    <th>Campaign</th>
                                    <th>Beneficiary</th>
                                    <th>Donor</th>
                                    <th>Type</th>
                                    <th>@if(\Illuminate\Support\Facades\Input::get('order')=='amount')
                                            @if(\Illuminate\Support\Facades\Input::get('dir')=='desc')
                                                <a href="?order=amount&dir=asc">Amount<i
                                                            class="fa fa-sort-amount-desc"></i></a>
                                            @else
                                                <a href="?order=amount&dir=desc">Amount <i
                                                            class="fa fa-sort-amount-asc"></i></a>
                                            @endif
                                        @else()
                                            <a href="?order=amount&dir=asc">Amount<i
                                                        class="fa fa-sort-amount-desc"></i></a>
                                        @endif</th>
                                    <th>Status</th>
                                    <th>@if(\Illuminate\Support\Facades\Input::get('order')=='created_at')
                                            @if(\Illuminate\Support\Facades\Input::get('dir')=='desc')
                                                <a href="?order=created_at&dir=asc">Time<i
                                                            class="fa fa-sort-amount-desc"></i></a>
                                            @else
                                                <a href="?order=created_at&dir=desc">Time <i
                                                            class="fa fa-sort-amount-asc"></i></a>
                                            @endif
                                        @else()
                                            <a href="?order=created_at&dir=asc">Time<i
                                                        class="fa fa-sort-amount-desc"></i></a>
                                        @endif</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($donations as $donation)
                                    <tr class="gradeX">
                                        <td><a href="/campaign/view/{{ $donation->campaign->id}}">{{ $donation->campaign->name }}</a></td>
                                        <td><a href="/beneficiary/view/{{ $donation->campaign->beneficiary->id}}">{{ $donation->campaign->beneficiary->name }}</a></td>
                                        <td class="center">
                                            <a href="donor/view/{{$donation->donor->user->id}}">{{ $donation->donor->user->name }}</a></td>
                                        <td>{{ $donation->type }}</td>
                                        <td>{{ number_format($donation->amount / 100, 2) }}</td>
                                        <td>{{ $donation->status }}</td>
                                        <td>{{ $donation->created_at }}</td>


                                        <td class="center">
                                            <a href="/admin/donation/view/{{$donation->id}}"
                                                class="btn btn-sm btn-default">
                                                <i class="fa fa-list"></i> Details</a>
                                        </td>
                                    </tr>

                                @endforeach


                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Beneficiary</th>
                                    <th>Donor</th>
                                    <th>Organization</th>
                                    <th>Target amount</th>
                                    <th>Status</th>
                                    <th>Time</th>
                                    <th>Actions</th>
                                </tr>
                                </tfoot>
                            </table>
                            <div class="col-md-12 text-center">
                                {{$donations->appends($input)->links()}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection