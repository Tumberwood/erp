<?php
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../helpers/hakakses_s_fn.php" );
	include_once( "../../../helpers/SolusiIndonesiaUtilities.php" );
	
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
		DataTables\Editor\Result,
		Carbon\Carbon,
		SolusiIndonesia\Utilities\General;
	
	$editor = Editor::inst( $db, 'qwhxxth' )
		->debug(true)
		->fields(
			Field::inst( 'qwhxxth.id' ),
			Field::inst( 'qwhxxth.transaction_state' ),
			Field::inst( 'qwhxxth.keterangan' ),
			Field::inst( 'qwhxxth.tanggal' )
				->getFormatter( function ( $val, $data, $opts ) {
					if ($val === '0000-00-00' || $val === null){
						echo '';
					}else{
						return date( 'd M Y', strtotime( $val ) );
					}
				} )
				->setFormatter( 'Format::datetime', array(
					'from' => 'd M Y',
					'to' =>   'Y-m-d'
				) ),
		)
		;
	
	$editor
		->on('postCreate',function( $editor, $id, $values ) use ( $s_id_users, $s_username) {
			$start_at           = $values['start_at'];
			$finish_at          = $values['finish_at'];
			$iimxxmh_status = $values['iimxxmh_status'];
			$alasan_perubahan_status = $values['alasan_perubahan_status'];
			$id_iivxxrd = $values['id_iivxxrd'];
			$end_date = $values['end_date'];
			// echo $iimxxmh_status;
			// echo $id_iivxxrd;
			// echo $end_date;
			// echo $id;

			//Minus di Status Lama
			$qs_iivxxrd = $editor->db()
				->raw()
				->bind(':id_iivxxrd', $id_iivxxrd)
				->bind(':end_date', $end_date)
				->exec('SELECT
							a.*,
							curdate() tanggal_insert,
							SUM(jumlah_default * is_fisik) as jumlah_default_hitung,
							SUM(jumlah_terkecil * is_fisik) as jumlah_terkecil_hitung,
							ifnull(jumlah_default_booking,0) as jumlah_default_booking,
							ifnull(jumlah_terkecil_booking,0) as jumlah_terkecil_booking,
							(SUM(jumlah_default * is_fisik)) - ifnull(jumlah_default_booking,0) as jumlah_default_ava,
							(SUM(jumlah_terkecil * is_fisik)) - ifnull(jumlah_terkecil_booking,0) as jumlah_terkecil_ava,
							max(batch_number) batch_number_final,
							max(expired_date) as expired_date_final,
							
							-- ambil iimxxmh_status dari id terakhir
							(
								SELECT a_inner.iimxxmh_status
								FROM iivxxrd a_inner
								WHERE a_inner.id = MAX(a.id) -- Correlates with the outer query
							) AS iimxxmh_status_last
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
						having jumlah_terkecil > 0 AND max(a.id) = :id_iivxxrd
					'
				);
				$iiv = $qs_iivxxrd->fetch();

				//insert Minus
				$qi_minus_iiv = $editor->db()
					->query('insert', 'iivxxrd')
					->set('id_transaksi_h',$id)
					->set('id_wloctmh',$iiv['id_wloctmh'])
					->set('wlpxxmh_kode',$iiv['wlpxxmh_kode'])
					->set('id_iwhxxmh',$iiv['id_iwhxxmh'])
					->set('id_wloxxmh',$iiv['id_wloxxmh'])
					->set('id_relasi_m',$iiv['id_relasi_m'])
					->set('id_iimxxmh',$iiv['id_iimxxmh'])
					->set('id_iumxxmh_unit',$iiv['id_iumxxmh_unit'])
					->set('id_iumxxmh_terkecil',$iiv['id_iumxxmh_terkecil'])
					->set('id_iumxxmh_default',$iiv['id_iumxxmh_default'])
					->set('keterangan','Item Status')
					->set('iwhxxmh_kode',$iiv['iwhxxmh_kode'])
					->set('iwhxxmh_nama',$iiv['iwhxxmh_nama'])
					->set('wloxxmh_kode',$iiv['wloxxmh_kode'])
					->set('wloxxmh_nama',$iiv['wloxxmh_nama'])
					->set('relasi_m_kode',$iiv['relasi_m_kode'])
					->set('relasi_m_nama',$iiv['relasi_m_nama'])
					->set('iimxxmh_kode',$iiv['iimxxmh_kode'])
					->set('iimxxmh_nama',$iiv['iimxxmh_nama'])
					->set('iumxxmh_unit_kode',$iiv['iumxxmh_unit_kode'])
					->set('iumxxmh_unit_nama',$iiv['iumxxmh_unit_nama'])
					->set('tanggal',$iiv['tanggal_insert'])
					->set('is_fisik',1)
					->set('iumxxmh_terkecil_kode',$iiv['iumxxmh_terkecil_kode'])
					->set('iumxxmh_terkecil_nama',$iiv['iumxxmh_terkecil_nama'])
					->set('iumxxmh_default_kode',$iiv['iumxxmh_default_kode'])
					->set('iumxxmh_default_nama',$iiv['iumxxmh_default_nama'])
					->set('jumlah_unit',-$iiv['jumlah_default_hitung'])
					->set('jumlah_terkecil',-$iiv['jumlah_terkecil_hitung'])
					->set('jumlah_default',-$iiv['jumlah_default_hitung'])
					->set('jumlah_konversi',$iiv['jumlah_konversi'])
					->set('batch_number',$iiv['batch_number_final'])
					->set('expired_date',$iiv['expired_date_final'])
					->set('iimxxmh_status',$iiv['iimxxmh_status_last'])
				->exec();

				//insert plus
				$qi_plus_iiv = $editor->db()
					->query('insert', 'iivxxrd')
					->set('id_transaksi_h',$id)
					->set('id_wloctmh',$iiv['id_wloctmh'])
					->set('wlpxxmh_kode',$iiv['wlpxxmh_kode'])
					->set('id_iwhxxmh',$iiv['id_iwhxxmh'])
					->set('id_wloxxmh',$iiv['id_wloxxmh'])
					->set('id_relasi_m',$iiv['id_relasi_m'])
					->set('id_iimxxmh',$iiv['id_iimxxmh'])
					->set('id_iumxxmh_unit',$iiv['id_iumxxmh_unit'])
					->set('id_iumxxmh_terkecil',$iiv['id_iumxxmh_terkecil'])
					->set('id_iumxxmh_default',$iiv['id_iumxxmh_default'])
					->set('keterangan','Item Status')
					->set('iwhxxmh_kode',$iiv['iwhxxmh_kode'])
					->set('iwhxxmh_nama',$iiv['iwhxxmh_nama'])
					->set('wloxxmh_kode',$iiv['wloxxmh_kode'])
					->set('wloxxmh_nama',$iiv['wloxxmh_nama'])
					->set('relasi_m_kode',$iiv['relasi_m_kode'])
					->set('relasi_m_nama',$iiv['relasi_m_nama'])
					->set('iimxxmh_kode',$iiv['iimxxmh_kode'])
					->set('iimxxmh_nama',$iiv['iimxxmh_nama'])
					->set('iumxxmh_unit_kode',$iiv['iumxxmh_unit_kode'])
					->set('iumxxmh_unit_nama',$iiv['iumxxmh_unit_nama'])
					->set('tanggal',$iiv['tanggal_insert'])
					->set('is_fisik',1)
					->set('iumxxmh_terkecil_kode',$iiv['iumxxmh_terkecil_kode'])
					->set('iumxxmh_terkecil_nama',$iiv['iumxxmh_terkecil_nama'])
					->set('iumxxmh_default_kode',$iiv['iumxxmh_default_kode'])
					->set('iumxxmh_default_nama',$iiv['iumxxmh_default_nama'])
					->set('jumlah_unit',$iiv['jumlah_default_hitung'])
					->set('jumlah_terkecil',$iiv['jumlah_terkecil_hitung'])
					->set('jumlah_default',$iiv['jumlah_default_hitung'])
					->set('jumlah_konversi',$iiv['jumlah_konversi'])
					->set('batch_number',$iiv['batch_number_final'])
					->set('expired_date',$iiv['expired_date_final'])
					->set('iimxxmh_status',$iimxxmh_status)
				->exec();

				//insert Detail Item Status
				$qi_qwhittd = $editor->db()
					->query('insert', 'qwhittd')
					->set('id_qwhxxth',$id)
					->set('id_wloctmh',$iiv['id_wloctmh'])
					->set('wlpxxmh_kode',$iiv['wlpxxmh_kode'])
					->set('id_iwhxxmh',$iiv['id_iwhxxmh'])
					->set('id_wloxxmh',$iiv['id_wloxxmh'])
					->set('id_iimxxmh',$iiv['id_iimxxmh'])
					->set('id_iumxxmh_unit',$iiv['id_iumxxmh_unit'])
					->set('id_iumxxmh_terkecil',$iiv['id_iumxxmh_terkecil'])
					->set('id_iumxxmh_default',$iiv['id_iumxxmh_default'])
					->set('iwhxxmh_kode',$iiv['iwhxxmh_kode'])
					->set('iwhxxmh_nama',$iiv['iwhxxmh_nama'])
					->set('wloxxmh_kode',$iiv['wloxxmh_kode'])
					->set('wloxxmh_nama',$iiv['wloxxmh_nama'])
					->set('iimxxmh_kode',$iiv['iimxxmh_kode'])
					->set('iimxxmh_nama',$iiv['iimxxmh_nama'])
					->set('iumxxmh_unit_kode',$iiv['iumxxmh_unit_kode'])
					->set('iumxxmh_unit_nama',$iiv['iumxxmh_unit_nama'])
					->set('iumxxmh_terkecil_kode',$iiv['iumxxmh_terkecil_kode'])
					->set('iumxxmh_terkecil_nama',$iiv['iumxxmh_terkecil_nama'])
					->set('iumxxmh_default_kode',$iiv['iumxxmh_default_kode'])
					->set('iumxxmh_default_nama',$iiv['iumxxmh_default_nama'])
					->set('jumlah_unit',$iiv['jumlah_default_hitung'])
					->set('jumlah_terkecil',$iiv['jumlah_terkecil_hitung'])
					->set('jumlah_default',$iiv['jumlah_default_hitung'])
					->set('jumlah_konversi',$iiv['jumlah_konversi'])
					->set('batch_number',$iiv['batch_number_final'])
					->set('expired_date',$iiv['expired_date_final'])
					->set('iimxxmh_status',$iimxxmh_status)
					->set('iimxxmh_status_old',$iiv['iimxxmh_status_last'])
					->set('alasan_perubahan_status',$alasan_perubahan_status)
				->exec();

				//generate_kode Item Status
				$nama_tabel = "qwhxxth";
				$qs_gdnxxsh = $editor->db()
					->raw()
					->exec('
						SELECT
							*
						FROM 
							gdnxxsh
						WHERE 
							nama_tabel = "qwhxxth"'
					);
				$rs_gdnxxsh = $qs_gdnxxsh->fetch();
				$prefix                 = $rs_gdnxxsh['prefix'];
				$total_digit            = $rs_gdnxxsh['total_digit'];
				$separator              = $rs_gdnxxsh['separator'];

				$nama_field_tanggal = 'activity_log_ml.created_on';
				$field_tanggal 		= date('Y-m-d');
				$field_tanggal_dt	= strtotime($field_tanggal);
				$tahun = substr($field_tanggal,2,2);
				$bulan = substr($field_tanggal,5,2);

				$tanggal = $field_tanggal;
				$where = " WHERE activity_log_ml.kode = 'CREATE' AND activity_log_ml.nama = '" . $nama_tabel . "' ";
				$where = $where . " AND YEAR(".$nama_field_tanggal.") = YEAR('" . $tanggal . "') AND MONTH(".$nama_field_tanggal.") = MONTH('" . $tanggal . "') ";

				General::logChange( $editor->db() , 'qwhxxth', $s_id_users, $s_username, 'CREATE', $id, 'Insert from generate', $start_at, $finish_at );
				
				$qs_c_id_new = $editor->db()
					->raw()
					->exec('
						SELECT
							count(activity_log_ml.id) as c_id_new
						FROM '.$nama_tabel.'
						LEFT JOIN activity_log_ml ON
							activity_log_ml.id_transaksi = '.$nama_tabel.'.id 
							AND  activity_log_ml.kode = "CREATE" 
							AND activity_log_ml.nama = "'.$nama_tabel.'" 
						' 
						. $where 

					);
				$rs_c_id_new 	= $qs_c_id_new->fetch();
				$new_number  	= $rs_c_id_new['c_id_new'];
				$tr_kode 		= str_pad($new_number,$total_digit,"0",STR_PAD_LEFT);

				$formatted_kode = $prefix . $separator . $tahun . $bulan . $separator . $tr_kode;
				
				$result = $editor->db()
					->query('update', $nama_tabel)
					->set('kode',$formatted_kode)
					->where('id',$id)
				->exec();

	});
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>