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


    $("#processFormBtn").click(function (event) {
        event.preventDefault();


        var name = $('[name="cardholder_name"]');
        var last_name = $('[name="cardholder_surname"]');
        var city = $('[name="cardholder_city"]');
        var gender = $('[name="gender"]').find(":selected");
        var zip = $('[name="cardholder_zip_code"]');
        var address = $('[name="cardholder_address"]');
        var country = $('[name="cardholder_country"]');
        var email = $('[name="cardholder_email"]');


        var missing;


        if (name.val() == "") {
            name.css({border: '1px solid red'});
            missing = 1;
        } else {
            name.css({border: '1px solid #ccc'});
        }

        if (last_name.val() == "") {
            last_name.css({border: '1px solid red'});
            missing = 1;
        } else {
            last_name.css({border: '1px solid #ccc'});
        }

        if (city.val() == "") {
            city.parent().css({border: '1px solid red'});
            missing = 1;
        } else {
            city.parent().css({border: '1px solid #ccc'});
        }

        if (gender.val() == "") {
            gender.parent().css({border: '1px solid red'});
            missing = 1;
        } else {
            gender.parent().css({border: '1px solid #ccc'});
        }

        if (zip.val() == "") {
            zip.parent().css({border: '1px solid red'});
            missing = 1;
        } else {
            zip.parent().css({border: '1px solid #ccc'});
        }

        if (address.val() == "") {
            address.parent().css({border: '1px solid red'});
            missing = 1;
        } else {
            address.parent().css({border: '1px solid #ccc'});
        }

        if (country.val() == "") {
            country.parent().css({border: '1px solid red'});
            missing = 1;
        } else {
            country.parent().css({border: '1px solid #ccc'});
        }

        if (email.val() == "") {
            email.parent().css({border: '1px solid red'});
            missing = 1;
        } else {
            email.parent().css({border: '1px solid #ccc'});
        }

        if (missing) {
            return false;
        }


        //save person in db and create donor

        var data = {
            'contact_email' : email.val(),
            'first_name': name.val(),
            'last_name' : last_name.val(),
            'city' : city.val(),
            'zip' : zip.val(),
            'address' : address.val(),
            'country' : country.val(),
        };


        $.ajax({
            url: '/ajax/registration',
            dataType: 'json',
            method: 'post',
            data: data
        }).then(function (response) {console.log(4535);
            createCookie('wentToCheckout', true, 1);
            $('#processForm').submit();
        })


    });


});