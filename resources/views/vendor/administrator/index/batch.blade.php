@if (! empty($global = $actions->batch()))
    <div class="pull-left">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            {{ trans('administrator::buttons.batch_actions') }}
            <span class="fa fa-caret-down"></span>
        </button>
        <ul class="dropdown-menu batch-actions">
            @foreach($global as $action)
                <li>{!! $action !!}</li>
            @endforeach
        </ul>
    </div>
@endif

