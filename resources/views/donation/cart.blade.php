@extends('layouts.full')
@section('content')
        <!-- Section -->
<section class="page-section">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if($recurring)
                    <h4 class="text-ceter">For each monthly donation you will need to execute payment separately.<br/>
                        After you pay the first, you will be returned to this site and given the option to pay for the
                        rest</h4>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
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
                                Ukupno
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
                                    <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.view')}}/{{$d['campaign']->id}}"><img src="{{$d['campaign']->cover->getPath('thumb')}}" alt=""/></a>
                                </td>
                                <td>
                                    <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.view')}}/{{$d['campaign']->id}}" title="">{{$d['campaign']->name}}</a>
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

                    <div class="row">
                        @if(!\Illuminate\Support\Facades\Auth::check())
                        {!! Form::open(['class' => 'form-horizontal', 'id' => 'processForm' , 'data-login' => true, 'data-loginUrl' => '/'.trans("routes.front.donors").'/'.trans("routes.actions.login").'?fromCart=true']) !!}
                        @else
                            {!! Form::open(['url' => env('PAYMENT_ENDPOINT'), 'class' => 'form-horizontal', 'id' => 'processForm' , 'data-login' => false]) !!}
                        @endif
                        @if(Auth::check())
                        <div class="col-sm-6" id="payeeInfo">

                            <h3 class="small-title font-alt">Podatci o uplatitelju</h3>
                            <div class="mb-10">
                                {{Form::select('title', ["" => 'Titula', 'Mr' => 'Mr.', 'Ms' => 'Ms', 'Mrs' => 'Mrs'], null, ['class' => 'input-md form-control'])}}
                            </div>
                            <div class="mb-10">
                                <input placeholder="Ime" name="cardholder_name" class="input-md form-control"
                                       type="text"
                                       pattern=".{3,100}"/>
                            </div>

                            <div class="mb-10">
                                <input placeholder="Prezime" name="cardholder_surname" class="input-md form-control"
                                       type="text"
                                       pattern=".{3,100}"/>
                            </div>

                            <div class="mb-10">
                                {{Form::select('city_id', ["" => 'Grad'], null, ['class' => 'input-md form-control selectCity'])}}
                            </div>


                        </div>
                            @endif
                        <div class="col-sm-6 text align-right pt-10">


                            <div>
                                Ukupna donacija: <strong>{{number_format($total, 2)}} {{env('CURRENCY')}}</strong>
                            </div>

                            <div class="mb-10">
                                Naknade: <strong>{{number_format($taxes, 2)}} {{env('CURRENCY')}}</strong>
                            </div>

                            <div class="lead mt-0 mb-30">
                                Za donirati: <strong>{{number_format($totalWithTaxes, 2)}} {{env('CURRENCY')}}</strong>
                            </div>

                            {{Form::hidden('target', $order->target)}}
                            {{Form::hidden('cart', $order->cart)}}
                            {{Form::hidden('mode', $order->mode)}}
                            {{Form::hidden('store_id', $order->store_id)}}
                            {{Form::hidden('order_number', $order->order_number)}}
                            {{Form::hidden('language', $order->language)}}
                            {{Form::hidden('currency', $order->currency)}}
                            {{Form::hidden('amount', $order->amount)}}
                            {{Form::hidden('hash', $order->hash)}}
                            {{Form::hidden('require_complete', $order->require_complete)}}

                            <div>
                                @if(!\Illuminate\Support\Facades\Auth::check())
                                    <button type="submit" class="btn btn-mod btn-round btn-large" id="processFormBtn">
                                        Registriraj se i plati
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-mod btn-round btn-large" id="processFormBtn">
                                        Plati
                                    </button>
                                @endif

                            </div>


                        </div>

                    </div>
                @else

                    <h3 class="text-center">Vaša košarica je prazna</h3>
                @endif

            </div>
        </div>

    </div>
</section>
<!-- End Section -->
@endsection