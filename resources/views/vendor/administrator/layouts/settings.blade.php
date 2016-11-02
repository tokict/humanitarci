@inject('form', 'scaffold.form')
@inject('template', 'scaffold.template')

@extends($template->layout())

@section('module_header')
    {{ trans('administrator::module.settings') }}
@stop

@section('scaffold.content')
    {!! Form::open() !!}
    <table class="table">
        @foreach($form->getFields() as $field)
        <tr {{ $field->hasErrors() ? 'class="has-error"' : '' }}>
            <td style="width: 20%; min-width: 200px;">
                {!! Form::label($field->getName(), $field->getLabel()) !!}:
                @if ($field->getDescription())
                    <p class="small">{!! $field->getDescription() !!}</p>
                @endif
            </td>
            <td>
                {!! $field->setValue(options_find($field->getName()))->html() !!}
            </td>
        </tr>
        @endforeach

        <tr>
            <td colspan="2" class="text-center">
                <input type="submit" name="save" value="{{ trans('administrator::buttons.save') }}" class="btn btn-primary btn-block" />
            </td>
        </tr>
    </table>

    {!! Form::close() !!}
@stop

@section('scaffold.js')
    @include($template->scripts('listeners'))
    @include($template->scripts('editors'))
@stop
