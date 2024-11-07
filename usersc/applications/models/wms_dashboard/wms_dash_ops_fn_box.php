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

        if (empty($_POST['id_iwhxxmh'])) {
            $id_iwhxxmh = 0;
        }else{
            $id_iwhxxmh = $_POST['id_iwhxxmh'];
        }

        // LPN Received
        $qs_lpn_received = $db
            ->raw()
            ->bind(':start_date', $start_date)
            ->bind(':end_date', $end_date)
            ->bind(':id_iwhxxmh', $id_iwhxxmh)
            ->exec('SELECT
                        COUNT(*) AS c_lpn_received
                    FROM activity_log_ml
                    LEFT JOIN wreittd ON wreittd.id = activity_log_ml.id_transaksi
                    WHERE 1
                        AND wreittd.id_iwhxxmh = :id_iwhxxmh
                        AND activity_log_ml.kode = "confirm"
                        AND activity_log_ml.nama = "wreittd"
                        AND DATE(activity_log_ml.finish_on) BETWEEN :start_date AND :end_date
                ');
        $rs_lpn_received = $qs_lpn_received->fetch();

        
        /**
         * LPN to putaway
         * untuk menghitung berapa banyak LPN yang harus di putaway
         */
        $qs_lpn_to_putaway = $db
            ->raw()
            ->bind(':id_iwhxxmh', $id_iwhxxmh)
            ->exec('SELECT
                        COUNT(*) AS c_lpn_to_putaway
                    FROM
                        (
                            SELECT
                                SUM(iivxxrd.jumlah_terkecil) AS s_jumlah_terkecil_onhand
                            FROM iivxxrd
                            WHERE 1
                                AND iivxxrd.id_iwhxxmh = :id_iwhxxmh
                                AND iivxxrd.id_wloctmh = 1
                            GROUP BY 
                                iivxxrd.id_iimxxmh,
                                iivxxrd.wlpxxmh_kode
                            HAVING 
                                s_jumlah_terkecil_onhand > 0
                        ) a
                    ');
		$rs_lpn_to_putaway = $qs_lpn_to_putaway->fetch();

        $qs_lpn_putaway = $db
            ->raw()
            ->bind(':start_date', $start_date)
            ->bind(':end_date', $end_date)
            ->bind(':id_iwhxxmh', $id_iwhxxmh)
            ->exec('SELECT
                        COUNT(*) AS c_lpn_putaway
                    FROM activity_log_ml
                    LEFT JOIN wptittd ON wptittd.id = activity_log_ml.id_transaksi
                    WHERE 1
                        AND wptittd.id_iwhxxmh = :id_iwhxxmh
                        AND activity_log_ml.kode = "confirm"
                        AND activity_log_ml.nama = "wptittd"
                        AND DATE(activity_log_ml.finish_on) BETWEEN :start_date AND :end_date
                ');
        $rs_lpn_putaway = $qs_lpn_putaway->fetch();

        $qs_lpn_to_pick = $db
            ->raw()
            ->bind(':transaction_state', 1)
            ->exec('SELECT
                        COUNT(*) AS c_lpn_to_pick
                    FROM wpllptd
                    LEFT JOIN wplxxth ON wplxxth.id = wpllptd.id_wplxxth
                    WHERE 1
                        AND wplxxth.transaction_state = :transaction_state
                        AND wpllptd.jumlah_terkecil_os > 0
            ');
        $rs_lpn_to_pick = $qs_lpn_to_pick->fetch();

        $qs_lpn_picked = $db
            ->raw()
            ->bind(':start_date', $start_date)
            ->bind(':end_date', $end_date)
            ->exec('SELECT
                        COUNT(*) AS c_lpn_picked
                    FROM wpclptd
                    LEFT JOIN activity_log_ml as activity_log_ml_c ON 
                        activity_log_ml_c.id_transaksi = wpclptd.id 
                        AND activity_log_ml_c.kode = "CREATE" AND activity_log_ml_c.nama = "wpclptd"
                    WHERE 1
                        AND  DATE(activity_log_ml_c.start_on) BETWEEN :start_date AND :end_date
            ');
        $rs_lpn_picked = $qs_lpn_picked->fetch();

        $qs_item_to_dispatch = $db
            ->raw()
            ->bind(':transaction_state', 1)
            ->bind(':status_dispatch', 1)
            ->exec('SELECT
                        COUNT(*) AS c_item_to_dispatch
                    FROM wpclptd
                    LEFT JOIN wpcxxth ON wpcxxth.id = wpclptd.id_wpcxxth
                    WHERE 1
                        AND wpcxxth.transaction_state = :transaction_state
                        AND wpclptd.status_dispatch = :status_dispatch
            ');
        $rs_item_to_dispatch = $qs_item_to_dispatch->fetch();

        $qs_item_dispatched = $db
            ->raw()
            ->bind(':start_date', $start_date)
            ->bind(':end_date', $end_date)
            ->exec('SELECT
                        COUNT(*) AS c_item_dispatched
                    FROM wdplptd
                    LEFT JOIN activity_log_ml as activity_log_ml_c ON 
                        activity_log_ml_c.id_transaksi = wdplptd.id 
                        AND activity_log_ml_c.kode = "CREATE" AND activity_log_ml_c.nama = "wdplptd"
                    WHERE 1
                        AND  DATE(activity_log_ml_c.start_on) BETWEEN :start_date AND :end_date
            ');
        $rs_item_dispatched = $qs_item_dispatched->fetch();
            
        /**
         * average time
         * untuk menghitung rata-rata waktu proses per aktivitas
         */
        $qs_avg_activity = $db
            ->raw()
            ->bind(':start_date', $start_date)
            ->bind(':end_date', $end_date)
            ->bind(':id_iwhxxmh', $id_iwhxxmh)
            ->exec('WITH log AS (
                        SELECT
                            a.id AS id,
                            a.id_transaksi,
                            a.nama nama_table,
                            CASE 
                                WHEN a.nama = "wreittd" then (
                                    select
                                        kode
                                    from wreittd
                                    where id = a.id_transaksi
                                )
                                WHEN a.nama = "wptittd" then (
                                    select
                                        kode
                                    from wptittd
                                    where id = a.id_transaksi
                                )
                                WHEN a.nama = "wtrittd" then (
                                    select
                                        kode
                                    from wtrittd
                                    where id = a.id_transaksi
                                )
                                WHEN a.nama = "wtrittd" then (
                                    select
                                        kode
                                    from wtrittd
                                    where id = a.id_transaksi
                                )
                                WHEN a.nama = "iivxxrd_audit" then (
                                    select
                                        kode
                                    from iivxxrd_audit
                                    where id = a.id_transaksi
                                )
                                WHEN a.nama = "wpclptd" then (
                                    select
                                        kode
                                    from wpclptd
                                    where id = a.id_transaksi
                                )
                                WHEN a.nama = "wdplptd" then (
                                    select
                                        kode
                                    from wdplptd
                                    where id = a.id_transaksi
                                )
                                ELSE ""
                            END
                            kode_transaksi,
                            a.username,
                            DATE_FORMAT(a.start_on, "%d %b %Y %H:%i:%s") AS start_on,
                            DATE_FORMAT(b.finish_on, "%d %b %Y %H:%i:%s") AS finish_on,
                            TIMESTAMPDIFF(SECOND, a.start_on, b.finish_on) AS durasi
                        FROM activity_log_ml AS a
                        LEFT JOIN activity_log_ml AS b ON a.id_transaksi = b.id_transaksi AND b.kode = "CONFIRM" AND b.nama = a.nama
                        WHERE a.kode = "CREATE"
                            AND a.nama IN ("wreittd", "wptittd", "wtrittd", "iivxxrd_audit", "wpclptd", "wdplptd")
                            AND DATE(a.start_on) BETWEEN :start_date AND :end_date
                        GROUP BY a.id_transaksi, a.nama
                        ORDER BY a.start_on DESC
                    ),
                    wms_log AS (
                        select
                            z.*,
                            ifnull(iv.wloxxmh_nama, "") wloxxmh_nama,
                            ifnull(iv.iwhxxmh_kode, "") iwhxxmh_kode,
                            ifnull(iv.id_iwhxxmh, 0 ) id_iwhxxmh
                        from log z
                        LEFT JOIN (
                            SELECT
                                kode,
                                wloxxmh_nama,
                                iwhxxmh_kode,
                                id_iwhxxmh,
                                id_wloxxmh
                            FROM iivxxrd
                            WHERE jumlah_terkecil > 0
                            ORDER BY id desc
                        ) iv on iv.kode = z.kode_transaksi
                        WHERE iv.id_iwhxxmh = :id_iwhxxmh
                        GROUP BY z.id
                    )
                    SELECT
                            IFNULL(AVG(CASE WHEN nama_table = "wpclptd" THEN durasi END),0) AS avg_wpclptd,
                            IFNULL(AVG(CASE WHEN nama_table = "wreittd" THEN durasi END),0) AS avg_wreittd,
                            IFNULL(AVG(CASE WHEN nama_table = "wptittd" THEN durasi END),0) AS avg_wptittd,
                            IFNULL(AVG(CASE WHEN nama_table = "wtrittd" THEN durasi END),0) AS avg_wtrittd,
                            IFNULL(AVG(CASE WHEN nama_table = "wdplptd" THEN durasi END),0) AS avg_wdplptd,
                            IFNULL(AVG(CASE WHEN nama_table = "iivxxrd_audit" THEN durasi END),0) AS avg_iivxxrd_audit
                    FROM wms_log
            ');
        $rs_avg_activity = $qs_avg_activity->fetch();

		$data = array(
            "status_code" => 200,
            "rs_lpn_received" => $rs_lpn_received,
            "rs_lpn_to_putaway" => $rs_lpn_to_putaway,
            "rs_lpn_putaway" => $rs_lpn_putaway,
            "rs_lpn_to_pick" => $rs_lpn_to_pick,
            "rs_lpn_picked" => $rs_lpn_picked,
            "rs_item_to_dispatch" => $rs_item_to_dispatch,
            "rs_item_dispatched" => $rs_item_dispatched,
            "rs_avg_activity" => $rs_avg_activity
        );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>