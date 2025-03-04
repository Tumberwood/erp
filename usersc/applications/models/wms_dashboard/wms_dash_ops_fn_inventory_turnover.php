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
	
		$id_iwhxxmh = $_POST['id_iwhxxmh'];
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];

		$qs_stock_awal = $db
            ->raw()
            ->bind(':start_date', $start_date)
            ->bind(':id_iwhxxmh', $id_iwhxxmh)
            ->exec('WITH awal AS (	
                        SELECT
                            a.id_wloctmh,
                            a.id_iwhxxmh,
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
                        WHERE tanggal <= :start_date
                        GROUP BY 
                            -- id_gbrxxmh, 
                            id_iwhxxmh,
                            id_iimxxmh,
                            id_wloxxmh,
                            wlpxxmh_kode
                        having jumlah_terkecil > 0 AND id_iwhxxmh = :id_iwhxxmh
                    )
                    SELECT
                        IFNULL(SUM(awal.jumlah_terkecil),0) sum_jumlah_terkecil_awal
                    FROM awal
                ');
        $rs_stock_awal = $qs_stock_awal->fetch();

		$qs_stock_akhir = $db
            ->raw()
            ->bind(':end_date', $end_date)
            ->bind(':id_iwhxxmh', $id_iwhxxmh)
            ->exec('WITH akhir AS (	
                        SELECT
                            a.id_wloctmh,
                            a.id_iwhxxmh,
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
                        WHERE tanggal <= :end_date
                        GROUP BY 
                            -- id_gbrxxmh, 
                            id_iwhxxmh,
                            id_iimxxmh,
                            id_wloxxmh,
                            wlpxxmh_kode
                        having jumlah_terkecil > 0 AND id_iwhxxmh = :id_iwhxxmh
                    )
                    SELECT
                        IFNULL(SUM(akhir.jumlah_terkecil),0) sum_jumlah_terkecil_akhir
                    FROM akhir
                ');
        $rs_stock_akhir = $qs_stock_akhir->fetch();

        $stock_awal = $rs_stock_awal['sum_jumlah_terkecil_awal'];
        $stock_akhir = $rs_stock_akhir['sum_jumlah_terkecil_akhir'];
       
        $total_stock = $stock_awal + $stock_akhir;
        $average = $total_stock / 2;
        // $average = number_format($total_stock / 2, 2);

        $qs_dn = $db
            ->raw()
            ->bind(':start_date', $start_date)
            ->bind(':end_date', $end_date)
            // ->bind(':id_iwhxxmh', $id_iwhxxmh)
            ->exec('SELECT
                        ifnull(SUM(a.jumlah_terkecil),0) terkecil_dn
                    FROM wdnlptd a
                    LEFT JOIN wdnxxth b ON b.id = a.id_wdnxxth
                    WHERE b.tanggal BETWEEN :start_date AND :end_date
                    AND b.transaction_state = 1 
                    AND a.transaction_state <> -9
        ');
        
        $rs_dn = $qs_dn->fetch();
        $terkecil_dn = $rs_dn['terkecil_dn'];

        if ($terkecil_dn == 0) {
           $invetory_turnover = 0;
        } else {
            $invetory_turnover = number_format($terkecil_dn / $average, 2);
        }
        

		$data = array(
            "status_code" => 200,
            "invetory_turnover" => $invetory_turnover,
            "rs_stock_awal" => $rs_stock_awal,
            "rs_stock_akhir" => $rs_stock_akhir,
            "rs_dn" => $rs_dn,
        );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>