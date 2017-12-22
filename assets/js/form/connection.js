$(".login_tabs").tabs();
$(".login_tabs").tabs('select_tab', 'login');
$.getScript('https://www.google.com/recaptcha/api.js');

function check_login_form() {
    var form = document.querySelector("#login_form");
    var valid = (form.email.validity.valid && form.password.validity.valid)
    if (valid) {
        $("#login_form button").removeClass("disabled");
    } else {
        $("#login_form button").addClass("disabled");
    }
    return valid;
}

document.querySelector("#login_form").addEventListener("submit", function (e) {
    e.preventDefault();
    var form = document.querySelector("#login_form");
    if (check_login_form()) {
        $.post(API_URL + "/login",
                {
                    email: form.email.value,
                    password: form.password.value
                },
                function (data) {
                    window.location.reload();
                    console.log(data);
                })
                .fail(function (data) {
                    console.log(data);
                    $(".login_message").slideDown(400);
                    window.setTimeout(function () {
                        $(".login_message").slideUp(400);
                    }, 2000);
                });

    } else {
        $(".login_message").slideDown(400);
        window.setTimeout(function () {
            $(".login_message").slideUp(400);
        }, 2000);
    }
});

function check_register_form() {
    var form = document.querySelector("#register_form");
    var valid = (
            form.firstname.validity.valid &&
            form.lastname.validity.valid &&
            form.email.validity.valid &&
            form.password.validity.valid &&
            form.password_confirm.value === form.password.value
            );
    if (valid) {
        $("#register_button").removeClass("disabled");
    } else {
        $("#register_button").addClass("disabled");
    }
    console.log(valid);
    return valid;
}

function register(grecaptcha) {
    var form = document.querySelector("#register_form");
    if (check_register_form()) {
        var data = {
            grecaptcha: grecaptcha,
            firstname: form.firstname.value,
            lastname: form.lastname.value,
            email: form.email.value,
            password: form.password.value
        };
        $.post(API_URL + "/user",
                data,
                function (data) {
                    document.querySelector("#modal h4").innerHTML = "<i class='fa fa-check' aria-hidden='true'></i> Compte créé.";
                    document.querySelector("#modal div.modal-content div").innerHTML = '<h3>Un email vous as été envoyé.</h3>Veuillez verifier votre addresse mail.';
                    $('#modal').modal('open');
                })
                .fail(function (jqXHR, textStatus) {
                    document.querySelector("#modal h4").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Une erreur est survenue.";
                    document.querySelector("#modal div.modal-content div").innerHTML = jqXHR.statusText;
                    $('#modal').modal('open');
                });
    }
    window.grecaptcha.reset();
}