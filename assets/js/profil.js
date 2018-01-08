document.addEventListener("DOMContentLoaded", function (e) {
    document.title = SITE_NAME + " | Mon Profil";
    document.querySelector("div.row.content").style.backgroundImage = "url(" + SITE_ROOT + "/assets/image/background.jpg)";

    $('.datepicker').pickadate({
        monthsFull: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
        monthsShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec'],
        weekdaysFull: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
        weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Dim'],
        format: 'dd/mm/yyyy',
        selectMonths: true,
        max: true,
        selectYears: 110,
        today: null,
        clear: null,
        close: 'Ok',
        closeOnSelect: false
    });

    $.getJSON(API_URL + "/license", function (data) {
        var license_table = document.querySelector("#my_licences tbody");
        if (data.length) {
            for (var license of data) {
                license_table.innerHTML += "<tr>"
                        + "<td>" + license.number + "</td>"
                        + "<td>" + license.firstname + " " + license.lastname + "</td>"
                        + "<td>" + license.aptitude + " " + license.type + "</td>"
                        + "<td>" + license.practice + "</td>"
                        + "<td>" + license.year + "</td>"
                        + "<td>" + license.date + "</td>"
                        + "<td><small>" + license.address + "<br>" + license.zipcode + " " + license.city + "</small></td>"
                        + "<td>" + (license.material ? "<i class='fa fa-check' aria-hidden='true'></i>" : "<i class='fa fa-times' aria-hidden='true'></i>")  + "</td>"
                        + "</tr>";
            }
        } else {
            license_table.innerHTML += "<tr>"
                    + "<td colspan='9'>Vous n'avez aucune license.</td>"
                    + "</tr>";
        }
    });

    $.getJSON(API_URL + "/reservation", function (data) {
        var reservation_table = document.querySelector("#my_reservations tbody");
        reservation_table.innerHTML += "<tr><td colspan='6' class='grey lighten-1'>Demandes de reservations en attente de confirmation</td></tr>";
        if (data.valid.length) {
            for (var reservation of data.valid) {
                var date = new Date(reservation.date);
                reservation_table.innerHTML += "<tr>"
                        + "<td>" + date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear() + "</td>"
                        + "<td>" + (reservation.time ? reservation.time + "h" : "-") + "</td>"
                        + "<td>" + reservation.activity + "</td>"
                        + "<td>" + reservation.support + "</td>"
                        + "<td>" + reservation.people + "</td>"
                        + (reservation.status == "confirm" ?
                                "<td class='green white-text'><i class='fa fa-check' aria-hidden='true'></i></td>" : "")
                        + (reservation.status == "valid" ?
                                "<td class='red white-text'><i class='fa fa-times' aria-hidden='true'></i></td>" : "")
                        + "</tr>";
            }
        } else {
            reservation_table.innerHTML += "<tr>"
                    + "<td colspan='6'>Vous n'avez aucune demande de réservation en attente.</td>"
                    + "</tr>";
        }
        reservation_table.innerHTML += "<tr><td colspan='6' class='grey lighten-1'>Demandes de reservations confirmées</td></tr>";
        if (data.confirm.length) {
            for (var reservation of data.confirm) {
                var date = new Date(reservation.date);
                reservation_table.innerHTML += "<tr>"
                        + "<td>" + date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear() + "</td>"
                        + "<td>" + (reservation.time ? reservation.time + "h" : "-") + "</td>"
                        + "<td>" + reservation.activity + "</td>"
                        + "<td>" + reservation.support + "</td>"
                        + "<td>" + reservation.people + "</td>"
                        + (reservation.status == "confirm" ?
                                "<td class='green white-text'><i class='fa fa-check' aria-hidden='true'></i></td>" : "")
                        + (reservation.status == "valid" ?
                                "<td class='red white-text'><i class='fa fa-times' aria-hidden='true'></i></td>" : "")
                        + "</tr>";
            }
        } else {
            reservation_table.innerHTML += "<tr>"
                    + "<td colspan='6'>Vous n'avez aucune demande de réservation confirmée.</td>"
                    + "</tr>";
        }
    });
});

function check_edit_my_profile_form() {
    var form = document.querySelector("#edit_my_profile_form");
    var valid = (
            form.firstname.validity.valid &&
            form.lastname.validity.valid &&
            form.phone.validity.valid &&
            form.birth_date.validity.valid
            );
    if (valid) {
        $("#edit_my_profile_button").removeClass("disabled");
    } else {
        $("#edit_my_profile_button").addClass("disabled");
    }
    return valid;
}

