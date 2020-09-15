$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function(){

    //remove first_name error
    
    $("input[id=first_name]").keyup(function () {
        $(this).removeClass('is-invalid');
        $(this).addClass('is-valid');
        $('#first_name_error_holder').addClass('d-none');
    });

    //remove last_name error

    $("input[id=last_name]").keyup(function () {
        $(this).removeClass('is-invalid');
        $(this).addClass('is-valid');
        $('#last_name_error_holder').addClass('d-none');
    });

    //remove phone_number error

    $("input[id=phone_number]").keyup(function () {
        $(this).removeClass('is-invalid');
        $(this).addClass('is-valid');
        $('#phone_number_error_holder').addClass('d-none');
    });

    //remove email error

    $("input[id=email]").keyup(function () {
        $(this).removeClass('is-invalid');
        $(this).addClass('is-valid');
        $('#email_error_holder').addClass('d-none');
    });

    //get packages on click of div.category_box

    $("div").on("click", "div.category_box", function(){
        var category_id = $(this).attr('data-category-id');
        $('.type_title').removeClass('active');
        $(this).find('.type_title').addClass('active');

        var URL_CONCAT = $('meta[name="index"]').attr('content');

        $.ajax({
            type: 'POST',
            url: URL_CONCAT + '/get_packages',
            data: {parent:category_id},
            beforeSend: function() {
                $('#packages_loader').removeClass('d-none');
                $('#packages_holder').html('&nbsp;');
            },
            success: function(response) {
                $('#packages_holder').fadeIn().html(response);
                $(".owl-carousel").owlCarousel({
                    margin:20,
                    dots:false,
                    nav:true,
                    navText: [
                        '<img src="'+ URL_CONCAT + '/images/left.png">',
                        '<img src="'+ URL_CONCAT + '/images/right.png">'
                    ],
                    responsiveClass: true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        480: {
                            items: 1
                        },
                        769: {
                            items: 3
                        }
                    }
                });
            },
            complete: function () {
                $('#packages_loader').addClass('d-none');
            }
        });
    });

    //append form with selected package_id

    $('body').on('click', 'a.btn_package_select', function() {
        var package_id = $(this).attr('data-package-id');
        $('#package_error').addClass('d-none');


        $('#package_id').remove();
        $('#booking_step_1').append('<input type="hidden" name="package_id" id="package_id" value="'+package_id+'">');
    });

    //handle form submission of step 1
    $('#booking_step_1').submit(function(e){

        var check;
        check = true;
        var first_name;
        first_name = $('input[name=first_name]').val();
        var last_name;
        last_name = $('input[name=last_name]').val();
        var phone_number;
        phone_number = $('input[name=phone_number]').val();
        var email;
        email = $('input[name=email]').val();

        if(first_name === "")
        {
            $('#first_name').addClass('is-invalid');
            $('#first_name_error_holder').removeClass('d-none');
            check = false;
        }
        if(last_name === "")
        {
            $('#last_name').addClass('is-invalid');
            $('#last_name_error_holder').removeClass('d-none');
            check = false;
        }
        if(phone_number === "")
        {
            $('#phone_number').addClass('is-invalid');
            $('#phone_number_error_holder').removeClass('d-none');
            check = false;
        }
        if(email === "")
        {
            $('#email').addClass('is-invalid');
            $('#email_error_holder').removeClass('d-none');
            check = false;
        }

        var emailReg = /^([\w-.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if(!emailReg.test(email))
        {
            $('#email').addClass('is-invalid');
            $('#email_error_holder').removeClass('d-none');
            check = false;
        }

        if(check === false)
        {
            $("html, body").animate({ scrollTop: 0 }, "slow");
            return false;
        }

        var package_id  = $('input[name=package_id]').val();

        if(package_id === undefined)
        {
            $('#package_error').removeClass('d-none');
            $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
            check = false;
        }

        if(check === false)
        {
            return false;
        }
        else if(check === true)
        {
            e.submit();
        }
    });

    //remove address field error
    $('#autocomplete').keyup(function () {
        $(this).removeClass('is-invalid').addClass('is-valid');
        $('#address_error_holder').addClass('d-none');
    });

    //remove date error
    $('#event_date').click(function () {
        $(this).removeClass('is-invalid').addClass('is-valid');
        $('#date_error_holder').addClass('d-none');
    });

    //populate timing slots

    $('input[id="event_date"]').change(function () {
        //populate timing slots
        var selected_date;
        selected_date = $(this).val();

        var URL_CONCAT = $('meta[name="index"]').attr('content');

        //prepare to send ajax request
        $.ajax({
            type: 'POST',
            url: URL_CONCAT + '/get_timing_slots',
            data: {event_date:selected_date},
            beforeSend: function() {
                $('#slots_loader').removeClass('d-none');
            },
            success: function(response) {
                $('#slots_holder').html(response);

            },
            complete: function () {
                $('#slots_loader').addClass('d-none');
            }
        });
    });

    //append selected slot to booking_step_2 form

    $('#slots_holder').on('click', 'a.btn-slot', function() {
        var slot_time = $(this).attr('data-slot-time');
        $('#slots_holder').find('.btn-slot').removeClass('slot-picked');
        $('#booking_slot').remove();
        $('#booking_step_2').append('<input type="hidden" name="booking_slot" id="booking_slot" value="'+slot_time+'">');
        $(this).addClass('slot-picked');
    });

    //handle form submission of step 2

    $('#booking_step_2').submit(function(e){

        var check = true;
        var address;
        address = $('input[name=address]').val();
        var event_date;
        event_date = $('input[name=event_date]').val();
        var booking_slot;
        booking_slot = $('input[name=booking_slot]').val();


        if(event_date === "")
        {
            $('#event_date').addClass('is-invalid');
            $('#date_error_holder').removeClass('d-none');
            $("html, body").animate({ scrollTop: 2000 }, "slow");
            check = false;
        }

        if(check === false)
        {
            return false;
        }
        else if(check === true)
        {
            if(booking_slot === undefined)
            {
                $('#slot_error').removeClass('d-none');
                $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                return false;
            }
            else
            {
                e.submit();
            }
        }
    });


    //initialize addons carousel

    var URL_CONCAT = $('meta[name="index"]').attr('content');

    $("#addons_carousel").owlCarousel({
        margin:20,
        dots:false,
        nav:true,
        navText: [
            '<img src="'+ URL_CONCAT +'/images/left.png">',
            '<img src="'+ URL_CONCAT +'/images/right.png">'
        ],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1
            },
            769: {
                items: 3
            }
        }
    });

    $('.addon_buttons').on('click', 'a.btn-addon', function() {
        var addon_id = $(this).attr('data-addon-id');
        var method = $(this).attr('data-method');

        if(method === "add")
        {
            $.ajax({
                type: 'POST',
                url: URL_CONCAT + '/session_addons',
                data: {addon_id:addon_id, session_email:$('input[name=session_email]').val()},
                success: function() {
                    $('#' + addon_id).attr('data-method','remove');
                }
            });
        }
        else if(method === "remove")
        {
            $.ajax({
                type: 'POST',
                url: URL_CONCAT + '/remove_session_addon',
                data: {addon_id:addon_id, session_email:$('input[name=session_email]').val()},
                success: function() {
                    $('#' + addon_id).attr('data-method','add');
                }
            });
        }
    });

});