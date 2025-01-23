<script>
    function ubahAntrian(id,plus_minus){
        $.ajax( {
            url: "../../models/pmi_cylinder_problem_t_action_rechrome/fn_ubah_antrian.php",
            dataType: 'json',
            type: 'POST',
            data: {
                id: id,
                plus_minus: plus_minus
            },
            success: function ( json ) {
                tblpmi_cylinder_problem_t_action.ajax.reload(null, false);
            }
            
        } );
    };

    function maxAntrian(){
        $.ajax( {
            url: "../../models/pmi_cylinder_problem_t_action_rechrome/fn_cek_last_antrian.php",
            dataType: 'json',
            async: false,
            type: 'POST',
            success: function ( json ) {
                max_antrian = json.data.max_antrian;
                // console.log(max_antrian);
            }
            
        } );
    };
</script>