function edit_my_profil() {
    if (check_edit_my_profile_form()) {
        var form = document.querySelector("#edit_my_profile_form");
        var date = form.birth_date.value.split('/').reverse().join('/');
        var data = {
            firstname: form.firstname.value,
            lastname: form.lastname.value,
            phone: form.phone.value,
            birth_date: date,
        };
        $.ajax({
            type: "put",
            url: API_URL + "/user",
            data: data,
            dataType: "json",
            success: function (data, textStatus, jqXHR) {
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Succes";
                document.querySelector("#modal div.modal-content div").innerHTML = "Votre profil as été mis a jour.";
                $('#modal').modal('open');
                window.setTimeout(function () {
                    window.location.reload();
                }, 2000);
            },
            error: function (jqxhr, status, error) {
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Echec";
                document.querySelector("#modal div.modal-content div").innerHTML = error;
                $('#modal').modal('open');
            }
        });
    }
}

function user_change_password() {
    $.get(SITE_ROOT + "/form/changepassword", function (data) {
        document.querySelector("#modal h4").innerHTML = "Changer mon mot de passe";
        document.querySelector("#modal div.modal-content div").innerHTML = data;
        $('#modal').modal('open');
    });
}

function check_user_change_password_form() {
    var form = document.querySelector("#user_change_password_form");
    valid = (
            form.old_password.validity.valid &&
            form.new_password.validity.valid &&
            (form.new_password.value === form.confirm_new_password.value)
            );
    if (valid) {
        $("#user_change_password_button").removeClass("disabled");
    } else {
        $("#user_change_password_button").addClass("disabled");
    }
    return valid;
}

function confirm_user_change_password() {
    if (check_user_change_password_form()) {
        var form = document.querySelector("#user_change_password_form");
        var data = {
            old_password: form.old_password.value,
            new_password: form.new_password.value,
            confirm_new_password: form.confirm_new_password.value
        };
        $.ajax({
            type: "put",
            url: API_URL + "/user/updatepassword",
            data: data,
            dataType: "json",
            success: function (data, textStatus, jqXHR) {
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Succes";
                document.querySelector("#modal div.modal-content div").innerHTML = "Votre mot de passe as été modifier";
                $('#modal').modal('open');
                window.setTimeout(function () {
                    window.location = "../";
                }, 2000);
            },
            error: function (jqxhr, status, error) {
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Echec";
                document.querySelector("#modal div.modal-content div").innerHTML = error;
                $('#modal').modal('open');
            }
        });
    }
}

function delete_me(){
    document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Suppression de Compte";
                document.querySelector("#modal div.modal-content div").innerHTML = "<div class='container row'>"
                        + "<p class='col s6 offset-s3'><small>Conformément a la loi « Informatique et Libertés » du 6 janvier 1978, modifiée par la loi du 6 août 2004, vous avez la possibilité de supprimer vos informations personnels.<br><b>Cette action est irreversible.</b></small></p>"
                        + "<form id='delete_me_form' class='col s6 offset-s3'>"
                        + "<p>"
                        + "<input type='checkbox' id='confirm_delete_me_check1' onclick='check_delete_me_form()' />"
                        + "<label for='confirm_delete_me_check1'>Je veut supprimer mon compte.</label>"
                        + "</p><br>"
                        + "<p>"
                        + "<input type='checkbox' id='confirm_delete_me_check2' onclick='check_delete_me_form()' />"
                        + "<label for='confirm_delete_me_check2'>Je suis sur de moi.</label>"
                        + "</p><br>"
                        + "</form>"
                        + "<div class='card-action center'>"
                        + "<a id='delete_me_button' class='btn red waves-effect disabled' onclick='confirm_delete_me()'><i class='fa fa-trash-o' aria-hidden='true'></i> Supprimer mon compte</a>"
                        + "</div>"
                        + "</div>";
                $('#modal').modal('open');
}

function check_delete_me_form(){
    var form = document.querySelector("#delete_me_form");
    valid = form.confirm_delete_me_check1.checked && form.confirm_delete_me_check2.checked;
    if(valid){
        $("#delete_me_button").removeClass("disabled");
    }else{
        $("#delete_me_button").addClass("disabled");
    }
    return valid;
}

function confirm_delete_me(){
    if(check_delete_me_form()){
        var form = document.querySelector("#delete_me_form");
        $.ajax({
            type: "DELETE",
            url: API_URL + "/user",
            data: {
                confirm_delete_me_check1 : form.confirm_delete_me_check1.checked,
                confirm_delete_me_check2: form.confirm_delete_me_check2.checked
            },
            dataType: "json",
            success: function (data, textStatus, jqXHR) {
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Succes";
                document.querySelector("#modal div.modal-content div").innerHTML = "Votre compte as été supprimé";
                window.setTimeout(function () {
                    window.location = "../";
                }, 2000);
            },
            error: function (jqxhr, status, error) {
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Echec";
                document.querySelector("#modal div.modal-content div").innerHTML = error;
            }
        });
    }
}