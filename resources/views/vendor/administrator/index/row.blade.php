@inject('module', 'scaffold.module')
@inject('columns', 'scaffold.columns')
@inject('actions', 'scaffold.actions')

<tr>
    <th>
        <label for="collection_{{$item->id}}">
            <input type="checkbox" name="collection[]" id="collection_{{$item->id}}" value="{{ $item->id }}" class="collection-item simple">
        </label>
    </th>
    @foreach($columns->getColumns() as $column)
        <td>
            @if(! $column->isGroup())
                {!! $column->format($item) !!}
            @else
                <ul class="list-unstyled">
                    @foreach($column->elements() as $column)
                        @if($value = $column->format($item))
                            <li>
                                @if ($column->standalone())
                                    <strong>{!! $value !!}</strong>
                                @else
                                    <label for="{{ $column->name() }}">{{ $column->title() }}:</label>
                                    {!! $value !!}
                                @endif
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </td>
    @endforeach

    <td class="actions">
        <ul class="list-unstyled">
            @if ($actions->authorize('view', $item))
                <li>
                    {!! link_to(route('scaffold.view', app('scaffold.magnet')->with(['page' => $module, 'id' => $item])->toArray()), "View") !!}
                </li>
            @endif
            @if ($actions->authorize('update', $item))
                <li>
                    {!! link_to(route('scaffold.edit', app('scaffold.magnet')->with(['page' => $module, 'id' => $item])->toArray()), "Edit") !!}
                </li>
            @endif
            @if ($actions->authorize('delete', $item))
                <li>
                    {!! link_to(route('scaffold.delete', app('scaffold.magnet')->with(['page' => $module, 'id' => $item])->toArray()), "Delete", ['onclick' => "return confirm('Are you sure?')"]) !!}
                </li>
            @endif
            @foreach($actions->actions($item) as $singleURL)
                <li>
                    {!! $singleURL !!}
                </li>
            @endforeach
        </ul>
    </td>
</tr>
