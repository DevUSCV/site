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