<?php
	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );
	include( "../../../../usersc/helpers/datatables_fn_debug.php" );

	
	use
		DataTables\Editor,
		DataTables\Editor\Field,
		DataTables\Editor\Format,
		DataTables\Editor\Mjoin,
		DataTables\Editor\Options,
		DataTables\Editor\Upload,
		DataTables\Editor\Validate,
		DataTables\Editor\ValidateOptions,
		DataTables\Editor\Query,
		DataTables\Editor\Result;
	
		// echo $_POST['tanggal'];
        $sql_select = $db
		->raw()
		->bind(':id_hcd', $_POST['id_hcd'])
		->bind(':tanggal', $_POST['tanggal'])
		->exec(' SELECT
    				CASE WHEN a.status = 0 THEN 0 ELSE a.status END AS status_disc
				FROM hrctstd_disc AS a
				WHERE a.id_hcdxxmh = :id_hcd AND a.tanggal = :tanggal
				'
				);
        
	    $results_select = $sql_select->fetch();
        echo json_encode($results_select);
?>