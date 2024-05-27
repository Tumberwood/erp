<script>
    function load_dashboard_logistic (){
        $.ajax( {
            url: "../../models/ljoxxth_dashboard/ljoxxth_dashboard_fn_box.php",
            dataType: 'json',
            type: 'POST',
            data: {
                start_date: start_date,
                end_date: end_date
            },
            success: function ( json ) {
                if(json.data.status_code == 200){
                    c_unloading = json.data.rs_ljoxxth[0].c_unloading;
                    c_unloading_done = json.data.rs_ljoxxth[0].c_unloading_done;
                    p_unloading_done = parseInt(c_unloading_done) / parseInt(c_unloading) * 100;
                    c_loading = json.data.rs_ljoxxth[0].c_loading;
                    c_loading_done = json.data.rs_ljoxxth[0].c_loading_done;
                    p_loading_done = parseInt(c_loading_done) / parseInt(c_loading) * 100;

                    c_booking   = json.data.rs_ljoxxth_lprxxmh[0].c_booking;
                    c_arrival   = json.data.rs_ljoxxth_lprxxmh[0].c_arrival;
                    c_process   = json.data.rs_ljoxxth_lprxxmh[0].c_process;
                    c_document  = json.data.rs_ljoxxth_lprxxmh[0].c_document;
                    c_clearance = json.data.rs_ljoxxth_lprxxmh[0].c_clearance;
                    c_done      = json.data.rs_ljoxxth_lprxxmh[0].c_done;
                }
                
                $('#c_unloading').html(c_unloading);                
                $('#p_unloading_done').css('width', p_unloading_done + '%');
                $('#c_loading').html(c_loading);
                $('#p_loading_done').css('width', p_loading_done + '%');
                
                $('#c_booking').html(c_booking);
                $('#c_arrival').html(c_arrival);
                $('#c_process').html(c_process);
                $('#c_document').html(c_document);
                $('#c_clearance').html(c_clearance);
                $('#c_done').html(c_done);
                

            }
        } );
    };
</script>