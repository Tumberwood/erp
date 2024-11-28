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
	
	if ( ! isset($_POST['id_wktxxth']) || ! is_numeric($_POST['id_wktxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'wktrstd' )
			->debug(true)
			->fields(
				Field::inst( 'wktrstd.id' ),
				Field::inst( 'wktrstd.id_wktxxth' ),
				Field::inst( 'wktrstd.id_iimxxmh' ),
				Field::inst( 'wktrstd.id_iumxxmh_unit' ),
				Field::inst( 'wktrstd.id_wloxxmh' ),
				Field::inst( 'wktrstd.wloxxmh_nama' ),
				Field::inst( 'wktrstd.id_iwhxxmh' ),
				Field::inst( 'wktrstd.jumlah_unit' ),
			)
			->where('wktrstd.id_wktxxth',$_POST['id_wktxxth']);
		
		$editor
			->on('postCreate',function( $editor, $id, $values, $row ) use ( $s_id_users, $s_username) {
				$start_at           = $values['start_at'];
            	$finish_at          = $values['finish_at'];
            	$id_wktxxth          = $values['wktrstd']['id_wktxxth'];

				$nama_table = 'wktrstd';
				General::konversiUom($editor->db(), $nama_table, $id);

				$qs_ggswmsh = $editor->db()
					->query('select', 'ggswmsh' )
					->get(['format_lpn_kitting'] )
					->where('id', 1 )
					->exec();
				$rs_ggswmsh = $qs_ggswmsh->fetch();
				$format_lpn_kitting = $rs_ggswmsh['format_lpn_kitting'];
				
				//LPN baru
				$qs_same_lpn_kit = $editor->db()
					->raw()
					->bind(':id_wktxxth', $id_wktxxth)
					->exec('SELECT
								a.wlpxxmh_kode
							FROM wktrstd a
							WHERE a.id_wktxxth = :id_wktxxth AND wlpxxmh_kode IS NOT NULL
							ORDER BY id DESC
				');
				$rs_same_lpn_kit = $qs_same_lpn_kit->fetch();
				
				if ($format_lpn_kitting && !empty($rs_same_lpn_kit)) {
					$same_kit_wlpxxmh_kode = $rs_same_lpn_kit['wlpxxmh_kode'];
					$wlpxxmh_kode = $same_kit_wlpxxmh_kode;
				} else {
					//LPN baru
					$qs_wlpxxmh = $editor->db()
						->raw()
						->exec('SELECT
									a.kode
								FROM wlpxxmh a
								WHERE a.is_nextprocess IS NULL
								AND kode NOT IN
								(
									SELECT
										wlpxxmh_kode
									FROM iivxxrd b
									GROUP BY b.wlpxxmh_kode
								)
					');
					$rs_wlpxxmh = $qs_wlpxxmh->fetch();
					$wlpxxmh_kode = $rs_wlpxxmh['kode'];
				}
				
				// cari expired_date dari detail item yg terdekat dari today
				$qs_exp_date = $editor->db()
					->raw()
					->bind(':id_wktxxth', $id_wktxxth)
					->exec('SELECT
								a.expired_date,
								b.kode
							FROM wktlptd a
							LEFT JOIN wktxxth b ON b.id = a.id_wktxxth
							WHERE a.id_wktxxth = :id_wktxxth
							ORDER BY expired_date
				');
				$rs_exp_date = $qs_exp_date->fetch();
				$expired_date = $rs_exp_date['expired_date'];
				$kode = $rs_exp_date['kode'];
				
				//update expired data dan lpn
				$qu_wktrstd = $editor->db()
					->query('update', 'wktrstd')
					->set('batch_number',$kode)
					->set('expired_date',$expired_date)
					->set('wlpxxmh_kode',$wlpxxmh_kode)
					->where('id',$id)
					->exec();
				
				$qu_wlpxxmh = $editor->db()
					->query('update', 'wlpxxmh')
					->set('is_nextprocess',1)
					->where('kode',$wlpxxmh_kode)
					->exec();

				//insert balik detail Kitting dengan jumlah finalisasi minus
				$qi_iivxxrd_det = $editor->db()
					->raw()
					->bind(':id_wktxxth', $id_wktxxth)
					->bind(':id', $id)
					->exec('INSERT INTO iivxxrd (
								id_gcpxxmh,
								id_gbrxxmh,
								id_transaksi_h,
								id_transaksi_d,
								id_wloctmh,
								kode,
								wlpxxmh_kode,
								id_iwhxxmh,
								id_wloxxmh,
								id_relasi_m,
								id_iimxxmh,
								id_iumxxmh_unit,
								id_iumxxmh_terkecil,
								id_iumxxmh_default,
								keterangan,
								iwhxxmh_kode,
								iwhxxmh_nama,
								wloxxmh_kode,
								wloxxmh_nama,
								relasi_m_kode,
								relasi_m_nama,
								iimxxmh_kode,
								iimxxmh_nama,
								iumxxmh_unit_kode,
								iumxxmh_unit_nama,
								imtxxmh_kode,
								imtxxmh_movement_type,
								tanggal,
								is_fisik,
								iumxxmh_terkecil_kode,
								iumxxmh_terkecil_nama,
								iumxxmh_default_kode,
								iumxxmh_default_nama,
								jumlah_unit,
								jumlah_konversi,
								jumlah_terkecil,
								jumlah_default,
								expired_date,
								batch_number
							)
							SELECT DISTINCT
								h.id_gcpxxmh,
								e.id_gbrxxmh,
								a.id_wktxxth AS id_transaksi_h,
								a.id AS id_transaksi_d,
								f.id_wloctmh,
								a.kode,
								a.wlpxxmh_kode,
								a.id_iwhxxmh,
								b.id_wloxxmh_out,
								b.id_grlxxmh_customer id_relasi_m,
								a.id_iimxxmh,
								a.id_iumxxmh_unit,
								a.id_iumxxmh_terkecil,
								a.id_iumxxmh_default,
								CONCAT("wktxxth_", a.id_wktxxth) AS keterangan,
								e.kode AS iwhxxmh_kode,
								e.nama AS iwhxxmh_nama,
								f.kode AS wloxxmh_kode,
								f.nama AS wloxxmh_nama,
								c.kode AS relasi_m_kode,
								c.nama AS relasi_m_nama,
								d.kode AS iimxxmh_kode,
								d.nama AS iimxxmh_nama,
								iumxxmh_unit.kode AS iumxxmh_unit_kode,
								iumxxmh_unit.nama AS iumxxmh_unit_nama,
								219,
								g.movement_type,
								curdate(),
								1,
								iumxxmh_terkecil.kode AS iumxxmh_terkecil_kode,
								iumxxmh_terkecil.nama AS iumxxmh_terkecil_nama,
								iumxxmh_default.kode AS iumxxmh_default_kode,
								iumxxmh_default.nama AS iumxxmh_default_nama,
								-- a.jumlah_unit,
								-- a.jumlah_konversi,
								-- a.jumlah_terkecil,
								-- a.jumlah_default,
								
								-i.jumlah_unit * k.jumlah_unit jumlah_unit_iiv,
								a.jumlah_konversi,
								-(i.jumlah_unit * a.jumlah_konversi) * k.jumlah_unit jumlah_terkecil_iiv,
								-(i.jumlah_unit * a.jumlah_konversi / j.jumlah_konversi) * k.jumlah_unit jumlah_default_iiv,
								
								a.expired_date,
								a.batch_number

							FROM wktlptd a
							LEFT JOIN wktxxth b ON b.id = a.id_wktxxth
							LEFT JOIN grlxxmh c ON c.id = b.id_grlxxmh_customer
							LEFT JOIN iimxxmh d ON d.id = a.id_iimxxmh
							LEFT JOIN iwhxxmh e ON e.id = a.id_iwhxxmh
							LEFT JOIN iumxxmh iumxxmh_unit ON iumxxmh_unit.id = a.id_iumxxmh_unit
							LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
							LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
							LEFT JOIN wloxxmh f ON f.id = b.id_wloxxmh_out
							LEFT JOIN imtxxmh g ON g.kode = 219
							LEFT JOIN gbrxxmh h ON h.id = e.id_gbrxxmh
							LEFT JOIN wktrstd i ON i.id = :id
							LEFT JOIN iimummd j ON j.id_iimxxmh = a.id_iimxxmh AND j.is_default = 1
							LEFT JOIN wktittd k ON k.id = a.id_wktittd
							WHERE b.id = :id_wktxxth
				');

				//insert iiv header Kitting
				$qi_iivxxrd_det = $editor->db()
					->raw()
					->bind(':id', $id)
					->exec('INSERT INTO iivxxrd (
								id_gcpxxmh,
								id_gbrxxmh,
								id_transaksi_h,
								id_transaksi_d,
								id_wloctmh,
								kode,
								wlpxxmh_kode,
								id_iwhxxmh,
								id_wloxxmh,
								id_relasi_m,
								id_iimxxmh,
								id_iumxxmh_unit,
								id_iumxxmh_terkecil,
								id_iumxxmh_default,
								keterangan,
								iwhxxmh_kode,
								iwhxxmh_nama,
								wloxxmh_kode,
								wloxxmh_nama,
								relasi_m_kode,
								relasi_m_nama,
								iimxxmh_kode,
								iimxxmh_nama,
								iumxxmh_unit_kode,
								iumxxmh_unit_nama,
								imtxxmh_kode,
								imtxxmh_movement_type,
								tanggal,
								is_fisik,
								iumxxmh_terkecil_kode,
								iumxxmh_terkecil_nama,
								iumxxmh_default_kode,
								iumxxmh_default_nama,
								jumlah_unit,
								jumlah_konversi,
								jumlah_terkecil,
								jumlah_default,
								expired_date,
								batch_number
							)
							SELECT DISTINCT
								h.id_gcpxxmh,
								e.id_gbrxxmh,
								a.id_wktxxth AS id_transaksi_h,
								a.id AS id_transaksi_d,
								f.id_wloctmh,
								b.kode,
								a.wlpxxmh_kode,
								a.id_iwhxxmh,
								b.id_wloxxmh_out,
								b.id_grlxxmh_customer id_relasi_m,
								a.id_iimxxmh,
								a.id_iumxxmh_unit,
								a.id_iumxxmh_terkecil,
								a.id_iumxxmh_default,
								CONCAT("wktxxth_", a.id_wktxxth) AS keterangan,
								e.kode AS iwhxxmh_kode,
								e.nama AS iwhxxmh_nama,
								f.kode AS wloxxmh_kode,
								f.nama AS wloxxmh_nama,
								c.kode AS relasi_m_kode,
								c.nama AS relasi_m_nama,
								d.kode AS iimxxmh_kode,
								d.nama AS iimxxmh_nama,
								iumxxmh_unit.kode AS iumxxmh_unit_kode,
								iumxxmh_unit.nama AS iumxxmh_unit_nama,
								219,
								g.movement_type,
								curdate(),
								1,
								iumxxmh_terkecil.kode AS iumxxmh_terkecil_kode,
								iumxxmh_terkecil.nama AS iumxxmh_terkecil_nama,
								iumxxmh_default.kode AS iumxxmh_default_kode,
								iumxxmh_default.nama AS iumxxmh_default_nama,
								a.jumlah_unit,
								a.jumlah_konversi,
								a.jumlah_terkecil,
								a.jumlah_default,
								a.expired_date,
								a.batch_number

							FROM wktrstd a
							LEFT JOIN wktxxth b ON b.id = a.id_wktxxth
							LEFT JOIN grlxxmh c ON c.id = b.id_grlxxmh_customer
							LEFT JOIN iimxxmh d ON d.id = a.id_iimxxmh
							LEFT JOIN iwhxxmh e ON e.id = a.id_iwhxxmh
							LEFT JOIN iumxxmh iumxxmh_unit ON iumxxmh_unit.id = a.id_iumxxmh_unit
							LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
							LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
							LEFT JOIN wloxxmh f ON f.id = b.id_wloxxmh_out
							LEFT JOIN imtxxmh g ON g.kode = 219
							LEFT JOIN gbrxxmh h ON h.id = e.id_gbrxxmh
							WHERE a.id = :id
				');
				// 	General::logChange( $editor->db() , 'wktrstd', $s_id_users, $s_username, 'CREATE', $values['wktrstd']['id_wktxxth'], 'Insert from generate', $start_at, $finish_at );

			});
		
		$json = $editor
			->process( $_POST )
			->data();

		// debugging hak akses
		$json['hakakses'] = $hakakses;

		echo json_encode( $json );

	}
?>