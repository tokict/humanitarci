@extends('layouts.admin')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Persons listing</h5>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <div class="col-md-12 text-center">
                                {{$users->appends($input)->links()}}
                            </div>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Created at</th>
                                    <th>Person</th>
                                    <th>Admin</th>
                                    <th>Creator</th>
                                    <th>Donor</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $user)
                                    <tr class="gradeX">
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td class="center">{{ $user->email }}</td>
                                        <td class="center">{{ $user->created_at }}</td>
                                        <td class="center"><a href="/admin/person/view/{{ $user->person->id }}">
                                                {{ $user->person->first_name }} {{ $user->person->last_name }}</a>
                                        </td>
                                        <td class="center">{{ isset($user->admin)?'Yes':'No' }}</td>
                                        <td class="center">{{ $user->creator->user->username }}</td>
                                        <td class="center">
                                            @if(isset($user->donor))
                                                <a href="/admin/donor/view/{{ $user->donor->id }}">Yes</a>
                                                @else
                                                No
                                            @endif
                                        </td>
                                    </tr>

                                @endforeach


                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Created at</th>
                                    <th>Person</th>
                                    <th>Admin</th>
                                    <th>Creator</th>
                                    <th>Donor</th>
                                </tr>
                                </tfoot>
                            </table>
                            <div class="col-md-12 text-center">
                                {{$users->appends($input)->links()}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection