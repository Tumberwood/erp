<?php

	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );

	require '../../../../usersc/vendor/autoload.php';
	use Carbon\Carbon;
	
	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

		$start_date		= $_POST['start_date'];
		$end_date		= $_POST['end_date'];

        $qs_prc = $db
            ->raw()
            ->bind(':start_date', $start_date)
            ->bind(':end_date', $end_date)
            ->exec('SELECT
                        COUNT(a.id) AS c_id_h,
                        (SELECT
                            COUNT(b.id) AS c_id_d
                        FROM prcittd_npo b
                        LEFT JOIN prcxxth_npo a ON a.id = b.id_prcxxth_npo
                        WHERE a.tanggal BETWEEN :start_date AND :end_date 
                        AND b.transaction_state = 1
                        ) AS c_id_d
                    FROM prcxxth_npo a
                    WHERE a.tanggal BETWEEN :start_date AND :end_date
                    '
                    );
        $rs_prc = $qs_prc->fetch();

        $qs_sdl = $db
            ->raw()
            ->bind(':start_date', $start_date)
            ->bind(':end_date', $end_date)
            ->exec('SELECT
                        COUNT(a.id) AS c_id_h,
                        (SELECT
                            COUNT(b.id) AS c_id_d
                        FROM sdlittd_nso b
                        LEFT JOIN sdlxxth_nso a ON a.id = b.id_sdlxxth_nso
                        WHERE a.tanggal BETWEEN :start_date AND :end_date 
                        AND b.transaction_state = 1
                        ) AS c_id_d
                    FROM sdlxxth_nso a
                    WHERE a.tanggal BETWEEN :start_date AND :end_date
                    '
                    );
        $rs_sdl = $qs_sdl->fetch();

        $qs_prc_item = $db
            ->raw()
            ->bind(':start_date', $start_date)
            ->bind(':end_date', $end_date)
            ->exec('SELECT
                        b.id,
                        c.kode iimxxmh_kode,
                        c.nama iimxxmh_nama,
                        d.kode iumxxmh_kode,
                        b.jumlah_unit
                    FROM prcittd_npo b
                    LEFT JOIN prcxxth_npo a ON a.id = b.id_prcxxth_npo
                    LEFT JOIN iimxxmh c ON c.id = b.id_iimxxmh
                    LEFT JOIN iumxxmh d ON d.id = b.id_iumxxmh_unit
                    WHERE a.tanggal BETWEEN :start_date AND :end_date 
                    AND b.transaction_state = 1
                    ORDER BY jumlah_unit DESC
                    LIMIT 10
                    '
                    );
        $rs_prc_item = $qs_prc_item->fetchAll();

        $qs_sdl_item = $db
            ->raw()
            ->bind(':start_date', $start_date)
            ->bind(':end_date', $end_date)
            ->exec('SELECT
                        b.id,
                        c.kode iimxxmh_kode,
                        c.nama iimxxmh_nama,
                        d.kode iumxxmh_kode,
                        b.jumlah_unit
                    FROM sdlittd_nso b
                    LEFT JOIN sdlxxth_nso a ON a.id = b.id_sdlxxth_nso
                    LEFT JOIN iimxxmh c ON c.id = b.id_iimxxmh
                    LEFT JOIN iumxxmh d ON d.id = b.id_iumxxmh_unit
                    WHERE a.tanggal BETWEEN :start_date AND :end_date 
                    AND b.transaction_state = 1
                    ORDER BY jumlah_unit DESC
                    LIMIT 10
                    '
                    );
        $rs_sdl_item = $qs_sdl_item->fetchAll();

        $qs_avg = $db
            ->raw()
            ->exec('SELECT
                        (SUM(CASE WHEN a.confirmed_at < DATE_ADD("'.$end_date.' 00:00:00", INTERVAL 1 DAY) THEN a.jumlah_terkecil ELSE 0 END) 
                        -
                        SUM(CASE WHEN a.confirmed_at < "'.$start_date.' 00:00:00" THEN a.jumlah_terkecil ELSE 0 END)) 
                        / 2 AS avg_jumlah
                    FROM iivxxrd_npo a;
                    '
                    );
        $rs_avg = $qs_avg->fetch();

        $results = array();
		$results['data'] = $rs_prc;
		$results['data1'] = $rs_sdl;
		$results['data2'] = $rs_prc_item;
		$results['data3'] = $rs_sdl_item;
		$results['data4'] = $rs_avg;
		
	echo json_encode($results);
?>