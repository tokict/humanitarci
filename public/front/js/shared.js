/**
 * Created by tino on 11/10/16.
 */
function initMap() {

    $.each($('.coordinatesPicker'), function(index, value){

        var center = {lat: 45.815399, lng: 	15.966568};
        var map = new google.maps.Map(value, {
            zoom: 6,
            height: 400,
            width: 600,
            center: center
        });

        google.maps.event.addListener(map, 'click', function(event) {
            //Get the location that the user clicked.
            var clickedLocation = event.latLng;
            //If the marker hasn't been added.
            if(marker === false){
                //Create the marker.
                marker = new google.maps.Marker({
                    position: clickedLocation,
                    map: map,
                    draggable: true //make it draggable
                });
                //Listen for drag events!
                google.maps.event.addListener(marker, 'dragend', function(event){
                    markerLocation();
                });
            } else{
                //Marker has already been added, so just change its location.
                marker.setPosition(clickedLocation);
            }
            //Get the marker's location.
            var string = marker.getPosition().lat()+","+marker.getPosition().lng()
            $(value).siblings("input").val(string);
        });

        var marker = new google.maps.Marker({
            position: center,
            map: map
        });
    })

    $.each($('.coordinatesShow'), function(index, value){
        var lat = $(this).data('lat');
        var lng = $(this).data('lng');
        var height = $(this).height();
        var width = $(this).width();

        var center = {lat: lat, lng: 	lng};

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

    /*SELECT 2*/

    /**
     * Created by tino on 11/6/16.
     */
    $(".selectCity").select2({
        ajax: {
            url: "/ajax/cities",
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
        templateSelection: formatselectCityion // omitted for brevity, see the source of this page
    });

    function formatCity (data) {
        if (data.loading) return data.name;

        return "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__title'>" + data.name + " <small>(" +data.city_zip_code+", "+ data.region.name + ")</small></div>";

    }

    function formatselectCityion (data) {;
        return data.name || data.text;
    }



    $(".selectOrganization").select2({
        ajax: {
            url: "/ajax/organizations",
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


    $(".selectBeneficiary").select2({
        ajax: {
            url: "/ajax/beneficiaries",
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



});




