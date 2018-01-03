$(".login_tabs").tabs();
$(".login_tabs").tabs('select_tab', 'login');
$.getScript('https://www.google.com/recaptcha/api.js');
check_login_form();

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
                    document.querySelector("#modal div.modal-content div").innerHTML = '<h5 class="center">Un email vous as été envoyé.</h5>Veuillez verifier votre addresse mail.>';
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

function recover_password() {
    document.querySelector("#modal h4").innerHTML = "Mot de passe oublier";
    document.querySelector("#modal div.modal-content div").innerHTML = "<div class='row'>"
            + '<h5>Saisissez votre adresse mail.</h5>'
            + "<form id='user_recover_password_form'>"
            + "<div class='input-field col s6 offset-s3'>"
            + "<input id='email' type='email' class='validate' required pattern='^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$' onkeyup='check_user_recover_password_form()' onchange='check_user_recover_password_form()'>"
            + "<label for='email'>Adresse Mail</label>"
            + "</div>"
            + "</form>"
            + "</div>"
            + "<div class='card-action center'>"
            + "<a id='user_recover_password_button' class='btn blue waves-effect disabled' onclick='confirm_recover_password()'>Envoie</a>"
            + "</div>";
    $('#modal').modal('open');
}

function check_user_recover_password_form() {
    var form = document.querySelector("#user_recover_password_form");
    var valid = form.email.validity.valid;
    if (valid) {
        $('#user_recover_password_button').removeClass("disabled");
    } else {
        $('#user_recover_password_button').addClass("disabled");
    }
    return valid;
}

function confirm_recover_password() {
    if (check_user_recover_password_form()) {
        var form = document.querySelector("#user_recover_password_form");
        var data = {
            email: form.email.value
        };
        $.post(API_URL + "/user/recoverpassword",
                data,
                function (data) {
                    document.querySelector("#modal h4").innerHTML = "Succes";
                    document.querySelector("#modal div.modal-content div").innerHTML = '<h5 class="center">Un email vous as été envoyé.</h5>';
                    $('#modal').modal('open');
                })
                .fail(function (jqXHR, textStatus) {
                    document.querySelector("#modal h4").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Une erreur est survenue.";
                    document.querySelector("#modal div.modal-content div").innerHTML = jqXHR.statusText;
                    $('#modal').modal('open');
                });
    }
}