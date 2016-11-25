/**
 * Created by tino on 11/25/16.
 */


$(document).ready(function () {
    $('.fixedDonation').click(function () {
        var url = $(this).data("url");
        var amount = $(this).data("amount");
        var campaign = $(this).data("campaign");
        var type = $('input[name=donation_type]:checked').val()
        window.location = url + '?type=' + type + '&campaign=' + campaign + '&amount=' + amount;


    });
    $('#custom_donation_btn').click(function () {
        var url = $(this).data("url");
        var amount = $('#custom_amount').val();
        var campaign = $(this).data("campaign");
        var type = $('input[name=donation_type]:checked').val()
        window.location = url + '?type=' + type + '&campaign=' + campaign + '&amount=' + amount;
    });


    $("#processFormBtn").click(function () {
        var name = $('[name="first_name"]');
        var last_name = $('[name="last_name"]');
        var city = $('[name="city_id"]');
        var gender = $('[name="gender"]').find(":selected");
        var missing;


        if (name.val() == "") {
            name.css({border: '1px solid red'});
            missing = 1;
        }else{
            name.css({border: '1px solid #ccc'});
        }

        if (last_name.val() == "") {
            last_name.css({border: '1px solid red'});
            missing = 1;
        }else{
            last_name.css({border: '1px solid #ccc'});
        }

        if (city.val() == "") {
            city.parent().css({border: '1px solid red'});
            missing = 1;
        }else{
            city.parent().css({border: '1px solid #ccc'});
        }

        if (gender.val() == "") {
            gender.parent().css({border: '1px solid red'});
            missing = 1;
        }else{
            gender.parent().css({border: '1px solid #ccc'});
        }

        if(missing){
            return false;
        }

        $('#processForm').submit();
    });


});