@extends('layouts.full')
@section('content')
        <!-- Section -->
<section class="page-section">
    <div class="container">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">

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
                                <a href=""><img src="{{$d['campaign']->cover->getPath('thumb')}}" alt=""/></a>
                            </td>
                            <td>
                                <a href="#" title="">{{$d['campaign']->name}}</a>
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
                    {!! Form::open(['url' => '/'.trans('routes.front.donations').'/'.trans('routes.actions.process'), 'class' => 'form-horizontal', 'id' => 'processForm']) !!}
                    {{Form::token()}}
                    <div class="col-sm-6" id="payeeInfo">

                        <h3 class="small-title font-alt">Podatci o uplatitelju</h3>
                        <div class="mb-10">
                            {{Form::select('gender', ["" => 'Spol', 'male' => 'Muško', 'female' => 'Žensko'], null, ['class' => 'input-md form-control'])}}
                        </div>
                        <div class="mb-10">
                            <input placeholder="Ime" name="first_name" class="input-md form-control" type="text"
                                   pattern=".{3,100}"/>
                        </div>

                        <div class="mb-10">
                            <input placeholder="Prezime" name="last_name" class="input-md form-control" type="text"
                                   pattern=".{3,100}"/>
                        </div>

                        <div class="mb-10">
                            {{Form::select('city_id', ["" => 'Grad'], null, ['class' => 'input-md form-control selectCity'])}}
                        </div>


                    </div>
                    <div class="col-sm-6 text align-right pt-10">


                        <div>
                            Ukupna donacija: <strong>{{number_format($total, 2)}} {{env('CURRENCY')}}</strong>
                        </div>

                        <div class="mb-10">
                            Naknade: <strong>{{number_format($taxes, 2)}} {{env('CURRENCY')}}</strong>
                        </div>

                        <div class="lead mt-0 mb-30">
                            Za platiti: <strong>{{number_format($totalWithTaxes, 2)}} {{env('CURRENCY')}}</strong>
                        </div>
                        @if(session('donations'))
                            <div>
                                <button type="button" class="btn btn-mod btn-round btn-large" id="processFormBtn">
                                    Plati
                                </button>
                            </div>
                            @endif

                    </div>
                    {{Form::close()}}
                </div>


            </div>
        </div>

    </div>
</section>
<!-- End Section -->
@endsection