var days = new Array("Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche", );
var months = new Array("Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre");
var month_days = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

document.addEventListener("DOMContentLoaded", function (e) {
    document.title = SITE_NAME + " | Reservation";
    document.querySelector("div.row.content").style.backgroundImage = "url(" + SITE_ROOT + "/assets/image/background.jpg)";


    var html = "";

    var year = new Date().getFullYear();
    if (year % 4 === 0 && year !== 1900) {
        month_days[1] = 29;
    }

    html += "<div class='col s12'>"
            + "<div class='tabs calendar'>"
            + "<ul class='tabs tabs-fixed-width grey darken-3'>";


    for (var month of months) {
        html += "<li class='tab col s1'>"
                + "<a href='#" + month + "' class='waves-effect'>" + month + "</a>"
                + "</li>"
    }
    html += "</ul>"
            + "</div></div>"

    html += "<div class='col s12'><div class='col s8'><div class='card'><div class='card-content white z-depth-2'>";
    for (var month = 0; month < months.length; month++) {
        html += "<div class='' id='" + months[month] + "'>"
                + " <table class='striped highlight centered calendar_table'>"
                + "     <thead>"
                + "         <tr class='grey darken-3 white-text'>";
        for (var day = 0; day < days.length; day++) {
            html += "               <th>" + days[day] + " </th>"
        }

        html += "      </tr>"
                + "     </thead>"
                + "     <tbody>"
                + "     <tr>"
        for (var day = 1; day <= month_days[month]; day++) {
            var date = new Date(year, month, day);
            if (date.getDate() === 1 && date.getDay() !== 1) {
                html += "<td colspan='" + (date.getDay() + 6) % 7 + "'></td>"
            }
            html += "<td data-day='" + day + "' data-month='" + month + "' data-year='" + year + "'"
                    + ((date.getMonth() === new Date().getMonth() && date.getDate() === new Date().getDate()) ? " class='today' >" : ">") // if today
                    + date.getDate()
                    + "</btn></td>"
                    + ((date.getDay() === 0) ? "</tr><tr>" : "") // if sunday
        }
        html += "           </tr>"
                + "     </tbody>"
                + " </table>"
                + "</div>";
    }
    html += "</div>"
            + "</div>"
            + "</div>"
            + "<div class='card'><div class='card-content col s4 white z-depth-2' id='reservation_article'>"
            + "<span class='card-title'></span>"
            + "<p></p>"
            + (isAdmin() ? "<a href='/article/editor/reservation' class='btn-floating blue'><i class='fa fa-pencil' aria-hidden='true'></i></a>" : "")
            + "</div>"
            + "</div>"; // card
    document.querySelector("div.container div.row").innerHTML = html;

    $.getJSON(API_URL + "/article/reservation", (data) => {
        document.querySelector("#reservation_article span").innerHTML = data.title;
        document.querySelector("#reservation_article p").innerHTML = data.content;
    });

    $("ul.tabs").tabs();
    $("ul.tabs").tabs("select_tab", months[new Date().getMonth()]);
    var tl = new TimelineLite();
    tl.staggerFrom($("#" + months[new Date().getMonth()] + " td"), 0.1, {alpha: 0, scale: 0.1}, 0.05);


    $("td").mouseenter(function (e) {
        var tl = new TimelineLite();
        tl.to(e.target, 0.15, {scale: 2});
    });

    $("td").mouseleave(function (e) {
        var tl = new TimelineLite();
        tl.to(e.target, 0.15, {scale: 1});
    });


    $("td").click(function (e) {
        var day = e.target.dataset.day;
        var month = e.target.dataset.month;
        var year = e.target.dataset.year;
        var today = new Date();
        if (isModo() || (month >= today.getMonth() && day > today.getDate())) {
            $.get(SITE_ROOT + "/reservation/formulaire", {year: year, month: month, day: day}, function (data) {
                document.querySelector("#modal h4").innerHTML = "Reservation pour le " + day + " " + months[month] + " " + year;
                document.querySelector("#modal div.modal-content div").innerHTML = "<div id='reservation_planning'></div>" + data;
                $('#modal').modal('open');
                if (isModo()) {
                    $.getJSON(API_URL + "/reservation/" + year + "/" + (parseInt(month) + 1) + "/" + day, function (data) {
                        var html = "<table class='bordered centered planning_table'>"
                                + "<thead>"
                                + "<tr class='grey darken-3 white-text'>"
                                + "<th>Heure</th>"
                                + "<th>Nom Complet</th>"
                                + "<th>Activité</th>"
                                + "<th>Support</th>"
                                + "<th>participants</th>"
                                + "<th>Confirmé</th>"
                                + "</tr>"
                                + "</thead>"
                                + "<tbody>";
                        if (data.reservation.length > 0) {
                            for (var reservation of data.reservation) {
                                if(reservation.status){
                                    html += "<tr onclick='view_reservation(" + reservation.reservation_id + ")'>"
                                        + "<td>" + (reservation.time ? reservation.time + "h" : "-" ) + "</td>"
                                        + "<td>" + reservation.full_name + "</td>"
                                        + "<td>" + reservation.activity + "</td>"
                                        + "<td>" + reservation.support + "</td>"
                                        + "<td>" + reservation.people + "</td>"
                                        + (reservation.status == "confirm" ?
                                                "<td class='green white-text'><i class='fa fa-check' aria-hidden='true'></i></td>" : "")
                                        + (reservation.status == "valid" ?
                                                "<td class='red white-text'><i class='fa fa-times' aria-hidden='true'></i></td>" : "")
                                        + "</tr>";
                                }
                                
                            }
                        } else {
                            html += "<tr><td colspan='6'><b>Aucune reservation a cette date</b></td></tr>"
                        }
                        html += "</table><br><h4>Nouvelle Reservation</h4>"
                        document.querySelector("#reservation_planning").innerHTML = html;
                    });
                }
                $('select').material_select();
                $.getScript('https://www.google.com/recaptcha/api.js');
            });
        }
    }
    )
});

function reservate(grecaptcha) {
    var form = document.querySelector("#form_reservation");
    if (check_reservation_form()) {
        var data = {
            grecaptcha: grecaptcha,
            date: form.date.value,
            full_name: form.full_name.value,
            email: form.email.value,
            phone: form.phone.value,
            activity: form.activity.value,
            support: form.support.value,
            people: form.people.value,
            detail: form.detail.value
        };
        $.post(API_URL + "/reservation",
                data,
                function (data) {
                    document.querySelector("#modal h4").innerHTML = "<i class='fa fa-check' aria-hidden='true'></i> Demande de réservation enregistrée.";
                    document.querySelector("#modal div.modal-content div").innerHTML = 'Un email vous as été envoyé.<br><b>Veuillez valider votre réservation.</b>';
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

function check_reservation_form() {
    var form = document.querySelector("#form_reservation");
    var valid = (
            form.full_name.validity.valid &&
            form.email.validity.valid &&
            form.phone.validity.valid &&
            form.activity.validity.valid &&
            form.support.validity.valid &&
            form.people.validity.valid &&
            form.detail.validity.valid
            );
    if (valid) {
        $("#reservation_button").removeClass("disabled");
    } else {
        $("#reservation_button").addClass("disabled");
    }
    return valid;
}