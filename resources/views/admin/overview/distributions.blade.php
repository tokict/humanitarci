@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Početno stanje</h5>
                    <h1 class="no-margins">{{$starting_amount}}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Ukupni iznos izlaza</h5>
                    <h1 class="no-margins">{{number_format($total_out/100)}}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Ukupan broj izlaza</h5>
                    <h1 class="no-margins">{{number_format($total_nr_out)}}</h1>
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
                            {{$outs->appends($input)->links()}}
                        </div>
                        <thead>
                        <tr>
                            <th>Campaign</th>
                            <th>Amount</th>
                            <th data-hide="phone,tablet">Recieving entity</th>
                            <th data-hide="phone,tablet">To beneficiary</th>
                            <th data-hide="phone,tablet">Receipts</th>
                            <th data-hide="phone,tablet">Action time</th>
                            <th data-hide="phone,tablet">Created by</th>
                            <th data-hide="phone,tablet">Expenses payment</th>
                            <th data-hide="phone,tablet">Receiving person</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($outs as $o)
                            <tr class="gradeX">
                                <td>{{$o->campaign->name}}
                                </td>
                                <td>{{number_format($o->amount/100)}}</td>
                                <td class="center">{{$o->receiving_entity->name}}</td>
                                <td>{{$o->to_beneficiary?"Yes":"No"}}</td>
                                <td class="center">
                                    @foreach($o->receipts as $key =>  $r )
                                    <a href="{{$r->getPath('small')}}"><img src="{{$r->getPath('thumb')}}" style="width:20px; margin-right: 5px;"></a> </td>
                                @endforeach
                                <td>{{$o->action_time}}</td>
                                <td>{{$o->admin->user->username}}
                                </td>
                                <td>{{$o->expenses_payment?"Yes":"No"}}</td>

                                <td class="center">{{$o->receiving_person?$o->receiving_person->beneficiary->name:''}}</td>
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
                        {{$outs->appends($input)->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection