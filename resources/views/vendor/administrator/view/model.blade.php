@if (isset($title))
    <h3 class="lead">{{ $title }}</h3>
@endif

<div class="box no-border">
    <div class="box-body no-padding">
        <table class="table table-striped">
            @foreach(\admin\helpers\eloquent_attributes($item) as $key => $value)
                @if (! (is_array($value) || is_object($value)))
                    <tr>
                        <th style="width: 20%; min-width: 200px;">{{ \admin\helpers\str_humanize($key) }}</th>
                        <td>{!! \admin\helpers\eloquent_attribute($item, $key) !!}</td>
                    </tr>
                @endif
            @endforeach
        </table>
    </div>
</div>