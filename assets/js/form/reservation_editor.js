document.addEventListener("DOMContentLoaded", function (e) {
    document.querySelector("div.row.content").style.backgroundImage = "url(" + SITE_ROOT + "/assets/image/background.jpg)";


    $('.timepicker').pickatime({
        default: '10:00', // Set default time: 'now', '1:30AM', '16:30'
        fromnow: 0, // set default time to * milliseconds from now (using with default = 'now')
        twelvehour: false, // Use AM/PM or 24-hour format
        donetext: 'OK', // text for done-button
        cleartext: '', // text for clear-button
        canceltext: '', // Text for cancel-button
        autoclose: false, // automatic close timepicker
        ampmclickable: true, // make AM PM clickable
    });

});

function check_confirm_reservation_form() {
    var form = document.querySelector("#confirm_reservation_form");
    var valid = (
            form.time.validity.valid &&
            form.monitor.validity.valid
            );
    if (valid) {
        $("#confirm_reservation_button").removeClass("disabled");
    } else {
        $("#confirm_reservation_button").addClass("disabled");
    }
    return valid;
}

function check_sendmail_form() {
    var form = document.querySelector("#sendmail_form");
    var valid = (
            form.new_message.validity.valid
            );
    if (valid) {
        $("#sendmail_button").removeClass("disabled");
    } else {
        $("#sendmail_button").addClass("disabled");
    }
    return valid;
}

function confirm_reservation() {
    var form = document.querySelector("#confirm_reservation_form");
    if (check_confirm_reservation_form()) {
        reservation.time = form.time.value;
        reservation.monitor = form.monitor.value;
        var date = new Date(reservation.date);

        document.querySelector("#modal h4").innerHTML = "Confirmer une réservation";
        document.querySelector("#modal div.modal-content div").innerHTML = "<div class='container row'><table class='centered bordered col s6 offset-s3'>"
                + "<thead><tr><th colspan='2'>Confirmer la réservation du " + date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear() + "</th></tr></thead>"
                //+ "<tr><td><b>Date</b></td><td>" + date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear() + "</td></tr>"
                + "<tr><td><b>Heure</b></td><td>" + reservation.time + "</td></tr>"
                + "<tr><td><b>Moniteur</b></td><td>" + reservation.monitor + "</td></tr>"
                + "<tr><td><b>Activité</b></td><td>" + reservation.activity + "</td></tr>"
                + "<tr><td><b>Support</b></td><td>" + reservation.support + "</td></tr>"
                + "<tr><td><b>Nb de participants</b></td><td>" + reservation.people + "</td></tr>"
                + "</table></div>"
                + "Un email sera envoyer a " + reservation.email
                + "<div class='modal-footer'><a class='btn green' onclick='confirm_confirm_reservation()'><i class='fa fa-check' aria-hidden='true'></i> Confirmer</div></div>";
        $('#modal').modal('open');
    }
}

function confirm_confirm_reservation() {
    if (check_confirm_reservation_form()) {
        var form = document.querySelector("#confirm_reservation_form");
        $.ajax({
            type: "PUT",
            url: API_URL + "/reservation/confirm",
            data: reservation,
            dataType: "json",
            success: function (data, textStatus, jqXHR) {
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Succes";
                document.querySelector("#modal div.modal-content div").innerHTML = "La réservation est confirmé.";
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

function sendmail() {
    var form = document.querySelector("#sendmail_form");
    if (check_sendmail_form()) {
        document.querySelector("#modal h4").innerHTML = "Envoyer un Message";
        document.querySelector("#modal div.modal-content div").innerHTML = "<div class='container row'>"
                + "<div class='col s6 offset-s3'><b>Votre message: </b><br>"
                + form.new_message.value
                + "</div>"
                + "</div>"
                + "<div class='modal-footer'>" 
                + "<p class='left'>Sera envoyé a " + reservation.email + "</p><a class='btn green' onclick='confirm_sendmail()'><i class='fa fa-check' aria-hidden='true'></i> Confirmer</div></div>";
        $('#modal').modal('open');
    }
}

function confirm_sendmail() {
    if(check_sendmail_form()){
        var data = {
            reservation_id: reservation.reservation_id,
            message: document.querySelector("#sendmail_form").new_message.value
        };
        $.ajax({
            type: "POST",
            url: API_URL + "/reservation/sendmail",
            data: data,
            dataType: "json",
            success: function (data, textStatus, jqXHR) {
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Succes";
                document.querySelector("#modal div.modal-content div").innerHTML = "Votre message as été envoyé a " + reservation.email;
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

function cancel_reservation() {
    document.querySelector("#modal h4").innerHTML = "Annuler la réservation";
    document.querySelector("#modal div.modal-content div").innerHTML = "<div class='container row'>Voulez vous annuler cette réservation ?<br>Cette action est irreversible.</div>"
            + "<div class='modal-footer'><a class='btn red' onclick='confirm_cancel_reservation()'><i class='fa fa-trash-o' aria-hidden='true'></i> Confirmer</div></div>";
    $('#modal').modal('open');
}

function confirm_cancel_reservation() {
    $.ajax({
        type: "DELETE",
        url: API_URL + "/reservation/" + reservation.reservation_id,
        dataType: "json",
        success: function (data, textStatus, jqXHR) {
            document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Succes";
            document.querySelector("#modal div.modal-content div").innerHTML = "La réservation est annulé.";
            window.setTimeout(function () {
                window.history.back();
            }, 2000);
        },
        error: function (jqxhr, status, error) {
            document.querySelector("#modal h4").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Echec";
            document.querySelector("#modal div.modal-content div").innerHTML = error;
        }
    });
}