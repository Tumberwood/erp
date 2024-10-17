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
	
		//LINE 1
        $hasil_line1   = $_POST['hasil_line1'];
        $qs_line1 = $db
		->raw()
		->bind(':hasil_line1', $hasil_line1)
		->exec(' SELECT
					*
				FROM disc_m
				WHERE id = :hasil_line1
				'
				);
        
	    $rs_line1 = $qs_line1->fetch();
	
		//LINE 2
        $hasil_line2   = $_POST['hasil_line2'];
        $qs_line2 = $db
		->raw()
		->bind(':hasil_line2', $hasil_line2)
		->exec(' SELECT
					*
				FROM disc_m
				WHERE id = :hasil_line2
				'
				);
        
	    $rs_line2 = $qs_line2->fetch();
	
		//LINE 3
        $hasil_line3   = $_POST['hasil_line3'];
        $qs_line3 = $db
		->raw()
		->bind(':hasil_line3', $hasil_line3)
		->exec(' SELECT
					*
				FROM disc_m
				WHERE id = :hasil_line3
				'
				);
        
	    $rs_line3 = $qs_line3->fetch();

		$data = array(
			'rs_line1' => $rs_line1,
			'rs_line2' => $rs_line2,
			'rs_line3' => $rs_line3
		);
        echo json_encode($data);
?>