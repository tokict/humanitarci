@inject('template', 'scaffold.template')

@inject('blankPanel', 'App\Http\Terranet\Administrator\Dashboard\BlankPanel')
@inject('databasePanel', 'App\Http\Terranet\Administrator\Dashboard\DatabasePanel')
@inject('membersPanel', 'App\Http\Terranet\Administrator\Dashboard\MembersPanel')

@extends($template->layout())

@section('scaffold.content')
<section class="row">
    <section class="col-lg-12">
        {!! $blankPanel->render() !!}
    </section>
</section>

<section class="row">
    <section class="col-lg-6">
        {!! $membersPanel->render() !!}
    </section>
    <section class="col-lg-6">
        {!! $databasePanel->render() !!}
    </section>
</section>
@endsection
