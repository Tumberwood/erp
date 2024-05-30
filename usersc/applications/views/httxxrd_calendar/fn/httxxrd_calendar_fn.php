<script>
    function fn_load_calendar (){
    
    

        $.ajax( {
            url: "../../httxxrd_calendar/fn_load_calendar.php",
            dataType: 'json',
            type: 'POST',
            data: {
                // start: start.toISOString(), // Konversi ke format ISO
                // end: end.toISOString() // Konversi ke format ISO
            },
            success: function ( json ) {
                event_data = json.data.rs_httxxrd
                initializeCalendar(); 
            }
        } );
    };

    

    function initializeCalendar() {

        var calendarEl = $('#calendar')[0];
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            navLinks: true,
            headerToolbar: {
                center: 'title',
                end: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            footerToolbar: {
                start: '',
                center: '',
                end: 'prevYear,prev,next,nextYear'
            },
            contentHeight: 400,
            events: event_data,
            // viewDidMount: function(view) {
            //     console.log(view.view.dateEnv.computeRange());
            //     if (view.view.type == 'dayGridMonth') {
                    
            //     }
            // }
            eventClick: function(info) {
                alert('Event: ' + info.event.title);

                // change the border color just for fun
                info.el.style.borderColor = 'red';
            },
            eventSources: [

                // your event source
                {
                url: "../../httxxrd_calendar/fn_load_calendar.php",
                method: 'POST',
                extraParams: {
                    custom_param1: 'something',
                    custom_param2: 'somethingelse'
                },
                failure: function() {
                    alert('there was an error while fetching events!');
                },
                color: 'yellow',   // a non-ajax option
                textColor: 'black' // a non-ajax option
                }

                // any other sources...

            ]
        });
        calendar.render();
    }
</script>