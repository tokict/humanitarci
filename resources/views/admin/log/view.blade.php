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
                                <a href="/admin/person/view/{{$person->id}}"> {{$person->first_name}} {{$person->last_name}}</a>
                            </h2>
                            <small>
                                {{$person->city}}
                            </small>
                            <br/>
                            <br/>
                            Item: {{$log->item_id}} <br/>
                            Donor: @if($donor)
                                <a href="/admin/donor/view/{{$donor->_id}}">Yes</a>
                            @else
                                No
                                @endIf
                                <br/>
                                Admin:
                                @if($person->admin)
                                    <a href="/admin/admin/view/{{$admin->id}}">Yes</a>
                                @else
                                    No
                                    @endIf
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    @if(unserialize($log->data))
                        <table class="table small m-b-xs">
                            <tbody>
                            <tr>
                                <th>Param name</th>
                                <th>New value</th>
                                <th>Old value</th>
                            </tr>
                            <tr>
                            @foreach($differences as $key =>  $values)
                                <tr>
                                    <td>
                                        <span>{{$key}}</span>
                                    </td>
                                    <td>
                                        <span>{{$values['old']}}</span>
                                    </td>
                                    <td>
                                        <span>{{$values['new']}}</span>
                                    </td>
                                </tr>
                                @endforeach

                                </tr>
                            </tbody>
                        </table>
                    @else
                        <span>{{$log->data}}</span>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
