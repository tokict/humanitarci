@section('scaffold.js')
    <script>
        $(function() {
            $(document).on('click', '#toggle_collection', function() {
                var fn = $(this);

                $('input[type=checkbox].collection-item').each(function() {
                    $(this).prop("checked", fn.prop('checked'));
                });
            });

            function selected() {
                return $('input[type=checkbox]:checked.collection-item');
            }

            $(document).on('click', '.batch-actions a[data-action]', function() {
                if (! (selected().length && window.confirm('Are you sure?'))) {
                    return false;
                }

                $('#batch_action').val($(this).data('action'));
                $('#collection').submit();

                return false;
            });
        });
    </script>
@append
