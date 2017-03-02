@extends('layouts.admin')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">


        <div class="row m-b-lg m-t-lg">
            <div class="col-md-6">

                <div class="profile-image">
                </div>
                <div class="profile-info">
                    <div class="">
                        <div>
                            <h2 class="no-margins">
                                {{$person->first_name}} {{$person->last_name}}
                            </h2>
                            <small>
                                {{$person->city}}
                            </small>
                            <br/>
                            <br/>
                            Donor:  @if($person->donor_id)
                                <a href="/admin/donor/view/{{$person->donor_id}}">Yes</a>
                            @else
                                No
                                @endIf
                            <br/>
                            Beneficiary:
                            @if($person->beneficiary_id)
                                <a href="/admin/beneficiary/view/{{$person->beneficiary_id}}">Yes</a>
                                @else
                                No
                                @endIf
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <table class="table small m-b-xs">
                    <tbody>
                    <tr>
                        <td>
                            Address: <strong>{{$person->address}}</strong>
                        </td>

                    </tr>
                    <tr>
                        <td>
                            City: <strong>{{$person->city}}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Email: <strong>{{$person->contact_email}}</strong>
                        </td>
                        <td>
                            Phone: <strong>{{$person->contact_phone}}</strong>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>


        </div>
    </div>
@endsection
