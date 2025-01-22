<script>
    
    function tableHistory(id_pmi_cylinder_problem_t) {
        // Destroy the existing DataTable instance if it exists
        if ($.fn.DataTable.isDataTable('#tableHistory')) {
            $('#tableHistory').DataTable().destroy();
        }

        // Initialize DataTable
        $('#tableHistory').DataTable({
            ajax: {
                url: "../../models/pmi_cylinder_problem_t/fn_table_history.php",
                type: 'POST',
                data: function (d) {
                    d.id_pmi_cylinder_problem_t = id_pmi_cylinder_problem_t; // Send additional parameter
                },
                dataSrc: "" // Use empty string since data is returned as an array
            },
            columns: [
                { data: 'id', visible: false },
                { data: 'tanggal' },
                { data: 'action' },
                { data: 'verifikasi_by' },
            ],
            destroy: true, // Reinitialize allowed
            responsive: true, // Enable responsive layout
            autoWidth: false, // Disable automatic column width adjustment
            lengthChange: true, // Allow users to select number of rows
        });
    }
</script>