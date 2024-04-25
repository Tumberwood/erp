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
	
	if ( ! isset($_POST['id_hemxxmh']) || ! is_numeric($_POST['id_hemxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'htlxxth' )
			->debug(true)
			->fields(
				Field::inst( 'htlxxth.id' ),
				Field::inst( 'htlxxth.id_hemxxmh' ),
				Field::inst( 'htlxxth.id_httlpmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'htlxxth.id_files_lampiran' )
					->setFormatter( Format::ifEmpty( 0 ) )
					->upload( Upload::inst(  $abs_us_root.$us_url_root.'usersc/files/uploads/__ID__.__EXTN__' )
						->db( 'files', 'id', array(
							'filename'    => Upload::DB_FILE_NAME,
							'filesize'    => Upload::DB_FILE_SIZE,
							'web_path'    => Upload::DB_WEB_PATH,
							'system_path' => Upload::DB_SYSTEM_PATH,
							'extn' 		  => Upload::DB_EXTN
						) )
						->validator( Validate::fileSize( 500000, 'Ukuran lampiran maksimal 500Kb' ) )
						->validator( Validate::fileExtensions( array( 'png', 'jpg', 'jpeg'), "Hanya boleh format png, jpg atau jpeg" ) )
					),
				Field::inst( 'htlxxth.kode' ),
				Field::inst( 'htlxxth.nama' ),
				Field::inst( 'htlxxth.keterangan' ),
				Field::inst( 'htlxxth.created_by' ),
				Field::inst( 'htlxxth.transaction_state' ),
				Field::inst( 'htlxxth.approval_state' ),
				Field::inst( 'htlxxth.start_at' ),
				Field::inst( 'htlxxth.finish_at' ),
				Field::inst( 'htlxxth.is_defaultprogram' ),
				Field::inst( 'htlxxth.is_default' ),
				Field::inst( 'htlxxth.tanggal_awal' )
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
				Field::inst( 'htlxxth.tanggal_akhir' )
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

				Field::inst( 'httlpmh.nama' )
			)
			->leftJoin( 'httlpmh','httlpmh.id','=','htlxxth.id_httlpmh' )
			->where('htlxxth.approval_state', 1)
			->where('htlxxth.id_hemxxmh',$_POST['id_hemxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_htlxxth'] == 0){
			$editor
				->where( 'htlxxth.transaction_state', -9, '<>');
		}
		
		include( "htlxxth_extra.php" );

		// BEGIN log
		$nama_table = 'htlxxth';
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