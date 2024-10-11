<script>
    function interviewPertama(){
        $.ajax( {
            url: "../../models/hrcivth/hrcivth_fn_interview.php",
            dataType: 'json',
            type: 'POST',
            success: function ( json ) {
                
                $('#interview').html(json.data.rs_interview.label);
            }
        } );
    };
</script>