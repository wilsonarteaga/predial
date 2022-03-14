$(document).ready(function() {
    loadcalendar();
    $('#search_control').attr('placeholder', 'Buscar paciente...');
    $('#li_search').fadeIn();
});

function loadcalendar() {
    if ($('#json_citas').val().length > 0)
        loadsched(JSON.parse($('#json_citas').val()));
    else
        loadsched([]);
}

function loadsched(ArrResult) {
    var data = [];
    for (i = 0; i < ArrResult.length; i++) {
        var di = parseInt(ArrResult[i].fec_cit.substr(8, 2));
        var mi = parseInt(ArrResult[i].fec_cit.substr(5, 2));
        var yi = parseInt(ArrResult[i].fec_cit.substr(0, 4));
        var hi = parseInt(ArrResult[i].hor_cit.substr(0, 2));
        var mni = parseInt(ArrResult[i].hor_cit.substr(3, 2));

        var df = parseInt(ArrResult[i].fec_cit.substr(8, 2));
        var mf = parseInt(ArrResult[i].fec_cit.substr(5, 2));
        var yf = parseInt(ArrResult[i].fec_cit.substr(0, 4));
        var hf = parseInt(ArrResult[i].hor_cit.substr(0, 2));
        var mnf = parseInt(ArrResult[i].hor_cit.substr(3, 2)) + 59;

        data.push({
            id: ArrResult[i].ide_cit,
            title: ArrResult[i].nom_pac + ' ' + ArrResult[i].ape_pac,
            start: new Date(yi, mi - 1, di, hi, mni, 0),
            end: new Date(yf, mf - 1, df, hf, mnf, 0),
            backgroundColor: '#c7c7c7',
            borderColor: '#c0c0c0',
            allDay: false
        });
    }
    CalendarEvents(data);

}

function CalendarEvents(data) {

    /* initialize the calendar
	-----------------------------------------------------------------*/
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
        },
        //defaultView: 'agendaDay', // Para configurar la vista diaria por defecto
        //defaultDate: t.getNow(),
        navLinks: true, // can click day/week names to navigate views
        //editable: true,
        eventLimit: true, // allow "more" link when too many events
        events: data,
        editable: false,
        droppable: false,
        selectable: true,
        selectHelper: true,
        eventClick: function(calEvent, jsEvent, view) {
            console.log(calEvent);
        }
    });
}


function cleanevents() {
    $("#calendar").fullCalendar('destroy');
}
