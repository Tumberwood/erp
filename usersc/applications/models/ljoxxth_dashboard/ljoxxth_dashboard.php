<?php
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../helpers/hakakses_s_fn.php" );
	
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
	
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];

		$qs_ljoxxth = $db
			->raw()
			->bind(':start_date', $start_date)
			->bind(':end_date', $end_date)
			->exec('
				SELECT	
					a.id as id,
					date_format(a.tanggal,"%d %b %Y") as tanggal,
					a.plat_no,
					c.nama AS grlxxmh_expedition_nama,
					b.nama AS lvtxxmh_nama,
					a.supir_nama,
					a.berat_muatan,
					date_format(ljoprtd_booking.tanggaljam_start,"%d %b %Y %H:%i:%s") AS waktu_booking,
					date_format(ljoprtd_arrival.tanggaljam_start,"%d %b %Y %H:%i:%s") AS waktu_arrival,
					date_format(ljoprtd_process.tanggaljam_start,"%d %b %Y %H:%i:%s") AS waktu_process_start,
					date_format(ljoprtd_process.tanggaljam_finish,"%d %b %Y %H:%i:%s") AS waktu_process_finish,
					date_format(ljoprtd_clearance.tanggaljam_start,"%d %b %Y %H:%i:%s") AS waktu_clearance,
					date_format(ljoprtd_done.tanggaljam_start,"%d %b %Y %H:%i:%s") AS waktu_done
				FROM ljoxxth a
				LEFT JOIN lvtxxmh b ON b.id = a.id_lvtxxmh
				LEFT JOIN grlxxmh c ON c.id = a.id_grlxxmh_expedition
				LEFT JOIN ljoprtd as ljoprtd_booking ON ljoprtd_booking.id_ljoxxth = a.id AND ljoprtd_booking.id_lprxxmh = 1
				LEFT JOIN ljoprtd as ljoprtd_arrival ON ljoprtd_arrival.id_ljoxxth = a.id AND ljoprtd_arrival.id_lprxxmh = 2
				LEFT JOIN ljoprtd as ljoprtd_process ON ljoprtd_process.id_ljoxxth = a.id AND ljoprtd_process.id_lprxxmh = 3
				LEFT JOIN ljoprtd as ljoprtd_clearance ON ljoprtd_clearance.id_ljoxxth = a.id AND ljoprtd_clearance.id_lprxxmh = 5
				LEFT JOIN ljoprtd as ljoprtd_done ON ljoprtd_done.id_ljoxxth = a.id AND ljoprtd_done.id_lprxxmh = 8
				WHERE 1
					AND tanggal BETWEEN :start_date AND :end_date
			');

		$rs_ljoxxth = $qs_ljoxxth->fetchAll();
		
		if (!empty($rs_ljoxxth)){
			echo json_encode( ['data' => $rs_ljoxxth]);
		}else{
			echo json_encode( [ "data" => [] ] );
		}

	// debugging hak akses
	$json['hakakses'] = $hakakses;

?>