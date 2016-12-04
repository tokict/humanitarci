@extends('layouts.admin')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Donor listing</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover campaigns-table">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Person / Entity</th>
                                    <th>Amount donated</th>
                                    <th>Total donations</th>
                                    <th>Registered at</th>
                                    <th>Last donation</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($donors as $donor)
                                    <tr class="gradeX">
                                        <td>{{$donor->id}}</td>
                                        <td>{{ $donor->user->name }}</td>
                                        <td class="center">
                                            @if(isset($donor->person) && $donor->anonymous != 1)
                                                <a href="person/view/{{$donor->person->id}}">{{ $donor->person->first_name }} {{ $donor->person->last_name }}</a>
                                        </td>
                                        @elseif(isset($donor->entity))
                                            <a href="entity/view/{{$donor->entity->id}}">{{ $donor->donor->entity->name }}</a></td>
                                        @endif
                                        <td>{{ number_format($donor->amount_donated / 100, 2) }}</td>
                                        <td>{{ $donor->total_donations }}</td>
                                        <td>{{ $donor->created_at }}</td>
                                        <td>
                                            @if(!empty($donor->getLastDonation()))
                                            <a href="/admin/donation/view/{{ $donor->getLastDonation()->id}}">
                                                {{ $donor->getLastDonation()->created_at->diffForHumans()}} - {{ $donor->getLastDonation()->amount / 100}} {{env('CURRENCY')}}
                                            </a>
                                                @endif
                                        </td>


                                        <td class="center">
                                            <a href="/admin/donor/view/{{$donor->id}}"
                                               class="btn btn-sm btn-default">
                                                <i class="fa fa-list"></i> Details</a>
                                        </td>
                                    </tr>

                                @endforeach


                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Person / Entity</th>
                                    <th>Amount donated</th>
                                    <th>Total donations</th>
                                    <th>Registered at</th>
                                    <th>Last donation</th>
                                    <th>Actions</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection