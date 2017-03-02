@extends('layouts.admin')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Groups listing</h5>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <div class="col-md-12 text-center">
                                {{$groups->links()}}
                            </div>
                            <table class="table table-striped table-bordered table-hover groups-table" >
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Representing entity</th>
                                    <th>Representing person</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($groups as $group)
                                    <tr class="gradeX">
                                        <td>{{ $group->name }}</td>
                                        <td>{{ $group->description }}</td>
                                        <td class="center">
                                            @if($group->legalEntity)
                                                <a href="/admin/entity/view/{{$group->representingEntity->id}}">
                                                    {{
                                                $group->legalEntity->name }}</a>
                                                @endif
                                        </td>

                                        <td class="center">
                                            @if($group->representingPerson)
                                                <a href="/admin/person/view/{{$group->representingPerson->id}}">
                                            {{
                                        $group->representingPerson->first_name .' '.$group->representingPerson->last_name }}</a>
                                        @endif
                                        </td>


                                        <td class="center">
                                            <a href="/admin/group/edit/{{$group->id}}"
                                               class="btn btn-sm btn-default"><i class="fa fa-edit"></i> Edit</a>
                                        </td>
                                    </tr>

                                @endforeach




                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Representing entity</th>
                                    <th>Representing person</th>
                                    <th>Actions</th>
                                </tr>
                                </tfoot>
                            </table>
                            <div class="col-md-12 text-center">
                                {{$groups->links()}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection