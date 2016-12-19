@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Aktivne kampanje</h5>
                    <h1 class="no-margins">3</h1>
                    <div class="stat-percent font-bold text-navy">98% <i class="fa fa-bolt"></i></div>
                    <small>Total income</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Na čekanju</h5>
                    <h1 class="no-margins">2</h1>
                    <div class="stat-percent font-bold text-navy">98% <i class="fa fa-bolt"></i></div>
                    <small>Total income</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Ukupna tražena suma</h5>
                    <h1 class="no-margins">200,000</h1>
                    <div class="stat-percent font-bold text-danger">24% <i class="fa fa-level-down"></i></div>
                    <small>Total income</small>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Uspješne</h5>
                    <h1 class="no-margins">14</h1>
                    <div class="stat-percent font-bold text-danger">24% <i class="fa fa-level-down"></i></div>
                    <small>Total income</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="col-lg-3">
        <div class="ibox">
            <div class="ibox-content">
                <h5>Najpopularnije</h5>
                <table class="table table-stripped small m-t-md">
                    <tbody>
                    <tr>
                        <td class="no-borders">
                            <i class="fa fa-circle text-danger"></i>
                        </td>
                        <td class="no-borders">
                            Example element 1
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <i class="fa fa-circle text-danger"></i>
                        </td>
                        <td>
                            Example element 2
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <i class="fa fa-circle text-danger"></i>
                        </td>
                        <td>
                            Example element 3
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
@endsection