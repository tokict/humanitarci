@extends('layouts.admin')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-4">
                <h2>App settings</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-campaigns" aria-expanded="true">Campaigns </a></li>
                        <li class=""><a data-toggle="tab" href="#tab-payments" aria-expanded="false">Payment</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-donations" aria-expanded="false">Donations</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-beneficiaries" aria-expanded="false">Beneficiaries</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-donors" aria-expanded="false">Donors</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-organizations" aria-expanded="false">Organizations</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-users" aria-expanded="false">Users</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-admins" aria-expanded="false">Admins</a></li>
                    </ul>
                    {!! Form::open(['url' => '/admin/settings/all', 'class' => 'form-horizontal']) !!}
                    {{Form::model($settings)}}
                    {{Form::token()}}
                    <div class="tab-content">
                        @include('admin.settings.sections.campaigns')
                        @include('admin.settings.sections.payments')
                        @include('admin.settings.sections.donations')
                        @include('admin.settings.sections.beneficiaries')
                        @include('admin.settings.sections.donors')
                        @include('admin.settings.sections.organizations')
                        @include('admin.settings.sections.users')
                        @include('admin.settings.sections.admins')
                    </div>
                    <button type="submit" class="btn btn-primary btn-md pull-right">Save all</button>
                    {{Form::close()}}


                </div>
            </div>
        </div>
    </div>

@endsection