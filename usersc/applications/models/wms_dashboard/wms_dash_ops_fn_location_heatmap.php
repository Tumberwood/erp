<?php
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
    require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	
	use
		DataTables\Editor,
		DataTables\Editor\Field,
		DataTables\Editor\Format,
		DataTables\Editor\Mjoin,
		DataTables\Editor\Options,
		DataTables\Editor\Upload,
		DataTables\Editor\Validate,
		DataTables\Editor\ValidateOptions,
		DataTables\Editor\SearchPaneOptions,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

	use 
		Carbon\Carbon;

        // BEGIN definisi variable untuk fn_ajax_results.php
        $data      = array();
        $rs_opt    = array();
        // END definisi variable untuk fn_ajax_results.php
	
		$end_date = $_POST['end_date'];
		// $id_iwmxxmh = $_POST['id_iwmxxmh'];
		
        $id_iwhxxmh = 1;

        // kapasitas gudang tanpa overflow
		$qs_wloxxmh_rack_name = $db
            ->raw()
            ->bind(':transaction_state', 1)
            ->bind(':id_iwhxxmh', $id_iwhxxmh)
            ->bind(':id_wloctmh', 3)
            ->exec('SELECT
                        distinct rack_name
                    FROM wloxxmh a
                    WHERE 1
                        AND a.transaction_state = :transaction_state
                        AND a.id_iwhxxmh = :id_iwhxxmh
                        AND a.id_wloctmh = :id_wloctmh
                    ORDER BY a.rack, a.bay');
        $rs_wloxxmh_rack_name = $qs_wloxxmh_rack_name->fetchAll();

        $qs_wloxxmh_bay_name = $db
            ->raw()
            ->bind(':transaction_state', 1)
            ->bind(':id_iwhxxmh', $id_iwhxxmh)
            ->bind(':id_wloctmh', 3)
            ->exec('SELECT
                        distinct bay_name
                    FROM wloxxmh a
                    WHERE 1
                        AND a.transaction_state = :transaction_state
                        AND a.id_iwhxxmh = :id_iwhxxmh
                        AND a.id_wloctmh = :id_wloctmh
                    ORDER BY a.rack, a.bay');
        $rs_wloxxmh_bay_name = $qs_wloxxmh_bay_name->fetchAll();

        $qs_wloxxmh_occurance = $db
            ->raw()
            ->bind(':transaction_state', 1)
            ->bind(':id_iwhxxmh', $id_iwhxxmh) 
            ->bind(':id_wloctmh', 3)
            ->bind(':end_date', $end_date)
            ->exec('SELECT
                        a.id,
                        ifnull(a.rack,0) as rack,
                        ifnull(a.bay,0) as bay,
                        SUM(ifnull(b.occurance,0)) AS occurance
                    FROM wloxxmh a
                    LEFT JOIN
                    (
                        SELECT
                            iivxxrd.id_wloxxmh AS id_wloxxmh,
                            COUNT(*) AS occurance
                        FROM iivxxrd
                        LEFT JOIN wloxxmh ON wloxxmh.id = iivxxrd.id_wloxxmh
                        WHERE 1
                            AND wloxxmh.transaction_state = :transaction_state
                            AND iivxxrd.id_iwhxxmh = :id_iwhxxmh
                            AND wloxxmh.id_wloctmh = :id_wloctmh
                            AND iivxxrd.tanggal <= :end_date
                        GROUP BY wloxxmh.id
                        ) b ON b.id_wloxxmh  = a.id
                    
                    GROUP BY a.rack, a.bay
                    ORDER BY a.rack, a.bay');
        $rs_wloxxmh_occurance = $qs_wloxxmh_occurance->fetchAll();

		$data = array(
            "status_code" => 200,
            "rs_wloxxmh_rack_name" => $rs_wloxxmh_rack_name,
            "rs_wloxxmh_bay_name" => $rs_wloxxmh_bay_name,
            "rs_wloxxmh_occurance" => $rs_wloxxmh_occurance
        );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>