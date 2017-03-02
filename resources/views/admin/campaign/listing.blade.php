@extends('layouts.admin')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Campaigns listing</h5>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <div class="col-md-12 text-center">
                                {{$campaigns->appends($input)->links()}}
                            </div>
                            <table class="table table-striped table-bordered table-hover campaigns-table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Beneficiary</th>
                                    <th>Organization</th>
                                    <th>
                                        @if(\Illuminate\Support\Facades\Input::get('order')=='percent_done')
                                            @if(\Illuminate\Support\Facades\Input::get('dir')=='desc')
                                                <a href="?order=percent_done&dir=asc">Progress <i
                                                            class="fa fa-sort-amount-desc"></i></a>
                                            @else
                                                <a href="?order=percent_done&dir=desc">Progress <i
                                                            class="fa fa-sort-amount-asc"></i></a>
                                            @endif
                                        @else()
                                            <a href="?order=percent_done&dir=asc">Progress <i
                                                        class="fa fa-sort-amount-desc"></i></a>
                                        @endif
                                    </th>
                                    <th>Status</th>
                                    <th>
                                        @if(\Illuminate\Support\Facades\Input::get('order')=='priority')
                                            @if(\Illuminate\Support\Facades\Input::get('dir')=='desc')
                                                <a href="?order=priority&dir=asc">Priority<i
                                                            class="fa fa-sort-amount-desc"></i></a>
                                            @else
                                                <a href="?order=priority&dir=desc">Priority <i
                                                            class="fa fa-sort-amount-asc"></i></a>
                                            @endif
                                        @else()
                                            <a href="?order=priority&dir=asc">Priority<i
                                                        class="fa fa-sort-amount-desc"></i></a>
                                        @endif
                                    </th>
                                    <th>Cover image</th>
                                    <th>
                                        @if(\Illuminate\Support\Facades\Input::get('order')=='starts')
                                            @if(\Illuminate\Support\Facades\Input::get('dir')=='desc')
                                                <a href="?order=starts&dir=asc">Starts<i
                                                            class="fa fa-sort-amount-desc"></i></a>
                                            @else
                                                <a href="?order=starts&dir=desc">Starts <i
                                                            class="fa fa-sort-amount-asc"></i></a>
                                            @endif
                                        @else()
                                            <a href="?order=starts&dir=asc">Starts<i
                                                        class="fa fa-sort-amount-desc"></i></a>
                                        @endif</th>
                                    <th>
                                        @if(\Illuminate\Support\Facades\Input::get('order')=='ends')
                                            @if(\Illuminate\Support\Facades\Input::get('dir')=='desc')
                                                <a href="?order=ends&dir=asc">Ends<i
                                                            class="fa fa-sort-amount-desc"></i></a>
                                            @else
                                                <a href="?order=ends&dir=desc">Ends <i
                                                            class="fa fa-sort-amount-asc"></i></a>
                                            @endif
                                        @else()
                                            <a href="?order=ends&dir=asc">Ends<i
                                                        class="fa fa-sort-amount-desc"></i></a>
                                        @endif
                                    </th>
                                    <th>
                                        @if(\Illuminate\Support\Facades\Input::get('order')=='action_by')
                                            @if(\Illuminate\Support\Facades\Input::get('dir')=='desc')
                                                <a href="?order=action_by&dir=asc">Action by<i
                                                            class="fa fa-sort-amount-desc"></i></a>
                                            @else
                                                <a href="?order=action_by&dir=desc">Action by <i
                                                            class="fa fa-sort-amount-asc"></i></a>
                                            @endif
                                        @else()
                                            <a href="?order=action_by&dir=asc">Action by<i
                                                        class="fa fa-sort-amount-desc"></i></a>
                                        @endif
                                    </th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($campaigns as $campaign)
                                    <tr class="gradeX">
                                        <td>{{ $campaign->name }}</td>
                                        <td class="center"><a href="/admin/beneficiary/view/{{ $campaign->beneficiary->id }}">{{ $campaign->beneficiary->name }}</a></td>
                                        <td><a href="/admin/organization/view/{{ $campaign->organization->id }}">{{ $campaign->organization->name }}</a></td>
                                        <td>
                                            <div class="progress progress-striped active m-b-sm">
                                                <div style="width: {{$campaign->percent_done}}%;"
                                                     class="progress-bar"></div>
                                            </div>
                                            <strong>{{$campaign->current_funds/100}}
                                                @if($campaign->target_amount)
                                                    /
                                                    {{ number_format($campaign->target_amount/100) }}
                                                @endif{{env('CURRENCY')}}</strong>

                                        <td>{{ $campaign->status }}</td>
                                        <td>{{ $campaign->priority }}</td>
                                        <td><img src="{{ $campaign->cover->getPath("small") }}"></td>
                                        <td>{{ $campaign->starts }}</td>
                                        <td>{{ $campaign->ends }}</td>
                                        <td>{{ $campaign->action_by_date }}</td>

                                        <td class="center">
                                            <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.view')}}/{{$campaign->id}}"
                                               target="_blank" class="btn btn-sm btn-default">
                                                <i class="fa fa-eye"></i> Go To</a>
                                            <a href="/admin/campaign/view/{{$campaign->id}}"
                                               class="btn btn-sm btn-default">
                                                <i class="fa fa-list"></i> Details</a>
                                            <a href="/admin/campaign/edit/{{$campaign->id}}"
                                               class="btn btn-sm btn-default"><i class="fa fa-edit"></i> Edit</a>
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
                            <div class="col-md-12 text-center">
                                {{$campaigns->appends($input)->links()}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection