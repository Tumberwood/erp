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
	
		// $id_iwhxxmh = $_POST['id_iwhxxmh'];
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];

		$qs_akumulasi = $db
            ->raw()
            ->bind(':start_date', $start_date)
            ->bind(':end_date', $end_date)
            ->exec('WITH cte AS (
                        SELECT 
                            c.kode,
                            c.nama,
                            IFNULL(SUM(a.jumlah_terkecil), 0) AS terkecil_dn
                        FROM wdnlptd a
                        LEFT JOIN wdnxxth b ON b.id = a.id_wdnxxth
                        LEFT JOIN iimxxmh c ON c.id = a.id_iimxxmh
                        WHERE b.tanggal BETWEEN :start_date AND :end_date
                        AND a.transaction_state <> -9
                        AND b.transaction_state = 1
                        GROUP BY a.id_iimxxmh, c.kode, c.nama
                    )
                    SELECT 
                        kode,
                        nama,
                        terkecil_dn,
                        SUM(terkecil_dn) OVER (ORDER BY terkecil_dn DESC ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW) AS jumlah_terkecil,
                        total_dn,
                        ROUND((SUM(terkecil_dn) OVER (ORDER BY terkecil_dn DESC ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW) / total_dn) * 100) kumulatif
                    FROM cte
                    LEFT JOIN (
                        SELECT 
                            IFNULL(SUM(a.jumlah_terkecil), 0) AS total_dn
                        FROM wdnlptd a
                        LEFT JOIN wdnxxth b ON b.id = a.id_wdnxxth
                        LEFT JOIN iimxxmh c ON c.id = a.id_iimxxmh
                        WHERE b.tanggal BETWEEN :start_date AND :end_date
                        AND a.transaction_state <> -9
                        AND b.transaction_state = 1
                    ) total ON total.total_dn > 0
                    ORDER BY terkecil_dn DESC;

                ');
        $rs_akumulasi = $qs_akumulasi->fetchAll();
        
        $categories = [];
        $data_delivery = [];
        $data_kumulatif = [];

        foreach ($rs_akumulasi as $row) {
            $categories[] = $row['nama'];
            $data_delivery[] = (float) $row['terkecil_dn'];
            $data_kumulatif[] = (float) $row['kumulatif'];
        }

		$data = array(
            "status_code" => 200,
            "categories" => $categories,
            "data_delivery" => $data_delivery,
            "data_kumulatif" => $data_kumulatif,
        );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>