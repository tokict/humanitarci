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
    templateResult: formatCity, // omitted for brevity, see the source of this page
    templateSelection: formatCitySelection // omitted for brevity, see the source of this page
});

function formatCity (data) {
    if (data.loading) return data.name;

    return "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__title'>" + data.name + " <small>(" +data.city_zip_code+", "+ data.region.name + ")</small></div>";

}

function formatCitySelection (data) {;
    return data.name || data.text;
}



$(".selectPerson").select2({
    ajax: {
        url: "/admin/ajax/persons",
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
    templateResult: formatPerson, // omitted for brevity, see the source of this page
    templateSelection: formatSelectPersonion // omitted for brevity, see the source of this page
});

function formatPerson (data) {
    if (data.loading) return data.first_name+' '+data.last_name;

    return "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__title'>" + data.first_name +" "+ data.last_name + " <small>(" +data.city.name+", "+ data.social_id + ")</small></div>";

}

function formatSelectPersonion (data) {
    return data.first_name?data.first_name+' '+data.last_name: data.text;
}

$(".selectEntity").select2({
    ajax: {
        url: "/admin/ajax/entities",
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
    templateResult: formatEntity, // omitted for brevity, see the source of this page
    templateSelection: formatSelectEntityion // omitted for brevity, see the source of this page
});

function formatEntity (data) {
    if (data.loading) return "";

    return "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__title'>" + data.name + "</small></div>";

}

function formatSelectEntityion (data) {
    return data.name || data.text;
}


$(".selectOrganization").select2({
    ajax: {
        url: "/admin/ajax/organizations",
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
    templateResult: formatOrganization, // omitted for brevity, see the source of this page
    templateSelection: formatSelectOrganization // omitted for brevity, see the source of this page
});

function formatOrganization (data) {
    if (data.loading) return "";

    return "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__title'>" + data.name + "</small></div>";

}

function formatSelectOrganization (data) {
    return data.name || data.text;
}


$(".selectUser").select2({
    ajax: {
        url: "/admin/ajax/users",
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
    templateResult: formatUser, // omitted for brevity, see the source of this page
    templateSelection: formatSelectUser // omitted for brevity, see the source of this page
});

function formatUser (data) {
    if (data.loading) return "";

    return "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__title'>" + data.name + "</small></div>";

}

function formatSelectUser (data) {
    return data.name || data.text;
}


$(".selectGroup").select2({
    ajax: {
        url: "/admin/ajax/groups",
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
    templateResult: formatGroup, // omitted for brevity, see the source of this page
    templateSelection: formatSelectGroup // omitted for brevity, see the source of this page
});

function formatGroup (data) {
    if (data.loading) return "";

    return "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__title'>" + data.name + "</small></div>";

}

function formatSelectGroup (data) {
    return data.name || data.text;
}



$(".selectBeneficiary").select2({
    ajax: {
        url: "/admin/ajax/beneficiaries",
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
    templateResult: formatBeneficiary, // omitted for brevity, see the source of this page
    templateSelection: formatSelectBeneficiary // omitted for brevity, see the source of this page
});

function formatBeneficiary (data) {
    if (data.loading) return "";

    return "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__title'>" + data.name + "</small></div>";

}

function formatSelectBeneficiary (data) {
    return data.name || data.text;
}

