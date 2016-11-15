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
        });console.log(map);

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

}
$(document).ready(function () {
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    $('.summernote').summernote();
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
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    }, function(start, end, label) {
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

});

