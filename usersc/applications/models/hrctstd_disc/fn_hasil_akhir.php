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

		//LINE Graph
        $id_hrctstd_disc   = $_POST['id_hrctstd_disc'];
        $qs_graph = $db
		->raw()
		->bind(':id_hrctstd_disc', $id_hrctstd_disc)
		->exec(' SELECT
					d_line1,
					d_line2,
					d_line3,
					i_line1,
					i_line2,
					i_line3,
					s_line1,
					s_line2,
					s_line3,
					c_line1,
					c_line2,
					c_line3
				FROM hrctstd_disc
				WHERE id = :id_hrctstd_disc
				'
				);
        
	    $rs_graph = $qs_graph->fetch();

		//table hasil
        $qs_table_hasil = $db
		->raw()
		->bind(':id_hrctstd_disc', $id_hrctstd_disc)
		->exec('SELECT tbl_d1 AS d, tbl_i1 AS i, tbl_s1 AS s, tbl_c1 AS c, tbl_star_1 AS star, tbl_total_1 AS total FROM hrctstd_disc
				WHERE id = :id_hrctstd_disc
				UNION ALL
				SELECT tbl_d2, tbl_i2, tbl_s2, tbl_c2, tbl_star_2, tbl_total_2 FROM hrctstd_disc
				WHERE id = :id_hrctstd_disc
				UNION ALL
				SELECT tbl_d3, tbl_i3, tbl_s3, tbl_c3, NULL, NULL FROM hrctstd_disc
				WHERE id = :id_hrctstd_disc
				'
				);
        
	    $rs_table_hasil = $qs_table_hasil->fetchAll();

		// Jadikan seperti ini tampilannya di js datatables
		// Line	D	I	S	C	*	tot
		// 1		3	2	7	3	9	24
		// 2		5	9	3	2	5	24
		// 3		-2	-7	4	1		


		$data = array(
			'rs_table_hasil' => $rs_table_hasil,
			'rs_graph' => $rs_graph,
			'rs_line1' => $rs_line1,
			'rs_line2' => $rs_line2,
			'rs_line3' => $rs_line3
		);
        echo json_encode($data);
?>