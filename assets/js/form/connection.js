$(".login_tabs").tabs();
$(".login_tabs").tabs('select_tab', 'login');

document.querySelector("#login_form button").addEventListener("click", function (e) {
    e.preventDefault();
    var form = document.querySelector("#login_form");
    if (form.email.validity.valid
            && form.password.validity.valid) {
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