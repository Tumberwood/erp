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

		$qs_inbound = $db
            ->raw()
            ->bind(':end_date', $end_date)
            ->bind(':id_iwhxxmh', $id_iwhxxmh)
            ->exec('WITH iiv AS (
                        SELECT
                            a.id_wloctmh,
                            a.iwhxxmh_kode,
                            a.wloxxmh_nama,
                            a.iimxxmh_kode,
                            a.iimxxmh_nama,
                            a.iumxxmh_default_kode,
                            a.iumxxmh_terkecil_kode,
                            SUM(a.jumlah_default * is_fisik) as jumlah_default,
                            SUM(a.jumlah_terkecil * is_fisik) as jumlah_terkecil,
                            a.wlpxxmh_kode,
                            max(batch_number) batch_number,
                            max(date_format(expired_date,"%d %b %Y")) as expired_date
                        FROM iivxxrd a
                        WHERE tanggal <= :end_date
                        GROUP BY 
                            -- id_gbrxxmh, 
                            a.id_iwhxxmh,
                            a.id_iimxxmh,
                            a.id_wloxxmh,
                            a.wlpxxmh_kode
                        having jumlah_terkecil > 0 AND a.id_wloctmh = 1 AND a.id_iwhxxmh = :id_iwhxxmh
                    )
                    SELECT
                        COUNT(wlpxxmh_kode) c_inbound
                    FROM iiv
                ');
        $rs_inbound = $qs_inbound->fetch();

		$data = array(
            "status_code" => 200,
            "rs_inbound" => $rs_inbound
        );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>