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
        var title = $('[name="title"]');
        var last_name = $('[name="cardholder_surname"]');
        var city = $('[name="cardholder_city"]');
        var gender = $('[name="gender"]').find(":selected");
        var zip = $('[name="cardholder_zip_code"]');
        var address = $('[name="cardholder_address"]');
        var country = $('[name="cardholder_country"]');
        var email = $('[name="cardholder_email"]');
        var phone = $('[name="cardholder_phone"]');


        var missing;

        if (title.val() == "") {
            title.css({border: '1px solid red'});
            missing = 1;
        } else {
            name.css({border: '1px solid #ccc'});
        }
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

        if (phone.val() == "") {
            phone.parent().css({border: '1px solid red'});
            missing = 1;
        } else {
            phone.parent().css({border: '1px solid #ccc'});
        }

        if (missing && typeof auth == 'undefined') {
            console.log('Missing data');
            return false;
        }


        //save person in db and create donor

        var data = {
            'contact_email' : email.val(),
            'first_name': name.val(),
            'last_name' : last_name.val(),
            'city' : city.val(),
            'zip' : zip.val(),
            'title' : title.val(),
            'gender' : (title.val() == 'Mr')?'male':'female',
            'address' : address.val(),
            'country' : country.val(),
            'order_token' : $('[name="order_token"]').val(),
            'phone' : phone.val()
        };


        $.ajax({
            url: '/ajax/registration',
            dataType: 'json',
            method: 'post',
            data: data
        }).then(function (response) {console.log(response);
            //This cookie is here because of payment provider verification hash which changes if amount was changed
            createCookie('wentToCheckout', true, 1);
            var form = $('#processForm');
            if($('[name="payment_type"]').find(":selected").val() == 'bank'){

                form.attr('action', bankTransfer)
            }
            form.submit();
        })

    });

    $('[name="payment_type"]').change(function(){
        $.ajax({
            url: '/ajax/changePaymentType',
            dataType: 'json',
            method: 'post',
            data: {type:$('[name="payment_type"]').find(":selected").val() }
        }).then(function (response) {console.log(response);
            window.location.reload();
        })

    });
});