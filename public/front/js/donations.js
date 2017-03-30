/**
 * Created by tino on 11/25/16.
 */

var missing = 0;

$(document).ready(function () {
    var name = $('[name="cardholder_name"]');
    var title = $('[name="title"]');
    var last_name = $('[name="cardholder_surname"]');
    var city = $('[name="cardholder_city"]');
    var gender = $('[name="gender"]');
    var zip = $('[name="cardholder_zip_code"]');
    var address = $('[name="cardholder_address"]');
    var country = $('[name="cardholder_country"]');
    var email = $('[name="cardholder_email"]');
    var phone = $('[name="cardholder_phone"]');
    var customAmount = $('#custom_amount');

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
        if($('#custom_amount').val() === "" || $('#custom_amount').val() < 1){
            $('#custom_amount').css({border: '1px solid red'});
        }else {
            window.location = url + '?type=' + type + '&campaign=' + campaign + '&amount=' + amount;
        }
    });


    $("#processFormBtn").click(function (event) {
        event.preventDefault();
        missing = 0;

        if((typeof auth == 'undefined' || auth == false)) {
            if (title.find(":selected").val() == "") {
                title.css({border: '1px solid red'});
                missing = 'title';
            } else {
                title.css({border: '1px solid #ccc'});
            }

            if (name.val() == "") {
                name.css({border: '1px solid red'});
                missing = 'name';
            } else {
                name.css({border: '1px solid #ccc'});
            }

            if (last_name.val() == "") {
                last_name.css({border: '1px solid red'});
                missing = 'last_name';
            } else {
                last_name.css({border: '1px solid #ccc'});
            }

            if (city.val() == "") {
                city.parent().css({border: '1px solid red'});
                missing = 'city';
            } else {
                city.parent().css({border: '1px solid #ccc'});
            }

            if (gender.find(":selected").val() == "") {
                gender.parent().css({border: '1px solid red'});
                missing = 'gender';
            } else {
                gender.parent().css({border: '1px solid #ccc'});
            }

            if (zip.val() == "") {
                zip.parent().css({border: '1px solid red'});
                missing = 'zip';
            } else {
                zip.parent().css({border: '1px solid #ccc'});
            }

            if (address.val() == "") {
                address.parent().css({border: '1px solid red'});
                missing = 'address';
            } else {
                address.parent().css({border: '1px solid #ccc'});
            }

            if (country.val() == "") {
                country.parent().css({border: '1px solid red'});
                missing = 'country';
            } else {
                country.parent().css({border: '1px solid #ccc'});
            }

            if (email.val() == "") {
                email.parent().css({border: '1px solid red'});
                missing = 'email';
            } else {
                email.parent().css({border: '1px solid #ccc'});
            }

            if (phone.val() == "") {
                phone.parent().css({border: '1px solid red'});
                missing = 'phone';
            } else {
                phone.parent().css({border: '1px solid #ccc'});
            }



            if (missing != 0 && (typeof auth == 'undefined' || auth == false)) {
                console.log('Missing ' + missing);
                return false;
            }


            var data = {
                contact_email: email.val(),
                first_name: name.val(),
                last_name: last_name.val(),
                city: city.val(),
                zip: zip.val(),
                gender: (title.find(":selected").val() == 'Mr') ? 'male' : 'female',
                address: address.val(),
                country: country.val(),
                order_token: $('[name="order_token"]').val(),
                contact_phone: phone.val(),
                entity_name: $('[name="entity_name"]').val(),
                entity_address: $('[name="entity_address"]').val(),
                entity_city_id: $('[name="entity_city_id"]').val(),
                entity_tax_id: $('[name="entity_tax_id"]').val(),
                payeeType: $('[name="payeeType"]:checked').val()

            };


            $.ajax({
                url: '/ajax/checkUser',
                dataType: 'json',
                method: 'post',
                data: data
            }).then(function (response) {
                if (response && response.success == true) {
                    //save person in db and create donor
                    $("#emailErrMsg").addClass('hidden');
                    $.ajax({
                        url: '/ajax/registration',
                        dataType: 'json',
                        method: 'post',
                        data: data
                    }).then(function (response) {
                        if (response && response.success == true) {
                            setTimeout('a', 1000);
                            //This cookie is here because of payment provider verification hash which changes if amount was changed
                            createCookie('wentToCheckout', true, 1);
                            var form = $('#processForm');
                            if ($('[name="payment_type"]').find(":selected").val() == 'bank') {

                                form.attr('action', bankTransfer)
                            }
                            form.submit();
                        }
                    })
                } else {
                    $("#emailErrMsg").removeClass('hidden');
                }

            })
        }else{
            setTimeout('a', 1000);
            //This cookie is here because of payment provider verification hash which changes if amount was changed
            createCookie('wentToCheckout', true, 1);
            var form = $('#processForm');
            if ($('[name="payment_type"]').find(":selected").val() == 'bank') {

                form.attr('action', bankTransfer)
            }
            form.submit();
        }


    });

    $('[name="payment_type"]').change(function () {
        $.ajax({
            url: '/ajax/changePaymentType',
            dataType: 'json',
            method: 'post',
            data: {type: $('[name="payment_type"]').find(":selected").val()}
        }).then(function (response) {
            console.log(response);
            window.location.reload();
        })

    });


    $('[name="payeeType"]').change(function () {


        if ($(this).val() == 'company') {
            console.log('company');
            $("#companyInfo").removeClass('hidden');
            bindSelect2();
            $("#payeeIndividualLabel").hide();
        } else {
            $("#companyInfo").addClass('hidden');
            $("#payeeIndividualLabel").show();
        }

    });

});