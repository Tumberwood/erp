<script>
    function getSelectedRowIds() {
        start_at = moment().format('YYYY-MM-DD HH:mm:ss');
        // console.log(start_at);
        var selectedData = tblwpcxxth.rows({ selected: true }).data();
        var ids = [];

        for (var i = 0; i < selectedData.length; i++) {
            ids.push(selectedData[i].wpclptd.id);
        }

        return ids;
    }
    
    function createPacking(selectedIds,start_at,finish_at) {
        // console.log(start_at);
        // console.log(finish_at);
        $.ajax( {
            url: "../../models/wpkxxth/create_wpkxxth.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                selectedIds: selectedIds,
                start_at: start_at,
                finish_at: finish_at,
            },
            success: function ( json ) {
                tblwpcxxth.ajax.reload(null, false);
            }
        } );
    }
</script>