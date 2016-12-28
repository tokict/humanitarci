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
                    <h5>Ukupni iznos ulaza</h5>
                    <h1 class="no-margins">{{number_format($total_in/100)}}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Ukupan broj ulaza</h5>
                    <h1 class="no-margins">{{number_format($total_nr_in)}}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>List of all inputs to organization pool</h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-stripped">
                        <div class="col-md-12 text-center">
                            {{$ins->appends($input)->links()}}
                        </div>
                        <thead>
                        <tr>
                            <th>Campaigns and amounts</th>
                            <th>Total amount</th>
                            <th data-hide="phone,tablet">Time</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ins as $i)
                            <tr class="gradeX">
                                <td>
                                    @foreach($i->donations as $d)
                                        <a href="/admin/campaign/view/{{$d->campaign->id}}"> {{$d->campaign->name}}</a>
                                        -- <a href="/admin/donation/view/{{$d->id}}">{{number_format($d->amount/100)}} {{env('CURRENCY')}}</a><br/>
                                    @endforeach
                                </td>
                                <td>{{number_format($i->amount/100)}} {{env('CURRENCY')}}</td>
                                <td>{{$i->created_at}}</td>
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
                        {{$ins->appends($input)->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection