@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Ukupan broj donacija</h5>
                    <h1 class="no-margins">{{$total_nr_donations}}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Ukupna suma</h5>
                    <h1 class="no-margins">{{number_format($total_donations_amount/100)}} {{env('CURRENCY')}}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Prosjek doniranih iznosa</h5>
                    <h1 class="no-margins">{{number_format($donations_average/100)}} {{env('CURRENCY')}}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Najveći donori</h5>
                    <table class="table table-stripped small m-t-md">
                        <tbody>
                        @foreach($biggest_donors as $d)
                        <tr>
                            <td class="no-borders">
                                <i class="fa fa-heart text-danger"></i>
                            </td>
                            <td class="no-borders">
                                {{$d->donor->user->username}} -- {{number_format($d->donor->getDonationsSumForCampaign($d->campaign_id)/100)}} {{env('CURRENCY')}}
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