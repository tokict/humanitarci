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
                                {{$banks->links()}}
                            </div>
                            <table class="table table-striped table-bordered table-hover banks-table" >
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>SWIFT</th>
                                    <th>Company</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($banks as $bank)
                                    <tr class="gradeX">
                                        <td>{{ $bank->name }}</td>
                                        <td>{{ $bank->swift_code }}</td>
                                        <td class="center">{{ $bank->legalEntity->name }}</td>


                                        <td class="center">
                                            <a href="/admin/bank/edit/{{$bank->id}}"
                                               class="btn btn-sm btn-default"><i class="fa fa-edit"></i> Edit</a>
                                        </td>
                                    </tr>

                                @endforeach




                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>SWIFT</th>
                                    <th>Company</th>
                                    <th>Actions</th>
                                </tr>
                                </tfoot>
                            </table>
                            <div class="col-md-12 text-center">
                                {{$banks->links()}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection