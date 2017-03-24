/**
 * Created by tino on 11/10/16.
 */
function initMap() {

    $.each($('.coordinatesPicker'), function (index, value) {

        var center = {lat: 45.815399, lng: 15.966568};
        var map = new google.maps.Map(value, {
            zoom: 6,
            height: 400,
            width: 600,
            center: center
        });

        var c = $(this).data('coordinates');
        if(c){
            var parts = c.split(",");
            center = {lat: parseFloat(parts[0]), lng: parseFloat(parts[1])};
        }

        google.maps.event.addListener(map, 'click', function (event) {
            //Get the location that the user clicked.
            var clickedLocation = event.latLng;
            //If the marker hasn't been added.
            if (marker === false) {
                //Create the marker.
                marker = new google.maps.Marker({
                    position: clickedLocation,
                    map: map,
                    draggable: true //make it draggable
                });
                //Listen for drag events!
                google.maps.event.addListener(marker, 'dragend', function (event) {
                    markerLocation();
                });
            } else {
                //Marker has already been added, so just change its location.
                marker.setPosition(clickedLocation);
            }
            //Get the marker's location.
            var string = marker.getPosition().lat() + "," + marker.getPosition().lng()
            $(value).siblings("input").val(string);
        });

        var marker = new google.maps.Marker({
            position: center,
            map: map
        });
    })

    $.each($('.coordinatesShow'), function (index, value) {
        var lat = $(this).data('lat');
        var lng = $(this).data('lng');
        var height = $(this).height();
        var width = $(this).width();

        var center = {lat: lat, lng: lng};

        var map = new google.maps.Map(value, {
            zoom: 6,
            height: height,
            width: width,
            center: center
        });

        var marker = new google.maps.Marker({
            position: center,
            map: map
        });
    })

}
$(document).ready(function () {
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    $('.summernote').summernote({
        height: 300,

    });
    //GOOGLE MAP COORDINATES PICKING


//DATERANGE PICKER
    $('.date-range span').html(moment().subtract(29, 'days').format('YYYY MMMM, D') + ' - ' + moment().format('YYYY MMMM, D'));

    $('.date-range').daterangepicker({
        format: 'YYYY-MM-DD',
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: '2016-12-01',
        maxDate: '2038-12-31',
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'right',
        drops: 'down',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-primary',
        cancelClass: 'btn-default',
        separator: ' to ',
        locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Cancel',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    }, function (start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('.date-range span').html(start.format('YYYY MMMM, D') + ' - ' + end.format('YYYY MMMM, D'));
    });

    $('.clockpicker').clockpicker();
    $('.datepicker').datepicker({
        todayBtn: "linked",
        dateFormat: 'yy-mm-dd',
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });


    /*SELECT 2*/

    /**
     * Created by tino on 11/6/16.
     */
    $(".selectCity").select2({
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
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatCity, // omitted for brevity, see the source of this page
        templateSelection: formatselectCityion // omitted for brevity, see the source of this page
    });

    function formatCity(data) {
        if (data.loading) return data.name;

        return "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__title'>" + data.name + " <small>(" + data.city_zip_code + ", " + data.region.name + ")</small></div>";

    }

    function formatselectCityion(data) {
        ;
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
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatPerson, // omitted for brevity, see the source of this page
        templateSelection: formatSelectPerson// omitted for brevity, see the source of this page
    });

    function formatPerson(data) { console.log(data);
        if (data.loading) return data.first_name + ' ' + data.last_name;

        return "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__title'>" + data.first_name + " " + data.last_name + " <small>(" + data.city + ", " + data.social_id + ")</small></div>";

    }

    function formatSelectPerson(data) {
        return data.first_name ? data.first_name + ' ' + data.last_name : data.text;
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
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatEntity, // omitted for brevity, see the source of this page
        templateSelection: formatSelectEntityion // omitted for brevity, see the source of this page
    });

    function formatEntity(data) {
        if (data.loading) return "";

        return "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__title'>" + data.name + "</small></div>";

    }

    function formatSelectEntityion(data) {
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
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatOrganization, // omitted for brevity, see the source of this page
        templateSelection: formatSelectOrganization // omitted for brevity, see the source of this page
    });

    function formatOrganization(data) {
        if (data.loading) return "";

        return "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__title'>" + data.name + "</small></div>";

    }

    function formatSelectOrganization(data) {
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
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatUser, // omitted for brevity, see the source of this page
        templateSelection: formatSelectUser // omitted for brevity, see the source of this page
    });

    function formatUser(data) {
        if (data.loading) return "";

        return "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__title'>" + data.name + "</small></div>";

    }

    function formatSelectUser(data) {
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
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatGroup, // omitted for brevity, see the source of this page
        templateSelection: formatSelectGroup // omitted for brevity, see the source of this page
    });

    function formatGroup(data) {
        if (data.loading) return "";

        return "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__title'>" + data.name + "</small></div>";

    }

    function formatSelectGroup(data) {
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
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatBeneficiary, // omitted for brevity, see the source of this page
        templateSelection: formatSelectBeneficiary // omitted for brevity, see the source of this page
    });

    function formatBeneficiary(data) {
        if (data.loading) return "";

        return "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__title'>" + data.name + "</small></div>";

    }

    function formatSelectBeneficiary(data) {
        return data.name || data.text;
    }

    $('.footable').footable();

});




