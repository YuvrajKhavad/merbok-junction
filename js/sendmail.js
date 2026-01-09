

// Form Validation

$("#contact-form").submit(function (event) {
    event.preventDefault(); // Prevent the default form submission behavior
    console.log('click');
    // Validate the form using the jQuery Validation Plugin
    if ($(this).valid()) {
        $("#zi-submit").prop('disabled', true);
        var $form = $(this);

        // Serialize the form data
        var formData = new FormData($form[0]);

        // Send the form data using AJAX
        $.ajax({
            type: "POST",
            url: "mail.php",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $('#zi-submit').text('Sending...');
            },
            success: function (response) {

                console.log("Response from server:", response); // Add this line for debugging

                $('#contact-form')[0].reset();

                if (response.success == true) {
                    // Handle success case
                    $('.thankyou-msg').removeClass('d-none');
                    $('.thankyou-msg span').html(response.message);

                    setTimeout(() => {
                        $('.thankyou-msg').addClass('d-none');
                    }, 3000);
                } else {
                    // Handle error case
                    $('.thankyou-msg').removeClass('d-none');
                    $('.thankyou-msg').removeClass('alert-success');
                    $('.thankyou-msg').addClass('alert-danger');
                    $('.thankyou-msg span').text(response.message);
                    setTimeout(function () {
                        $('.thankyou-msg').addClass('d-none');
                    }, 5000);
                }

                $("#zi-submit").prop('disabled', false);
            },
            error: function () {
                $('#zi-submit').text('Submit')
                $('.thankyou-msg').removeClass('d-none');
                $('.thankyou-msg').removeClass('alert-success');
                $('.thankyou-msg').addClass('alert-danger');
                $('.thankyou-msg span').text("An error occurred while submitting the form.");
                setTimeout(function () {
                    $('.thankyou-msg').addClass('d-none');
                }, 5000);

                $("#zi-submit").prop('disabled', false);
            }
        });
    }
});

$("#contact-form").validate({
    rules: {
        'f_name': {
            required: true,
        },
        'email': {
            required: true,
            email: true
        },
        'mobile_number': {
            required: true,
            number: true
        },
        'know_about': {
            required: true,
        },
        'privacy': {
            required: true,
        },
    },
    messages: {
        'f_name': {
            required: "Please enter your first name.",
        },
        'email': {
            required: "Please enter your email.",
            email: "Your email address is invalid. Please enter a valid address.",
        },
        'mobile_number': {
            required: "Please enter your number",
            number: "Your phone number is invalid. Please enter a valid number."
        },
        'know_about': {
            required: "Please select an option.",
        },
        'privacy': {
            required: "You must agree to the terms and conditions before continuing.",
        },
    },
});