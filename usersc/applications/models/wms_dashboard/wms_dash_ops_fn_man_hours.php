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
		$id_iwhxxmh = $_POST['id_iwhxxmh'];

		$qs_man_hours = $db
            ->raw()
            ->bind(':start_date', $start_date)
            ->bind(':end_date', $end_date)
            ->bind(':id_iwhxxmh', $id_iwhxxmh)
            ->exec('WITH log AS (
                        SELECT
                            a.id AS id,
                            a.id_transaksi,
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
                        username,
                        SUM(durasi) / 3600 s_durasi_jam
                    FROM wms_log
                    GROUP BY username
                ');
        $rs_man_hours = $qs_man_hours->fetchAll();

		$data = array(
            "status_code" => 200,
            "rs_man_hours" => $rs_man_hours
        );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>