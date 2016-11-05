<tr class="{{ $field->hasErrors() ? 'has-error' : '' }} {{ (\admin\helpers\hidden_element($field) ? 'hidden' : '') }}">
    <td style="width: 20%; min-width: 200px;">
        {!! Form::label($field->getName(), $field->getLabel()) !!}:
        @if ($field->getDescription())
            <p class="small">{!! $field->getDescription() !!}</p>
        @endif
    </td>
    <td>
        {!! $field->html() !!}
    </td>
</tr>
