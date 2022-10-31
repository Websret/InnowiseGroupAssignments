$(document).ready(function () {
    $('#formEmail').blur(function () {
        if ($(this).val() !== '') {
            var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
            if (pattern.test($(this).val())) {
                $(this).css({'border': '2px solid black'});
                $('#validate').attr('disabled', false);
            } else {
                $(this).css({'border': '1px solid #ff0000'});
                $('#validate').attr('disabled', true);
            }
        } else {
            $(this).css({'border': '1px solid #ff0000'});
            $('#valid').text('Enter e-mail!');
            $('#validate').attr('disabled', true);
        }
    });

    $('#formConfirmEmailEmail').blur(function () {
        if ($(this).val() !== '') {
            var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
            if (pattern.test($(this).val())) {
                $(this).css({'border': '2px solid black'});
                $('#validate').attr('disabled', false);
            } else {
                $(this).css({'border': '1px solid #ff0000'});
                $('#validate').attr('disabled', true);
            }
        } else {
            $(this).css({'border': '1px solid #ff0000'});
            $('#valid').text('Enter e-mail!');
            $('#validate').attr('disabled', true);
        }
    });

    $('#formPassword').blur(function () {
        if ($(this).val() !== '') {
            if ($(this).val().length > 6) {
                $(this).css({'border': '2px solid black'});
                $('#validate').attr('disabled', false);
            } else {
                $(this).css({'border': '1px solid #ff0000'});
                $('#validate').attr('disabled', true);
            }

        } else {
            $(this).css({'border': '1px solid #ff0000'});
            $('#nameValid').text('Enter password!');
            $('#validate').attr('disabled', true);
        }
    });

    $('#formConfirmPasswordPassword').blur(function () {
        if ($(this).val() !== '') {
            if ($(this).val().length > 6) {
                $(this).css({'border': '2px solid black'});
                $('#validate').attr('disabled', false);
            } else {
                $(this).css({'border': '1px solid #ff0000'});
                $('#validate').attr('disabled', true);
            }

        } else {
            $(this).css({'border': '1px solid #ff0000'});
            $('#nameValid').text('Enter password!');
            $('#validate').attr('disabled', true);
        }
    });
});

function confirmation() {
    return confirm('Are you sure you want to do this?');
}