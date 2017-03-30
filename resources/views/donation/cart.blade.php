@extends('layouts.full')
@section('content')
    <!-- Section -->
    <script>
                @if(\Illuminate\Support\Facades\Auth::check())
        var auth = true;
                @else
        var auth = false;
                @endif
                @if(isset($donations[0]))
        var bankTransfer = '/{{trans('routes.front.donations')}}/{{trans('routes.actions.bank')}}/{{$donations[0]['order_id']}}';
        @endif
    </script>
    <section class="page-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    @if($recurring)
                        <h4 class="text-ceter">For each monthly donation you will need to execute payment
                            separately.<br/>
                            After you pay the first, you will be returned to this site and given the option to pay for
                            the
                            rest</h4>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    @if(!Auth::user())
                        <span><b>Novi donatori:</b>
                                <br/>Nakon upisivanja Vaših podataka na unesenu email adresu dobiti ćete link za aktivaciju Vašeg profila ukoliko ne postoji na platformi.<br/>
                        Uplate će biti vidljive pod Vašim imenom tek nakon aktivacije profila.<br/>Ukoliko niste primili mail,
                            provjerite spam folder ili nam pišite na <a
                                    href="mailto:webmaster@humanitarci.hr">webmaster@humanitarci.hr</a>
                            </span>
                    @endif

                    <?php if(!empty($errors)): ?>

                    <ul>
                        <?php foreach($errors->all() as $error):?>
                        <h4 class="text-danger text-center"><?php echo e($error); ?></h4>
                        <?php endforeach; ?>
                    </ul>

                    <?php endif; ?>
                    <?php if(\Illuminate\Support\Facades\Session::has('success')): ?>

                    <ul>
                        @if(is_array(\Illuminate\Support\Facades\Session::get('success')))
                            <h4 class="text-success text-center">{{\Illuminate\Support\Facades\Session::get('success')[0]}}</h4>
                        @else()
                            <h4 class="text-success text-center">{{\Illuminate\Support\Facades\Session::get('success')}}</h4>
                        @endif


                    </ul>

                    <?php endif; ?>
                    @if($order)
                        <table class="table table-striped shopping-cart-table">
                            <tr>
                                <th class="hidden-xs">

                                </th>
                                <th>
                                    Akcija
                                </th>
                                <th>
                                    Iznos
                                </th>
                                <th>
                                    Tip
                                </th>
                                <th>

                                </th>
                            </tr>

                            @foreach($donations as $key =>$d)
                                <tr>
                                    <td class="hidden-xs" style="max-width: 50px;">
                                        <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.view')}}/{{$d['campaign']->id}}"><img
                                                    src="{{$d['campaign']->cover->getPath('thumb')}}" alt=""/></a>
                                    </td>
                                    <td>
                                        <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.view')}}/{{$d['campaign']->id}}"
                                           title="">{{$d['campaign']->name}}</a>
                                    </td>
                                    <td>
                                        {{$d['amount']}} {{env('CURRENCY')}}
                                    </td>
                                    <td>
                                        {{trans('strings.donations.'.$d['type'])}}
                                    </td>
                                    <td>
                                        <a href="/{{trans('routes.front.donations')}}/{{trans('routes.actions.remove')}}/{{$key}}"
                                           class="pull-right"><i class="fa fa-times"></i> <span
                                                    class="hidden-xs">Ukloni</span></a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        <hr class="mb-60"/>
                        <div class="row mb-20">
                            <div class="col-md-4 col-md-offset-8">
                                {{Form::select('payment_type', ['bank' => 'Uplatnica'], $orderModel->payment_method == 'credit_card'?'card':'bank', ['class' => 'input-md form-control'])}}
                            </div>
                        </div>

                        <div class="row">

                            {!! Form::open(['url' => env('PAYMENT_ENDPOINT'), 'class' => 'form-horizontal', 'id' => 'processForm' , 'method' => 'post']) !!}
                            {{Form::model($order)}}
                            <div class="col-sm-6" id="payeeInfo">
                                @if(!Auth::check())
                                    <label for="name">Osoba</label>
                                    <input type="radio" value="individual" name="payeeType" class="payeeType" checked>
                                    &nbsp;&nbsp;&nbsp;
                                    <label for="name">Tvrtka</label>
                                    <input type="radio" value="company" name="payeeType" class="payeeType">
                                    &nbsp;&nbsp;&nbsp;
                                    <label for="name">Anonimno</label>
                                    <input type="radio" value="anonymous" name="payeeType" class="payeeType">
                                    <br/>
                                    <div id="companyInfo" class="hidden">
                                        <h3 class="small-title font-alt">Podatci o tvrtki</h3>
                                        <div class="mb-10">
                                            <input placeholder="Ime tvrtke" name="entity_name"
                                                   class="input-md form-control"
                                                   type="text"
                                                   pattern=".{3,100}"/>
                                        </div>
                                        <div class="mb-10">
                                            <input placeholder="Adresa" name="entity_address"
                                                   class="input-md form-control"
                                                   type="text"
                                                   pattern=".{3,100}"/>
                                        </div>
                                        <div class="mb-10">
                                            <select name="entity_city_id" class="input-lg form-control selectCity">
                                                <option>Grad</option>
                                            </select>
                                        </div>

                                        <div class="mb-10">
                                            <input placeholder="OIB" name="entity_tax_id" class="input-md form-control"
                                                   type="text"
                                                   pattern=".{3,100}"/>
                                        </div>
                                        <hr>
                                        <h4 class="small-title font-alt">Podatci o kontakt osobi</h4>
                                    </div>
                                    <h4 class="small-title font-alt" id="payeeIndividualLabel">Podatci o platitelju</h4>
                                    <div class="mb-10">
                                        {{Form::select('title', ["" => 'Titula', 'Mr' => 'Mr.', 'Ms' => 'Ms', 'Mrs' => 'Mrs'], null, ['class' => 'input-md form-control'])}}
                                    </div>
                                    <div class="mb-10">
                                        <input placeholder="Ime" name="cardholder_name" class="input-md form-control"
                                               type="text"
                                               pattern=".{3,100}"/>
                                    </div>

                                    <div class="mb-10">
                                        <input placeholder="Prezime" name="cardholder_surname"
                                               class="input-md form-control"
                                               type="text"
                                               pattern=".{3,100}"/>
                                    </div>
                                    <div class="mb-10">
                                        <input placeholder="Email" name="cardholder_email" class="input-md form-control"
                                               type="text"
                                               pattern=".{3,100}"/>
                                        <div id="emailErrMsg" class="hidden" style="color:darkred; padding: 5px">Email
                                            adresa je zauzeta.<br/> Molimo izaberite drugu ili izvršite prijavu
                                        </div>
                                    </div>
                                    <div class="mb-10">
                                        <input placeholder="Grad" name="cardholder_city" class="input-md form-control"
                                               type="text"
                                               pattern=".{3,100}"/>
                                    </div>
                                    <div class="mb-10">
                                        <input placeholder="Država" name="cardholder_country"
                                               class="input-md form-control"
                                               type="text"
                                               pattern=".{3,100}"/>
                                    </div>
                                    <div class="mb-10">
                                        <input placeholder="Adresa" name="cardholder_address"
                                               class="input-md form-control"
                                               type="text"
                                               pattern=".{3,100}"/>
                                    </div>
                                    <div class="mb-10">
                                        <input placeholder="Poštanski broj" name="cardholder_zip_code"
                                               class="input-md form-control"
                                               type="text"
                                               pattern=".{3,100}"/>
                                    </div>
                                    <div class="mb-10">
                                        <input placeholder="Kontakt telefon" name="cardholder_phone"
                                               class="input-md form-control"
                                               type="text"
                                               pattern=".{3,100}"/>
                                    </div>
                                    {{Form::text('order_token', $orderModel->order_token, ['class' => 'hidden'])}}

                                @endif
                            </div>

                            <div class="col-sm-6 text align-right pt-10">


                                <div>
                                    Ukupna donacija:
                                    <strong><span
                                                id="donation_amount">{{number_format($total-$total/100*$total_tax, 2)}}</span> {{env('CURRENCY')}}
                                    </strong>
                                </div>

                                <div class="lead mt-0 mb-30">
                                    Za donirati: <strong>{{number_format($total, 2)}} {{env('CURRENCY')}}</strong>
                                </div>

                                {{Form::hidden('target')}}
                                {{Form::hidden('cart')}}
                                {{Form::hidden('mode')}}
                                {{Form::hidden('store_id')}}
                                {{Form::hidden('order_number')}}
                                {{Form::hidden('language')}}
                                {{Form::hidden('currency')}}
                                {{Form::hidden('amount')}}
                                {{Form::hidden('hash')}}
                                @if(isset( \Illuminate\Support\Facades\Auth::User()->person))
                                    {{Form::hidden('cardholder_name', \Illuminate\Support\Facades\Auth::User()->person->first_name)}}
                                    {{Form::hidden('cardholder_surname', \Illuminate\Support\Facades\Auth::User()->person->last_name)}}
                                    {{Form::hidden('cardholder_city', \Illuminate\Support\Facades\Auth::User()->person->city)}}
                                    {{Form::hidden('cardholder_country', \Illuminate\Support\Facades\Auth::User()->person->country)}}
                                    {{Form::hidden('cardholder_zip_code', \Illuminate\Support\Facades\Auth::User()->person->zip)}}
                                    {{Form::hidden('cardholder_email', \Illuminate\Support\Facades\Auth::User()->person->contact_email)}}
                                    {{Form::hidden('cardholder_address', \Illuminate\Support\Facades\Auth::User()->person->address)}}
                                    {{Form::hidden('cardholder_phone', \Illuminate\Support\Facades\Auth::User()->person->contact_phone)}}
                                @endif
                                {{Form::hidden('require_complete')}}
                                <div>
                                    <button type="button" class="btn btn-mod btn-round btn-large" id="processFormBtn">
                                        <i class="fa fa-2x fa-heart"></i> Doniraj
                                    </button>
                                </div>
                                <div class="col-sm-11 col-sm-offset-1 text-left mt-50">
                                    <div class="col-sm-10 col-sm-offset-2">
                                        <b>Napomena:</b><br/>
                                        <small>Podatci koje unesete ovdje poznati su samo osoblju
                                        humanitarci.hr i
                                        ni u kojem slučaju se ne otkrivaju javnosti putem stranice.
                                        Sve Vaše uplate su vidljive isključivo pod korisničkim imenom koje sami
                                            odaberete.<br/><br/></small>
                                    </div>
                                </div>


                            </div>
                            {{Form::close()}}
                        </div>
                    @else
                        <ul>
                            <h3 class="text-center">Vaša košarica je prazna</h3>
                        </ul>
                    @endif

                </div>
            </div>

        </div>
    </section>
    <!-- End Section -->
@endsection