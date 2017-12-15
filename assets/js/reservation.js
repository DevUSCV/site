var days = new Array("Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche", );
var months = new Array("Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre");
var month_days = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

document.addEventListener("DOMContentLoaded", function (e) {
    document.title = SITE_NAME + " | Reservation";
    document.querySelector("div.row.content").style.backgroundImage = "url(" + SITE_ROOT + "/assets/image/background.jpg)";


    var html = "";

    var year = new Date().getFullYear();
    if (year % 4 === 0 && year !== 1900)
    {
        month_days[1] = 29;
    }

    html += "<div class='card s12'>"
            + "<div class='card-tabs calendar'>"
            + "<ul class='tabs tabs-fixed-width grey darken-3'>";


    for (let month of months) {
        html += "<li class='tab col s1'>"
                + "<a href='#" + month + "' class='waves-effect'>" + month + "</a>"
                + "</li>"
    }
    html += "</ul>"
            + "</div>" // card-tabs;

    html += "<div class='card-content'>";
    for (let month = 0; month < months.length; month++) {
        html += "<div id='" + months[month] + "'>"
                + " <table class='striped highlight centered calendar_table'>"
                + "     <thead>"
                + "         <tr class='grey darken-3 white-text'>";
        for (let day = 0; day < days.length; day++) {
            html += "               <th>" + days[day] + " </th>"
        }

        html += "      </tr>"
                + "     </thead>"
                + "     <tbody>"
                + "     <tr>"
        for (let day = 1; day <= month_days[month]; day++) {
            let date = new Date(year, month, day);
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
    html += "</div>"; // card
    document.querySelector("div.container div.row").innerHTML = html;

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
        let day = e.target.dataset.day;
        let month = e.target.dataset.month;
        let year = e.target.dataset.year;
        let today = new Date();
        if (month >= today.getMonth() && day > today.getDate()) {
            let html;
            $.getJSON(API_URL + "/reservation/" + year + "/" + (parseInt(month) + 1) + "/" + day, function (data) {
                html = "<table class='striped highlight centered planning_table'>"
                        + "<tbody>";
                for (let hour = 8; hour <= 18; hour = hour + 2) {
                    html += "<tr>"
                            + "<td>" + hour + "h</td>"
                            + "<td>";
                    if (data.reservation[parseInt(hour)]) {
                        html += "PRIS";
                    } else {
                        html += "<button class='btn green waves-effect' onclick='reserver(" + year + "," + month + "," + day + "," + hour + ")'>RESERVER</button>";
                    }
                    html += "</td>"
                            + "</tr>";
                }
                html += "</table>"

                document.querySelector("#modal h4").innerHTML = "Reservation pour le " + day + " " + months[month] + " " + year;
                document.querySelector("#modal div.modal-content div").innerHTML = html;
                $('#modal').modal('open');
            });


        }
    })
});

function reserver(year, month, day, hour) {
    $.get(SITE_ROOT + "/reservation/formulaire" , {year: year, month: month, day: day, hour: hour, rand: Math.round(Math.random()*100000)}, function(data){
        document.querySelector("#modal h4").innerHTML = "Reservation pour le " + day + " " + months[month] + " " + year + " à " + hour + "h";
        document.querySelector("#modal div.modal-content div").innerHTML = data;
    });



    
}
