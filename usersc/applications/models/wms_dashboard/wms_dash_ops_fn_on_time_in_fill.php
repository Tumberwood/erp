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

		$qs_otif = $db
            ->raw()
            ->bind(':start_date', $start_date)
            ->bind(':end_date', $end_date)
            ->exec('WITH sel AS (
                        SELECT DISTINCT
                            a.id_wplittd,
                            plt.jumlah_unit jumlah_unit_pltd,
                            b.kode iimxxmh_kode,
                            b.nama iimxxmh_nama,
                            a.wlpxxmh_kode,
                            CONCAT(plth.kode, " - ", a.kode) kode_pl,	
                            a.jumlah_unit jumlah_pl,
                            if(a.jumlah_terkecil_os = 0 OR g.transaction_state = 1, "Lunas", CONCAT("sisa = ", ROUND(a.jumlah_terkecil_os / a.jumlah_konversi))) ket_pl,
                            CONCAT(d.kode) kode_pc,
                            d.jumlah_unit jumlah_pc,
                            if(d.jumlah_terkecil_os = 0 OR g.transaction_state = 1, "Lunas", CONCAT("sisa = ",ROUND(d.jumlah_terkecil_os / d.jumlah_konversi))) ket_pc,
                            e.kode kode_dp,
                            e.jumlah_unit jumlah_dp,
                            if(e.jumlah_terkecil_os = 0 OR g.transaction_state = 1, "Lunas", CONCAT("sisa = ",ROUND(e.jumlah_terkecil_os / e.jumlah_konversi))) ket_dp,
                            IFNULL(g.kode, "Draft DN") kode_dn,
                            f.jumlah_unit jumlah_dn
                        FROM wpllptd a
                        LEFT JOIN wplxxth plth ON plth.id = a.id_wplxxth
                        LEFT JOIN iimxxmh b ON b.id = a.id_iimxxmh
                        LEFT JOIN iumxxmh c ON c.id =  a.id_iumxxmh_unit
                        LEFT JOIN wpclptd d ON d.id_wpllptd = a.id
                        LEFT JOIN wdplptd e ON e.id_wpclptd = d.id
                        LEFT JOIN wdnlptd f ON f.id_wdplptd = e.id
                        LEFT JOIN wdnxxth g ON g.id = f.id_wdnxxth
                        LEFT JOIN wplittd plt ON plt.id = a.id_wplittd
                        WHERE plth.tanggal BETWEEN :start_date AND :end_date
                        ORDER BY a.wlpxxmh_kode
                    ),
                    hasil AS (
                        SELECT
                            id_wplittd,
                            kode_pl,
                            iimxxmh_kode,
                            iimxxmh_nama,
                            wlpxxmh_kode,
                            jumlah_unit_pltd,
                            SUM(ifnull(jumlah_dn,0)) s_dn,
                            if(SUM(ifnull(jumlah_dn,0)) = jumlah_unit_pltd, 1, 0) c_lunas
                        FROM sel
                        GROUP BY id_wplittd
                    )
                    SELECT
                        COUNT(id_wplittd) c_id_wplittd,
                        SUM(c_lunas) lunas,
                        ifnull((SUM(c_lunas) / COUNT(id_wplittd)) * 100,0) persen
                    FROM hasil 
                ');
        $rs_otif = $qs_otif->fetch();

		$data = array(
            "status_code" => 200,
            "rs_otif" => $rs_otif
        );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>