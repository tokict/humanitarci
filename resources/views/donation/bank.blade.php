@extends('layouts.full')

@section('content')
        <!-- Section -->
<section class="page-section">
    <div class="container">
        @foreach($donations as $key =>  $d)
            <div class="row">

                <div style="width:640px; height:422px; margin: auto">
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
                        Donacija {{$order->reference}}{{$key}}
                    </div>
                    <div class="abroad">
                        <br/>
                        <strong>Za uplate iz inozemstva:</strong><br/>
                        Banka: {{$d['campaign']->organization->legalEntity->bank->name}}<br/>
                        Swift: {{$d['campaign']->organization->legalEntity->bank->swift_code}}<br/>
                        Iban: {{$d['campaign']->iban}}<br/>
                        Iznos: {{number_format($order->amount, 2)}} {{env('CURRENCY')}}<br/><br/>
                        Opis plaćanja: "Donacija {{$order->reference}}{{$key}}"<br/>
                        -----------------------------------------------------------------------------------------


                    </div>
                </div>

            </div>
        @endforeach

    </div>
</section>
<!-- End Section -->
@endsection


