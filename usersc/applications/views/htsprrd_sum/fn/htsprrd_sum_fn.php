<script>
    function namaLeave(){
        $.ajax( {
            url: "../../models/htsprrd_sum/fn_kode_leave.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
            },
            success: function ( json ) {
                data_master = json.data.data_master;
            }
        });
    }
</script>