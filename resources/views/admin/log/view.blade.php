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
                                <th>Item</th>
                                <th>Param name</th>
                                <th>Old value</th>
                                <th>new value</th>
                            </tr>
                            <tr>
                                <td>
                                    <strong>{{$log->item_id}}</strong>
                                </td>
                                @foreach($differences as $key =>  $values)
                                    <td>
                                        <strong>{{$key}}</strong>
                                    </td>
                                    <td>
                                        <strong>{{$values['old']}}</strong>
                                    </td>
                                    <td>
                                        <strong>{{$values['new']}}</strong>
                                    </td>

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
