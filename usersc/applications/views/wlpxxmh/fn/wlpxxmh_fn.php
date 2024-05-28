<script>
    function getSelectedRowIds() {
        var selectedData = tblwlpxxmh.rows({ selected: true }).data();
        var ids = [];

        for (var i = 0; i < selectedData.length; i++) {
            ids.push(selectedData[i].wlpxxmh.id);
        }

        return ids;
    }
</script>