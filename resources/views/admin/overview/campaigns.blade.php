@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Aktivne kampanje</h5>
                    <h1 class="no-margins">{{$campaigns_active}}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Na čekanju</h5>
                    <h1 class="no-margins">{{$campaigns_pending}}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Završene</h5>
                    <h1 class="no-margins">{{$campaigns_ended}}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Uspješne</h5>
                    <h1 class="no-margins">{{$campaigns_succeeded}}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="col-lg-3">
        <div class="ibox">
            <div class="ibox-content">
                <h5>Najpopularnije</h5>
                <table class="table table-stripped small m-t-md">
                    <tbody>
                    @foreach($campaigns_popular as $c)
                    <tr>
                        <td class="no-borders">
                            <i class="fa fa-circle text-danger"></i>
                        </td>
                        <td class="no-borders">
                            {{$c->name}} -- {{$c->donations->count()}} donacija
                        </td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
@endsection