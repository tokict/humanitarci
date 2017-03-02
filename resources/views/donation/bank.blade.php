@extends('layouts.full')
@section('content')
        <!-- Section -->
<section class="page-section">
    <div class="container">
        @foreach($donations as $key =>  $d)
            <div class="row">

                <div style="width:640; height:422; margin: auto">
                    <img src="/front/images/uplatnica.png" style="width:100%">
                    <div class="payee">
                        @if(isset($order->donor->person))
                            {{$order->donor->person->first_name}} {{$order->donor->person->last_name}}
                            <br/>
                            {{$order->donor->person->address}} <br/>
                            {{$order->donor->person->city}}
                        @else
                            {{$order->donor->entity->name}}
                            <br/>
                            {{$order->donor->entity->address}}
                            <br/>
                            {{$order->donor->entity->city->name}}
                        @endif
                    </div>
                    <div class="amount">
                        ={{$order->amount}}00
                    </div>
                    <div class="iban">
                        {{$d['campaign']->iban}}
                    </div>
                    <div class="receiver">
                        {{$d['campaign']->organization->legalEntity->name}}
                        <br/>
                        {{$d['campaign']->organization->legalEntity->address}}
                        <br/>
                        {{$d['campaign']->organization->legalEntity->city->name}}
                    </div>
                    <div class="description">
                        Donacija #{{$order->reference}}{{$key}}
                    </div>
                    <div class="abroad">
                        <br/>
                        <strong>Za uplate iz inozemstva:</strong><br/>
                        Banka: {{$d['campaign']->organization->legalEntity->bank->name}}<br/>
                        Swift: {{$d['campaign']->organization->legalEntity->bank->swift_code}}<br/>
                        Iban: {{$d['campaign']->iban}}<br/>
                        Iznos: {{number_format($order->amount, 2)}} {{env('CURRENCY')}}<br/><br/>
                        Description: Donacija #{{$order->reference}}{{$key}}<br/>
                        -----------------------------------------------------------------------------------------


                    </div>
                </div>

            </div>
        @endforeach

    </div>
</section>
<!-- End Section -->
@endsection


<style>
    .payee {
        position: relative;
        top: -380px;
        left: 25px;
        width: 170px;
        height: 93px;
        text-align: left;
        font-weight: bold;
    }

    .amount {
        position: relative;
        top: -470px;
        float: right;
        right: 23px;
        letter-spacing: 7px;
        font-weight: bold;
    }

    .iban {
        position: relative;
        top: -357px;
        float: left;
        font-size: 10px;
        right: -117px;
        letter-spacing: 9px;
        font-weight: bold;
    }

    .receiver {
        position: relative;
        top: -345px;
        left: 25px;
        width: 170px;
        height: 93px;
        text-align: left;
        font-weight: bold;
    }

    .description {
        position: relative;
        top: -377px;
        float: left;
        font-size: 10px;
        width: 275px;
        right: -336px;
        height: 75px;
        line-height: 18px;
        font-weight: bold;
    }

    .abroad {
        position: absolute;
        top: 550px;
        padding-left:20px;
    }
</style>