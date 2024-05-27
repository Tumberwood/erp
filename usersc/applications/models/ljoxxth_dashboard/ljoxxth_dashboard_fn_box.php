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
	
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];

		$qs_ljoxxth = $db
			->raw()
			->bind(':start_date', $start_date)
			->bind(':end_date', $end_date)
			->exec('
                SELECT
                    ifnull(SUM(if(a.id_lacxxmh = 1,1,0)),0) AS c_unloading,
                    ifnull(SUM(if(
                        a.id_lacxxmh = 1 AND a.id_lprxxmh_last = 8,
                        1,0
                    )),0) AS c_unloading_done,
                    ifnull(SUM(if(a.id_lacxxmh = 2,1,0)),0) AS c_loading,
                    ifnull(SUM(if(
                        a.id_lacxxmh = 2 AND a.id_lprxxmh_last = 8,
                        1,0
                    )),0) AS c_loading_done
                FROM ljoxxth a
				WHERE 1
					AND a.tanggal BETWEEN :start_date AND :end_date
			');

		$rs_ljoxxth = $qs_ljoxxth->fetchAll();

		$qs_ljoxxth_lprxxmh = $db
			->raw()
			->bind(':start_date', $start_date)
			->bind(':end_date', $end_date)
			->exec('
				SELECT
					ifnull(SUM(if(ljoxxth.id_lprxxmh_last = 1,1,0)),0) AS c_booking,
					ifnull(SUM(if(ljoxxth.id_lprxxmh_last = 2,1,0)),0) AS c_arrival,
					ifnull(SUM(if(ljoxxth.id_lprxxmh_last = 3,1,0)),0) AS c_process,
					ifnull(SUM(if(ljoxxth.id_lprxxmh_last = 4,1,0)),0) AS c_document,
					ifnull(SUM(if(ljoxxth.id_lprxxmh_last = 5,1,0)),0) AS c_clearance,
					ifnull(SUM(if(ljoxxth.id_lprxxmh_last = 8,1,0)),0) AS c_done
				FROM ljoxxth
				WHERE 1
					AND ljoxxth.tanggal BETWEEN :start_date AND :end_date
			');
		$rs_ljoxxth_lprxxmh = $qs_ljoxxth_lprxxmh->fetchAll();
		
		$data = array(
            "status_code" => 200,
            "rs_ljoxxth" => $rs_ljoxxth,
            "rs_ljoxxth_lprxxmh" => $rs_ljoxxth_lprxxmh,
        );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>