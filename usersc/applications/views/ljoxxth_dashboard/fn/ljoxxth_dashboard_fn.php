<script>
    function laod_dashboard_logistic (){
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
                }
                
                $('#c_unloading').html(c_unloading);                
                $('#p_unloading_done').css('width', p_unloading_done + '%');
                $('#c_loading').html(c_loading);
                $('#p_loading_done').css('width', p_loading_done + '%');
                
            }
        } );
    };
</script>