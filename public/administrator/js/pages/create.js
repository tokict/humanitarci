/**
 * Created by tino on 11/6/16.
 */
$(".citySelect").select2({
    ajax: {
        url: "/admin/ajax/cities",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                q: params.term, // search term
                page: params.page
            };
        },
        processResults: function (data, params) {
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            params.page = params.page || 1;

            return {
                results: data,
                pagination: {
                    more: (params.page * 30) < data.total_count
                }
            };
        },
        cache: true
    },
    escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
    minimumInputLength: 1,
    templateResult: formatRepo, // omitted for brevity, see the source of this page
    templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
});

function formatRepo (data) {
    if (data.loading) return data.name;

    return "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__title'>" + data.name + " <small>(" +data.city_zip_code+", "+ data.region.name + ")</small></div>";

}

function formatRepoSelection (data) {console.log(data);
    return data.name || data.text;
}
