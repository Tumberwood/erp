<?php
	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );
	
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
	
        $sql_select = $db
        ->raw()
        ->bind(':id_pmi_cylinder_problem_t', $_POST['id_pmi_cylinder_problem_t'])
		->exec('SELECT
					b.id,
					DATE_FORMAT(b.finish_at, "%d %b %Y") tanggal,
					b.verifikasi_by,
					b.action
				FROM pmi_cylinder_problem_t_action b
				WHERE b.id_pmi_cylinder_problem_t = :id_pmi_cylinder_problem_t
				'
			);
	    $results_select = $sql_select->fetchAll();
        echo json_encode($results_select);
?>