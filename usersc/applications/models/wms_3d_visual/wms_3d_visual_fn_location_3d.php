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
		
        if (empty($_POST['id_iwhxxmh'])) {
            $id_iwhxxmh = 0;
        }else{
            $id_iwhxxmh = $_POST['id_iwhxxmh'];
        }

        // kapasitas gudang tanpa overflow
		$qs_wloxxmh = $db
            ->raw()
            ->bind(':end_date', $end_date)
            ->bind(':id_iwhxxmh', $id_iwhxxmh)
            ->exec('SELECT
                        a.id,
                        a.nama,
                        a.rack,
                        a.rack_name,
                        a.bay,
                        a.bay_name,
                        a.`level`,
                        a.level_name,
                        a.koord_x,
                        a.koord_y,
                        a.koord_z,
                        IF(IFNULL(jumlah_terkecil,0) > 0, IFNULL(occurance,0), 0) AS is_fill,
                        str
                    FROM wloxxmh a
                    LEFT JOIN (
                        SELECT
                            *
                        FROM (
                            SELECT
                                iivxxrd.id_wloxxmh AS id_wloxxmh,
                                COUNT(*) AS occurance,
                                GROUP_CONCAT(iivxxrd.kode , " - ", iivxxrd.wlpxxmh_kode , " (", iivxxrd.imtxxmh_movement_type ,")" SEPARATOR "\n") AS str
                            FROM iivxxrd
                            LEFT JOIN wloxxmh ON wloxxmh.id = iivxxrd.id_wloxxmh
                            WHERE 1
                                AND wloxxmh.transaction_state = 1
                                AND iivxxrd.is_fisik = 1
                                AND iivxxrd.id_iwhxxmh = :id_iwhxxmh
                                AND wloxxmh.id_wloctmh = 3
                                AND iivxxrd.tanggal <= :end_date
                            GROUP BY wloxxmh.id
                        ) inventory
                        GROUP BY id_wloxxmh
                    ) iv ON iv.id_wloxxmh = a.id

                    -- stok
                    LEFT JOIN (
                        SELECT
                        *
                        FROM (
                        SELECT
                                a.id_wloctmh,
                                a.id_wloxxmh,
                                a.iwhxxmh_kode,
                                a.wloxxmh_nama,
                                a.iimxxmh_kode,
                                a.iimxxmh_nama,
                                a.iumxxmh_default_kode,
                                a.iumxxmh_terkecil_kode,
                                SUM(jumlah_default * is_fisik) as jumlah_default,
                                SUM(jumlah_terkecil * is_fisik) as jumlah_terkecil,
                                a.wlpxxmh_kode,
                                max(batch_number) batch_number,
                                max(date_format(expired_date,"%d %b %Y")) as expired_date
                            FROM iivxxrd a
                            WHERE tanggal <= :end_date AND a.id_wloctmh = 3
                            GROUP BY 
                                -- id_gbrxxmh, 
                                id_iwhxxmh,
                                id_iimxxmh,
                                id_wloxxmh,
                                wlpxxmh_kode
                            having jumlah_terkecil > 0
                        ) inventory
                        GROUP BY id_wloxxmh
                    ) stok on stok.id_wloxxmh = a.id
                    WHERE a.id_wloctmh = 3 
                    AND a.transaction_state = 1 
                    AND a.id_iwhxxmh = :id_iwhxxmh
            ');
        $rs_wloxxmh = $qs_wloxxmh->fetchAll();

		$data = array(
            "status_code" => 200,
            "rs_wloxxmh" => $rs_wloxxmh,
        );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>