document.addEventListener("DOMContentLoaded", function (e) {
    document.querySelector("div.row.content").style.backgroundImage = "url(" + SITE_ROOT + "/assets/image/background.jpg)";
});

function check_contact_user_form(){
    var form = document.querySelector("#contact_user_form");
    valid = (
            form.object.validity.valid &&
            form.message.validity.valid
            );
    if(valid){
        $("#contact_user_button").removeClass("disabled");
    }else{
        $("#contact_user_button").addClass("disabled");
    }
    return valid;
}

function contact_user(user_id){
    if(check_contact_user_form() && user_id > 0){
        var form = document.querySelector("#contact_user_form");
        document.querySelector("#modal h4").innerHTML = "Envoyer un email";
        document.querySelector("#modal div.modal-content div").innerHTML = "<div class='container center'><h5><b>" + form.object.value + "</b></h5><br> "
                + "<p class='col s6 offset-s3'>" + form.message.value + "</p>"
                + "</div>"
                + "<div class='modal-footer'><a class='btn green' onclick='confirm_contact_user(" + user_id + ")'>Confirmer</div></div>";
        $('#modal').modal('open');
    }
}
function confirm_contact_user(user_id){
    if(check_contact_user_form() && user_id > 0){
        var form = document.querySelector("#contact_user_form");
        var data = {
            user_id: user_id,
            object: form.object.value,
            message: form.message.value
        }
        $.post(API_URL + "/user/contact", data, function(success){
            document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Succes";
                document.querySelector("#modal div.modal-content div").innerHTML = "Message envoyé.";
                window.setTimeout(function () {
                    form.reset();;
                }, 2000);
        }).fail(function(jqxhr, status, error) {
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Echec";
                document.querySelector("#modal div.modal-content div").innerHTML = error;
        });
    }
}

function update_user_status(user_id, status) {
    if (isAdmin() && status !== "admin") {
        document.querySelector("#modal h4").innerHTML = "Modification de status";
        document.querySelector("#modal div.modal-content div").innerHTML = "<div class='container center'><h5><b>Nouveau status</b></h5><br> "
                + (status == "modo" ?
                        "<span class='chip blue white-text'>Modérateur</span>" :
                        "<span class='chip green white-text'>Membre</span>")
                + "</div>"
                + "<div class='modal-footer'><a class='btn green' onclick='confirm_update_user_status(" + user_id + ", \"" + status + "\")'>Confirmer</div></div>";
        $('#modal').modal('open');
    }
}

function confirm_update_user_status(user_id, status) {
    if (isAdmin() && status !== "admin") {
        data = {
            user_id: user_id,
            status: status
        };
        $.ajax({
            type: "PUT",
            url: API_URL + "/user/updatestatus",
            data: data,
            dataType: "json",
            success: function (data, textStatus, jqXHR) {
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Succes";
                document.querySelector("#modal div.modal-content div").innerHTML = "Opération effectuée.";
                window.setTimeout(function () {
                    window.location.reload();
                }, 2000);
            },
            error: function (jqxhr, status, error) {
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Echec";
                document.querySelector("#modal div.modal-content div").innerHTML = error;
            }
        });
    }
}

function get_user_reservations(email) {
    $.getJSON(API_URL + "/reservation/name/" + email, function (data) {
        var table = document.querySelector("#user_reservations_table tbody");
        if (data.valid.length) {
            for (var reservation of data.valid) {
                var date = new Date(reservation.date);
                table.innerHTML += "<tr onclick='view_reservation(" + reservation.reservation_id + ")' style='cursor:pointer;'>"
                        + "<td>" + date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear() + "</td>"
                        + "<td>" + (reservation.time ? reservation.time + "h" : "-") + "</td>"
                        + "<td>" + reservation.activity + "</td>"
                        + "<td>" + reservation.support + "</td>"
                        + "<td>" + (reservation.monitor ? reservation.monitor : "-") + "</td>"
                        + "<td>" + reservation.people + "</td>"
                        + (reservation.status === "confirm" ?
                                "<td class='green white-text'><i class='fa fa-check' aria-hidden='true'></i></td>" : "")
                        + (reservation.status === "valid" ?
                                "<td class='red white-text'><i class='fa fa-times' aria-hidden='true'></i></td>" : "")
                        + "</tr>";
            }
        } else {
            table.innerHTML += "<tr>"
                    + "<td colspan='8'>Aucune demande de réservation.</td>"
                    + "</tr>";
        }
    });
}

function get_user_licenses(email) {
    var table = document.querySelector("#user_licences_table tbody");
    $.getJSON(API_URL + "/license/search/" + email, function (data) {
        if (data.length) {
            table.innerHTML = "";
            for (var license of data) {
                table.innerHTML += "<tr>"
                        + "<td>" + license.number + "</td>"
                        + "<td>" + license.lastname + " " + license.firstname + "</td>"
                        + "<td>" + license.aptitude + " " + license.type + "</td>"
                        + "<td>" + license.practice + "</td>"
                        + "<td>" + license.year + "</td>"
                        + "<td>" + license.address + "<br>" + license.zipcode + " " + license.city + "</td>"
                        + "</tr>"
            }
        } else {
            table.innerHTML = "<tr><td colspan='7'>Aucune License</td></tr>"
        }
    });
}

function delete_user(user_id){
    document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Suppression de Compte";
                document.querySelector("#modal div.modal-content div").innerHTML = "<div class='container row'>"
                        + "<p class='col s6 offset-s3'><small>Conformément a la loi « Informatique et Libertés » du 6 janvier 1978, modifiée par la loi du 6 août 2004, l'utilisateur as la possibilité de supprimer ses informations personnels.<br><b>Cette action est irreversible.</b></small></p>"
                        + "<form id='delete_user_form' class='col s6 offset-s3'>"
                        + "<p>"
                        + "<input type='checkbox' id='confirm_delete_me_check1' onclick='check_delete_user_form()' />"
                        + "<label for='confirm_delete_me_check1'>Je veut supprimer ce compte.</label>"
                        + "</p><br>"
                        + "<p>"
                        + "<input type='checkbox' id='confirm_delete_me_check2' onclick='check_delete_user_form()' />"
                        + "<label for='confirm_delete_me_check2'>Je suis sur de moi.</label>"
                        + "</p><br>"
                        + "</form>"
                        + "<div class='card-action center'>"
                        + "<a id='delete_user_button' class='btn red waves-effect disabled' onclick='confirm_delete_user(" + user_id + ")'><i class='fa fa-trash-o' aria-hidden='true'></i> Supprimer mon compte</a>"
                        + "</div>"
                        + "</div>";
                $('#modal').modal('open');
}

function check_delete_user_form(){
    var form = document.querySelector("#delete_user_form");
    valid = form.confirm_delete_me_check1.checked && form.confirm_delete_me_check2.checked;
    if(valid){
        $("#delete_user_button").removeClass("disabled");
    }else{
        $("#delete_user_button").addClass("disabled");
    }
    return valid;
}

function confirm_delete_user(user_id){
    if(check_delete_user_form()){
        var form = document.querySelector("#delete_user_form");
        $.ajax({
            type: "DELETE",
            url: API_URL + "/user/" + user_id,
            data: {
                confirm_delete_user_check1 : form.confirm_delete_me_check1.checked,
                confirm_delete_user_check2: form.confirm_delete_me_check2.checked
            },
            dataType: "json",
            success: function (data, textStatus, jqXHR) {
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Succes";
                document.querySelector("#modal div.modal-content div").innerHTML = "Le compte as été supprimé";
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