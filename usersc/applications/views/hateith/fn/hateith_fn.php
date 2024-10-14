<script>
    function interviewPertama(){
        $.ajax( {
            url: "../../models/hateith/hateith_fn_interview.php",
            dataType: 'json',
            type: 'POST',
            success: function ( json ) {
                
                $('#interview').html(json.data.rs_interview.label);
            }
        } );
    };
</script>