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

		$qs_man_hours = $db
            ->raw()
            ->bind(':start_date', $start_date)
            ->bind(':end_date', $end_date)
            ->exec('SELECT
                        a.username,
                        SUM(TIMESTAMPDIFF(SECOND, a.start_on, b.finish_on)) / 3600 AS s_durasi_jam
                    FROM activity_log_ml AS a
                    INNER JOIN activity_log_ml AS b ON a.id_transaksi = b.id_transaksi AND b.kode = "CONFIRM" AND b.nama = a.nama
                    WHERE 1 
                        AND a.kode = "CREATE"
                        AND a.nama IN ("wreittd", "wptittd", "wtrittd", "wpclptd", "iivxxrd_audit")
                        AND DATE(a.start_on) BETWEEN :start_date AND :end_date
                    GROUP BY a.username   
                ');
        $rs_man_hours = $qs_man_hours->fetchAll();

		$data = array(
            "status_code" => 200,
            "rs_man_hours" => $rs_man_hours
        );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>