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
	
		if ( ! isset($_POST['id_isoxxth_upload_filter']) || $_POST['id_isoxxth_upload_filter'] == 0 ) {
			echo json_encode( [ "data" => [] ] );
		}else{	
			$editor = Editor::inst( $db, 'isoittd_upload' )
				->debug(true)
				->fields(
					Field::inst( 'isoittd_upload.id' ),
					Field::inst( 'isoittd_upload.id_isoxxth_upload' ),
					// Field::inst( 'isoittd_upload.id_iimxxmh' )
					// 	->setFormatter( Format::ifEmpty( 0 ) ),
					// Field::inst( 'isoittd_upload.id_wloxxmh' )
					// 	->setFormatter( Format::ifEmpty( 0 ) ),
					// Field::inst( 'isoittd_upload.id_iumxxmh_terkecil' )
					// 	->setFormatter( Format::ifEmpty( 0 ) ),
					Field::inst( 'isoittd_upload.lokasi' )
						->setFormatter( Format::ifEmpty( 0 ) ),
					Field::inst( 'isoittd_upload.satuan' )
						->setFormatter( Format::ifEmpty( 0 ) ),
					Field::inst( 'isoittd_upload.kode' )
						->setFormatter( Format::ifEmpty( 0 ) ),
					Field::inst( 'isoittd_upload.nama' ),
					Field::inst( 'isoittd_upload.keterangan' ),
					Field::inst( 'isoittd_upload.created_by' ),
					Field::inst( 'isoittd_upload.transaction_state' ),
					Field::inst( 'isoittd_upload.approval_state' ),
					Field::inst( 'isoittd_upload.start_at' ),
					Field::inst( 'isoittd_upload.finish_at' ),
					Field::inst( 'isoittd_upload.is_defaultprogram' ),
					Field::inst( 'isoittd_upload.jumlah_terkecil' ),
					Field::inst( 'isoittd_upload.fisik' ),
					Field::inst( 'isoittd_upload.selisih' ),
					Field::inst( 'isoittd_upload.lpn' ),
					Field::inst( 'isoittd_upload.is_skip' ),
					Field::inst( 'isoittd_upload.batch_number' ),
					Field::inst( 'isoittd_upload.expired_date' )
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
						
					Field::inst( 'isoxxth_upload.tanggal_upload' )
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
					Field::inst( 'isoxxth_upload.kode' ),
					// Field::inst( 'iimxxmh.kode' ),
					// Field::inst( 'iimxxmh.nama' ),
					// Field::inst( 'iumxxmh.kode' ),
					// Field::inst( 'iwhxxmh.nama' ),
					// Field::inst( 'wloxxmh.nama' ),
					// Field::inst( 'wloznmh.nama' ),
				)
				->leftJoin( 'isoxxth_upload','isoxxth_upload.id','=','isoittd_upload.id_isoxxth_upload' )
				// ->leftJoin( 'iimxxmh','iimxxmh.id','=','isoittd_upload.id_iimxxmh' )
				// ->leftJoin( 'iumxxmh','iumxxmh.id','=','isoittd_upload.id_iumxxmh_terkecil' )
				// ->leftJoin( 'iwhxxmh','iwhxxmh.id','=','isoxxth_upload.id_iwhxxmh' )
				// ->leftJoin( 'wloxxmh','wloxxmh.id','=','isoittd_upload.id_wloxxmh' )
				// ->leftJoin( 'wloznmh','wloznmh.id','=','wloxxmh.id_wloznmh' )

				// ->where( 'isoxxth_upload.id', $_POST['id_isoxxth_upload_filter'])
				->where( function ( $q ) {
					$q
						->where( function ( $r ) {
							$r
							->where( 'isoxxth_upload.id', $_POST['id_isoxxth_upload_filter'])
							->or_where('isoxxth_upload.id_isoxxth_upload_parent', $_POST['id_isoxxth_upload_filter']);
						} );
				} )
				;
			
			// do not erase
			// function show / hide inactive document
			if ( $_POST['show_deleted_isoittd_upload'] == 0){
				$editor
					->where( 'isoittd_upload.transaction_state', -9, '<>');
			}

			// include( "isoittd_upload_r_extra.php" );

			// BEGIN log
			$nama_table = 'isoittd_upload';
			include( "../../../helpers/edt_log.php" );
			// END log
			
			$json = $editor
				->process( $_POST )
				->data();

			// debugging hak akses
			$json['hakakses'] = $hakakses;

			echo json_encode( $json );
		}
?>