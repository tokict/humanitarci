@extends('layouts.admin')
@section('content')
    <h3>Weekly overview</h3>
    <div class="col-lg-2">
        <div class="widget style1 navy-bg">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-user fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Persons </span>
                    <h2 class="font-bold">{{$persons}}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-2">
        <div class="widget style1 navy-bg">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-bank fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Legal entities </span>
                    <h2 class="font-bold">{{$legal_entities}}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-2">
        <div class="widget style1 navy-bg">

            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-dot-circle-o fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Campaigns </span>
                    <h2 class="font-bold">{{$campaigns}}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-2">
        <div class="widget style1 navy-bg">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-handshake-o fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Donors </span>
                    <h2 class="font-bold">{{$donors}}</h2>
                </div>
            </div>

        </div>
    </div>

    <div class="col-lg-2">
        <div class="widget style1 navy-bg">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-heart fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Donations </span>
                    <h2 class="font-bold">{{$donations}}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="widget style1 navy-bg">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-user-circle-o fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Beneficiaries </span>
                    <h2 class="font-bold">{{$beneficiaries}}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="widget style1 red-bg">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-dollar fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Total raised </span>
                    <h1 class="font-bold">{{number_format($funds/100, 2)}}</h1>
                </div>
            </div>
        </div>
    </div>
@endsection





