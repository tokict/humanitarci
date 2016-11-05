@inject('columns', 'scaffold.columns')
@inject('sortable', 'scaffold.sortable')

<th style="text-wrap: none; {{ ('id' == strtolower($column->name()) ? 'width: 50px;' : '') }}; vertical-align: top">
    @if ($sortable->canSortBy($column->name()))
        <a href="{{ $sortable->makeUrl($column->name()) }}">
            {{ $column->title() }}{!! ($sortable->element() == $column->name() ? ('asc' == $sortable->direction() ? '&uparrow;' : '&downarrow;') : '') !!}
        </a>
    @else
        {{ $column->title() }}
    @endif
</th>
