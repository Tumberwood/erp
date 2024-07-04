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
		$id_iwhxxmh = $_POST['id_iwhxxmh'];

        /**
         * Warehouse Capacity
         * untuk menghitung kapasitas terpakai gudang, tidak termasuk overflow
         */
		$qs_wloxxmh = $db
            ->raw()
            ->bind(':transaction_state', 1)
            ->bind(':id_iwhxxmh', $id_iwhxxmh)
            ->bind(':id_wloctmh', 3)
            ->bind(':id_wloxxmh', 0)
            ->bind(':s_jumlah_terkecil', 0)
            ->bind(':end_date', $end_date)
            ->exec('SELECT 
                        iwhxxmh.nama as iwhxxmh_nama,
                        SUM(wloxxmh.kapasitas) AS s_kapasitas,
                        sq_iivxxrd.c_id_wloxxmh
                    FROM wloxxmh
                    LEFT JOIN iwhxxmh ON iwhxxmh.id = wloxxmh.id_iwhxxmh
                    LEFT JOIN (
                        SELECT
                            a.id_iwhxxmh as id_iwhxxmh,
                            COUNT(id_wloxxmh) AS c_id_wloxxmh
                        FROM
                        (
                            SELECT
                                iivxxrd.id_iwhxxmh AS id_iwhxxmh,
                                iivxxrd.id_wloxxmh AS id_wloxxmh, 
                                SUM(iivxxrd.jumlah_terkecil) AS s_jumlah_terkecil
                            FROM iivxxrd 
                            WHERE 1
                                AND iivxxrd.id_wloxxmh > :id_wloxxmh
                                AND iivxxrd.id_wloctmh = :id_wloctmh
                                AND iivxxrd.tanggal <= :end_date
                            GROUP BY 
                                iivxxrd.id_wloxxmh
                            HAVING s_jumlah_terkecil > :s_jumlah_terkecil
                        ) a
                        GROUP BY a.id_iwhxxmh
                    ) sq_iivxxrd ON sq_iivxxrd.id_iwhxxmh = iwhxxmh.id
                    WHERE 1
                        AND wloxxmh.id_iwhxxmh = :id_iwhxxmh
                        AND wloxxmh.transaction_state = :transaction_state
                        AND wloxxmh.id_wloctmh = :id_wloctmh
                    GROUP BY iwhxxmh.id');
        $rs_wloxxmh = $qs_wloxxmh->fetch();

		$data = array(
            "status_code" => 200,
            "rs_wloxxmh" => $rs_wloxxmh
        );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>