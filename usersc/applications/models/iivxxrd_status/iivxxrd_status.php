<?php
	/**
	 * 
	 */

	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );

	require '../../../../usersc/vendor/autoload.php';
	use Carbon\Carbon;
	
	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

		
	$end_date = new Carbon($_POST['end_date']);
	$id_wloctmh = $_POST['id_wloctmh'];
	$iimxxmh_status_fs = $_POST['iimxxmh_status_fs'];

	if ($id_wloctmh != "()") {
		$kondisi_wloctmh = 'AND id_wloctmh IN '.$id_wloctmh;
	} else {
		$kondisi_wloctmh = '';
	}
	
	$qs_iivxxrd = $db
		->raw()
		->bind(':end_date', $end_date->format('Y-m-d') )
		->bind(':iimxxmh_status_fs', $iimxxmh_status_fs)
		->exec('SELECT
					max(a.id) id_iivxxrd,
					a.id_wloctmh,
					a.iwhxxmh_kode,
					a.wloxxmh_nama,
					a.iimxxmh_kode,
					a.iimxxmh_nama,
					a.iumxxmh_default_kode,
					a.iumxxmh_terkecil_kode,
					SUM(jumlah_default * is_fisik) as jumlah_default,
					SUM(jumlah_terkecil * is_fisik) as jumlah_terkecil,
					ifnull(jumlah_default_booking,0) as jumlah_default_booking,
					ifnull(jumlah_terkecil_booking,0) as jumlah_terkecil_booking,
					(SUM(jumlah_default * is_fisik)) - ifnull(jumlah_default_booking,0) as jumlah_default_ava,
					(SUM(jumlah_terkecil * is_fisik)) - ifnull(jumlah_terkecil_booking,0) as jumlah_terkecil_ava,
					a.wlpxxmh_kode,
					max(batch_number) batch_number,
					max(date_format(expired_date,"%d %b %Y")) as expired_date,
					
					-- ambil iimxxmh_status dari id terakhir
					(
				        SELECT a_inner.iimxxmh_status
				        FROM iivxxrd a_inner
				        WHERE a_inner.id = MAX(a.id) -- Correlates with the outer query
				    ) AS iimxxmh_status
				FROM iivxxrd a
				LEFT JOIN (
					SELECT
						wloxxmh_nama,
						iimxxmh_kode,
						SUM(jumlah_default) * -1 as jumlah_default_booking,
						SUM(jumlah_terkecil) * -1 as jumlah_terkecil_booking,
						wlpxxmh_kode
					FROM iivxxrd
					WHERE tanggal <= :end_date AND is_fisik = 0
					GROUP BY 
						-- id_gbrxxmh, 
						id_iwhxxmh,
						id_iimxxmh,
						id_wloxxmh,
						wlpxxmh_kode
				) AS b ON b.wloxxmh_nama = a.wloxxmh_nama AND b.iimxxmh_kode = a.iimxxmh_kode AND b.wlpxxmh_kode = a.wlpxxmh_kode
				WHERE tanggal <= :end_date
				GROUP BY 
					-- id_gbrxxmh, 
					id_iwhxxmh,
					id_iimxxmh,
					id_wloxxmh,
					wlpxxmh_kode
				having jumlah_terkecil > 0 AND iimxxmh_status = :iimxxmh_status_fs
			' . $kondisi_wloctmh);
	$rs_iivxxrd = $qs_iivxxrd->fetchAll();
	if (!empty($rs_iivxxrd)) {
		echo json_encode( ['data' => $rs_iivxxrd]);
	}else{
		echo json_encode( [ "data" => [] ] );
	}
	
?>