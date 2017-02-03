@extends('layouts.admin')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-4">
                <h2>Donation details</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <div class="wrapper wrapper-content animated fadeInUp">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <h2>{{$donation->campaign->name}}</h2>
                                    </div>
                                    <dl class="dl-horizontal">
                                        <dt>Status:</dt>
                                        <dd>{{strtoupper($donation->status)}}</dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-5">
                                    <dl class="dl-horizontal">

                                        <dt>Donor:</dt>
                                        <dd>
                                            <a href="/donors/view/{{$donation->donor_id}}">{{$donation->donor->user->username}}</a>
                                        </dd>
                                        <dt>Time:</dt>
                                        <dd>{{$donation->created_at}} ({{$donation->created_at->diffForHumans()}})</dd>
                                        <dt>Amount:</dt>
                                        <dd>{{number_format($donation->amount/100, 2)}} {{env('CURRENCY')}}</dd>
                                        @if($donation->source == 'site')
                                            @if(isset($donation->monetary_input->payment_provider_datum))
                                                <dt>Order number:</dt>
                                                <dd>{{strtoupper($donation->monetary_input->payment_provider_datum->order_number)}}</dd>
                                                <dt>Transaction time nr:</dt>
                                                <dd>{{strtoupper($donation->monetary_input->payment_provider_datum->transaction_datetime)}}</dd>
                                            @endif
                                            @if(isset($donation->monetary_input->bank_transfer_datum))
                                                <dt>Order reference:</dt>
                                                <dd>{{strtoupper($donation->monetary_input->bank_transfer_datum->order->reference)}}</dd>
                                                <dt>Transaction time nr:</dt>
                                                <dd>{{strtoupper($donation->monetary_input->bank_transfer_datum->time)}}</dd>
                                            @endif
                                        @endif
                                    </dl>
                                </div>
                                <div class="col-lg-7" id="cluster_info">
                                    <dl class="dl-horizontal">

                                        <dt>Type:</dt>
                                        <dd>{{strtoupper($donation->type)}}</dd>
                                        <dt>Source:</dt>
                                        <dd>{{strtoupper($donation->source)}}</dd>
                                        @if($donation->source == 'site')
                                            @if(isset($donation->monetary_input->payment_provider_datum))
                                                <dt>Card:</dt>
                                                <dd>{{strtoupper($donation->monetary_input->payment_provider_datum->card_type)}}</dd>
                                                <dt>Card nr:</dt>
                                                <dd>{{strtoupper($donation->monetary_input->payment_provider_datum->card_details)}}</dd>
                                                <dt>Cardholder:</dt>
                                                <dd>{{strtoupper($donation->monetary_input->payment_provider_datum->cardholder_name)}}
                                                    {{strtoupper($donation->monetary_input->payment_provider_datum->cardholder_surname)}}</dd>
                                            @endif

                                            @if(isset($donation->monetary_input->bank_transfers_datum))
                                                <dt>Payee name:</dt>
                                                <dd>{{strtoupper($donation->monetary_input->bank_transfers_datum->payee_name)}}</dd>
                                                <dt>Payee account:</dt>
                                                <dd>{{strtoupper($donation->monetary_input->bank_transfers_datum->payee_account)}}</dd>
                                            @endif
                                        @endif


                                    </dl>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

