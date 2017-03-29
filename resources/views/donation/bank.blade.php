@extends('layouts.full')

@section('content')
        <!-- Section -->
<section class="page-section">
    <div class="container">
        <div class="row">
        <b>NAPOMENA:</b> Uplate će biti vidljive na sistemu nako što nam banka pošajle izvješće o uplati.<br/>
        Izvješća dobijamo jednom dnevno što znači da je moguće da se Vaša uplate na sistemu registrira tek <b>nakon 48h</b>.<br/>
        U prosjeku bi trebala biti vidljiva unutar 24h.<br/><br/>

        Ukoliko se Vaša uplate ne vidi u sistemu nakon isteka 48 sati, molimo da nam pošaljete email sa oznakom donacije
        kako bi mogli provjeriti u čemu je problem.
        </div>
        @foreach($donations as $key =>  $d)
    <div class="row">
               <div class="text-center">
                   <br/><br/>

                    <strong>Za uplate iz inozemstva ili internet bankarstvom:</strong><br/>
                     {{$d['campaign']->organization->legalEntity->bank->name}}<br/>
                    Swift: {{$d['campaign']->organization->legalEntity->bank->swift_code}}<br/>
                    Iban: {{$d['campaign']->iban}}<br/>
                    Iznos: {{number_format($order->amount, 2)}} {{env('CURRENCY')}}<br/><br/>
                    Opis plaćanja: "Donacija <span style="font-family: 'Courier New' ">{{$order->reference}}{{$key}}"</span><br/>

               </div>

    </div>
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
                        {{$d['campaign']->name}}

                    </div>
                    <div class="description">
                        Donacija <span style="font-family: 'Courier New' ">{{$order->reference}}{{$key}}</span>
                    </div>
                </div>


            </div>
            <div class="row text-center">
                <img src="{{$d['barcode']}}" class="hubBarcode">
            </div>
        @endforeach

    </div>
</section>
<!-- End Section -->
@endsection


