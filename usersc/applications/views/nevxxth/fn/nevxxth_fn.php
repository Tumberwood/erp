<script>
    function nevxxth_fn_load_calendar (){
    
    

        $.ajax( {
            url: "../../models/nevxxth/nevxxth_fn_load_calendar.php",
            dataType: 'json',
            type: 'POST',
            data: {
                // start: start.toISOString(), // Konversi ke format ISO
                // end: end.toISOString() // Konversi ke format ISO
            },
            success: function ( json ) {
                event_data = json.data.rs_nevxxth
                initializeCalendar(); 
            }
        } );
    };

    

    function initializeCalendar() {

        var calendarEl = $('#calendar')[0];
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                start: 'custom1,custom2',
                center: 'title',
                end: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            footerToolbar: {
                start: '',
                center: '',
                end: 'prevYear,prev,next,nextYear'
            },
            customButtons: {
                custom1: {
                    text: 'Create',
                    click: function() {
                        edtnevxxth
                            .buttons({
                                label: 'Save',
                                fn: function () {
                                    this.submit();
                                }
                            })
                            .create()
                            .title('Create');
                    }
                },
                custom2: {
                    text: 'Edit',
                    click: function() {
                        edtnevxxth
                            .buttons({
                                label: 'Save',
                                fn: function () {
                                    this.submit();
                                }
                            })
                            .edit()
                            .title('Edit');
                    }
                }
            },
            contentHeight: 400,
            events: event_data,
            dateClick: function(info) {
                // Lakukan aksi tambahan saat pengguna mengklik tanggal pada tampilan bulan
                console.log('Tanggal yang diklik:', info.date);
            },
            // viewDidMount: function(view) {
            //     console.log(view.view.dateEnv.computeRange());
            //     if (view.view.type == 'dayGridMonth') {
                    
            //     }
            // }
            eventSources: [

                // your event source
                {
                url: "../../models/nevxxth/nevxxth_fn_load_calendar.php",
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