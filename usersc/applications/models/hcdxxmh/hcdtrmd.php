<?php
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	// include_once( "../../../helpers/hakakses_s_fn.php" );
	// 
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
	
	if ( ! isset($_POST['id_hcdxxmh']) || ! is_numeric($_POST['id_hcdxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'hcdtrmd' )
			->debug(true)
			->fields(
				Field::inst( 'hcdtrmd.id' ),
				Field::inst( 'hcdtrmd.id_files' )
				->setFormatter( Format::ifEmpty( 0 ) )
				->upload( Upload::inst(  $abs_us_root.$us_url_root.'usersc/files/uploads/__ID__.__EXTN__' )
					->db( 'files', 'id', array(
						'filename'    => Upload::DB_FILE_NAME,
						'filesize'    => Upload::DB_FILE_SIZE,
						'web_path'    => Upload::DB_WEB_PATH,
						'system_path' => Upload::DB_SYSTEM_PATH,
						'extn' 		  => Upload::DB_EXTN
					) )
					->validator( Validate::fileSize( 5000000, 'Ukuran file lampiran maksimal 2mb' ) )
					->validator( Validate::fileExtensions( array( 'pdf', 'png', 'jpg', 'jpeg' ), "Hanya diperbolehkan jenis pdf, png, jpg, atau jpeg" ) )
					),
				Field::inst( 'hcdtrmd.id_hcdxxmh' ),
				
				Field::inst( 'hcdtrmd.tanggal_mulai' )
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
				Field::inst( 'hcdtrmd.tanggal_selesai' )
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
				Field::inst( 'hcdtrmd.kode' ),
				Field::inst( 'hcdtrmd.nama' ),
				Field::inst( 'hcdtrmd.keterangan' ),
				Field::inst( 'hcdtrmd.created_by' ),
				Field::inst( 'hcdtrmd.transaction_state' ),
				Field::inst( 'hcdtrmd.approval_state' ),
				Field::inst( 'hcdtrmd.start_at' ),
				Field::inst( 'hcdtrmd.finish_at' ),
				Field::inst( 'hcdtrmd.is_defaultprogram' ),
				Field::inst( 'hcdtrmd.lembaga' ),
				Field::inst( 'hcdtrmd.biayai' ),
				Field::inst( 'hcdtrmd.bersertifikat' )
			)
			->where('hcdtrmd.id_hcdxxmh',$_POST['id_hcdxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hcdtrmd'] == 0){
			$editor
				->where( 'hcdtrmd.transaction_state', -9, '<>');
		}
		
		// include( "hcdtrmd_extra.php" );

		// BEGIN log
		// $nama_table = 'hcdtrmd';
		// include( "../../../helpers/edt_log.php" );
		// END log
		
		$json = $editor
			->process( $_POST )
			->data();

		// debugging hak akses
		// // $json['hakakses'] = $hakakses;

		echo json_encode( $json );

	}
?>