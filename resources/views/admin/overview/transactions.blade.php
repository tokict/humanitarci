@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Ukupni iznos transakcija</h5>
                    <h1 class="no-margins">{{number_format($total/100)}}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Ukupan broj transakcija</h5>
                    <h1 class="no-margins">{{number_format($total_nr)}}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Ukupan broj kampanja u transakcijama</h5>
                    <h1 class="no-margins">{{number_format($total_campaigns)}}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>List of all outputs from organization pool</h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-stripped">
                        <div class="col-md-12 text-center">
                            {{$transactions->appends($input)->links()}}
                        </div>
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>From campaign</th>
                            <th>To campaign</th>
                            <th data-hide="phone,tablet">From donation</th>
                            <th data-hide="phone,tablet">To donation</th>
                            <th data-hide="phone,tablet">Donor</th>
                            <th data-hide="phone,tablet">Amount</th>
                            <th data-hide="phone,tablet">Created at</th>
                            <th data-hide="phone,tablet">Type</th>
                            <th data-hide="phone,tablet">Description</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactions as $t)
                            <tr class="gradeX">
                                <td>{{$t->id}}</td>
                                <td><a href="/admin/campaign/view/{{$t->from_campaign->id}}"> {{$t->from_campaign->name}}</a>
                                </td>
                                <td><a href="/admin/campaign/view/{{$t->to_campaign->id}}"> {{$t->to_campaign->name}}</a></td>
                                <td class="center"><a href="/admin/campaign/view/{{$t->from_donation->id}}"> {{$t->from_donation->id}}</a></td>
                                <td><a href="/admin/campaign/view/{{$t->to_donation->id}}"> {{$t->to_donation->id}}</a></td>
                                <td class="center"><a href="{{$t->from_donation->donor->id}}"> {{$t->from_donation->donor->user->username}}</a></td>
                                <td class="center">{{$t->amount}}</td>
                                <td>{{$t->time}}</td>
                                <td>{{$t->type}}</td>
                                <td class="center">{{$t->description}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="10">
                                <ul class="pagination pull-right"></ul>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                    <div class="col-md-12 text-center">
                        {{$transactions->appends($input)->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection