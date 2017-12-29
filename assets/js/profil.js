document.addEventListener("DOMContentLoaded", function (e) {
    document.title = SITE_NAME + " | Mon Profil";
    document.querySelector("div.row.content").style.backgroundImage = "url(" + SITE_ROOT + "/assets/image/background.jpg)";

    $('.datepicker').pickadate({
        monthsFull: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
        monthsShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec'],
        weekdaysFull: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
        weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Dim'],
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
                        + "</tr>";
            }
        } else {
            license_table.innerHTML += "<tr>"
                    +"<td colspan='8'><b>Vous n'avez aucune license.</b></td>"
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
                                        + "<td>" + date.getDate() + "/" + (date.getMonth()+1) + "/" + date.getFullYear() + "</td>"
                                        + "<td>" + (reservation.time ? reservation.time + "h" : "-" ) + "</td>"
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
                    +"<td colspan='6'><b>Vous n'avez aucune demande de réservation en attente.</b></td>"
                    + "</tr>";
        }
        reservation_table.innerHTML += "<tr><td colspan='6' class='grey lighten-1'>Demandes de reservations confirmées</td></tr>";
        if (data.confirm.length) {
            for (var reservation of data.confirm) {  
                var date = new Date(reservation.date);
                reservation_table.innerHTML += "<tr>"
                                        + "<td>" + date.getDate() + "/" + (date.getMonth()+1) + "/" + date.getFullYear() + "</td>"
                                        + "<td>" + (reservation.time ? reservation.time + "h" : "-" ) + "</td>"
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
                    +"<td colspan='6'><b>Vous n'avez aucune demande de réservation confirmée.</b></td>"
                    + "</tr>";
        }
    });
});
