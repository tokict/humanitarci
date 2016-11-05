<script>
    $(function () {
        $('[data-filter-type="date"]').datepicker({
            format: 'yyyy-mm-dd',
            clearBtn: false,
            multidate: false
        });

//    $('[data-filter-type="daterange"]').daterangepicker({
//        format: 'YYYY-MM-DD',
//        clearBtn: true,
//        multidate: true
//    });

        $('[data-filter-type="daterange"]').daterangepicker({
            format: 'YYYY-MM-DD',
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment()
        });

        // activate language switcher
        $('button[data-locale]').click(function () {
            var fn = $(this), locale = fn.data('locale');
            var translatable = fn.closest('.translatable-block').find('.translatable');

            translatable.map(function (index, item) {
                var fn = $(item);
                if (fn.data('locale') == locale) {
                    fn.removeClass('hidden');
                } else {
                    fn.addClass('hidden');
                }
            });
        })
    });
</script>
