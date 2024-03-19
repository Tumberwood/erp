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
	
	if ( ! isset($_POST['id_isoittd_upload']) || ! is_numeric($_POST['id_isoittd_upload']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'isoittd_upload_fisik' )
			->debug(true)
			->fields(
				Field::inst( 'isoittd_upload_fisik.id' ),
				Field::inst( 'isoittd_upload_fisik.id_isoittd_upload' ),
				Field::inst( 'isoittd_upload_fisik.kode' ),
				Field::inst( 'isoittd_upload_fisik.nama' ),
				Field::inst( 'isoittd_upload_fisik.keterangan' ),
				Field::inst( 'isoittd_upload_fisik.created_by' ),
				Field::inst( 'isoittd_upload_fisik.transaction_state' ),
				Field::inst( 'isoittd_upload_fisik.approval_state' ),
				Field::inst( 'isoittd_upload_fisik.start_at' ),
				Field::inst( 'isoittd_upload_fisik.finish_at' ),
				Field::inst( 'isoittd_upload_fisik.is_defaultprogram' ),
				Field::inst( 'isoittd_upload_fisik.fisik' ),
			)
			// BEGIN upload multi file
			// table files dan filestr adalah bawaan framework, jangan diganti. cukup ganti isoittd_upload_fisik nya saja dan folder 
			->join(
				Mjoin::inst( 'files' )
					->link( 'isoittd_upload_fisik.id', 'filestr.id_transaksi' )
					->link( 'files.id', 'filestr.id_files' )
					->fields(
						Field::inst( 'id' )
							->upload( Upload::inst( $abs_us_root.$us_url_root. '/usersc/uploads/__ID__.__EXTN__' )
								->db( 'files', 'id', array(
									'filename'    => Upload::DB_FILE_NAME,
									'filesize'    => Upload::DB_FILE_SIZE,
									'web_path'    => Upload::DB_WEB_PATH,
									'system_path' => Upload::DB_SYSTEM_PATH,
									'extn' 		  => Upload::DB_EXTN
								) )
								->validator( Validate::fileSize( 1000000, 'Ukuran file lampiran maksimal 1mb' ) )
								->validator( Validate::fileExtensions( array( 'pdf', 'png', 'jpg', 'jpeg' ), "Hanya diperbolehkan jenis pdf, png, jpg, atau jpeg" ) )
							),
						Field::inst( 'web_path' )
					)
			)
		// END upload multi file
			->where('isoittd_upload_fisik.id_isoittd_upload',$_POST['id_isoittd_upload']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_isoittd_upload_fisik'] == 0){
			$editor
				->where( 'isoittd_upload_fisik.transaction_state', -9, '<>');
		}
		
		include( "isoittd_upload_fisik_extra.php" );

		// BEGIN log
		$nama_table = 'isoittd_upload_fisik';
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