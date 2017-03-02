@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Novih donora</h5>
                    <h1 class="no-margins">{{$new_donors}}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Ukupna suma od novih donora</h5>
                    <h1 class="no-margins">{{$new_donors_sum}}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Donacija od novih donora</h5>
                    <h1 class="no-margins">{{$new_donors_donations_nr}}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Kampanja sa donacijama novih donora</h5>
                    <h1 class="no-margins">{{$new_donors_campaigns_donated}}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Prosjecna donacija novih donora</h5>
                    <h1 class="no-margins">{{$new_donors_average_donation}}</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-content">
                        <h5>Najveći novi donori</h5>
                        <table class="table table-stripped small m-t-md">
                            <tbody>
                            @foreach($biggest_new_donors as $d)
                                <tr>
                                    <td class="no-borders">
                                        <i class="fa fa-heart text-danger"></i>
                                    </td>
                                    <td class="no-borders">
                                        {{$d->user->username}} -- {{number_format($d->getTotalDonationsSum()/100)}} {{env('CURRENCY')}}
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