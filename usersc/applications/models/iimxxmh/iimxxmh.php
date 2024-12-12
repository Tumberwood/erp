<?php
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../helpers/hakakses_s_fn.php" );
	include_once( "../../../helpers/SolusiIndonesiaUtilities.php" );
	include_once( "../../../helpers/fn_is_nextprocess.php" );
	
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
	
	$editor = Editor::inst( $db, 'iimxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'iimxxmh.id' ),
			Field::inst( 'iimxxmh.id_iitxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'iimxxmh.id_iicxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'iimxxmh.id_iigxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'iimxxmh.id_iigx2mh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'iimxxmh.id_iibxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'iimxxmh.id_iumxxmh_content' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'iimxxmh.id_files_image' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'iimxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'iimxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'iimxxmh.keterangan' ),
			Field::inst( 'iimxxmh.created_by' ),
			Field::inst( 'iimxxmh.transaction_state' ),
			Field::inst( 'iimxxmh.approval_state' ),
			Field::inst( 'iimxxmh.start_at' ),
			Field::inst( 'iimxxmh.finish_at' ),
			Field::inst( 'iimxxmh.is_defaultprogram' ),
			Field::inst( 'iimxxmh.movement_method' ),
			Field::inst( 'iimxxmh.movement_method2' ),
			Field::inst( 'iimxxmh.is_batch_number' ),
			Field::inst( 'iimxxmh.is_expired_date' ),

			Field::inst( 'iimxxmh.content' ),

			Field::inst( 'iitxxmh.nama' ),
			Field::inst( 'iicxxmh.nama' ),
			Field::inst( 'iigxxmh.nama' )
		)
		->leftJoin( 'iitxxmh','iitxxmh.id','=','iimxxmh.id_iitxxmh' )
		->leftJoin( 'iicxxmh','iicxxmh.id','=','iimxxmh.id_iicxxmh' )
		->leftJoin( 'iigxxmh','iigxxmh.id','=','iimxxmh.id_iigxxmh' )
		
		// BEGIN upload multi file
		// table files dan filestr adalah bawaan framework, jangan diganti. cukup ganti iimxxmh nya saja dan folder 
		->join(
			Mjoin::inst( 'files' )
				->link( 'iimxxmh.id', 'filestr.id_transaksi' )
				->link( 'files.id', 'filestr.id_files' )
				->fields(
					Field::inst( 'id' )
						->upload( Upload::inst( $abs_us_root.$us_url_root. 'usersc/files/iimxxmh/__ID__.__EXTN__' )
							->db( 'files', 'id', array(
								'filename'    => Upload::DB_FILE_NAME,
								'filesize'    => Upload::DB_FILE_SIZE,
								'web_path'    => Upload::DB_WEB_PATH,
								'system_path' => Upload::DB_SYSTEM_PATH,
								'extn' 		  => Upload::DB_EXTN,
								'tbl_nama' 	  => 'iimxxmh'
							) )
							->dbClean( 'filestr.id_files', function ( $files ) use ($db) { 
								for ( $i=0, $ien=count($files) ; $i<$ien ; $i++ ) {
									if( $files[$i]['tbl_nama'] == 'iimxxmh'){
										$qd_files = $db
											->query('delete', 'files')
											->where('id', $files[$i]['id'])
											->exec();
										unlink( $files[$i]['system_path'] );
									}
								}
							})
							->validator( Validate::fileSize( 1000000, 'Ukuran file lampiran maksimal 1mb' ) )
							->validator( Validate::fileExtensions( array( 'png', 'jpg', 'jpeg', 'webp' ), "Hanya diperbolehkan jenis png, jpg, jpeg atau webp" ) )
						),
					Field::inst( 'web_path' )
				)
		)
	// END upload multi file
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_iimxxmh'] == 0){
		$editor
			->where( 'iimxxmh.transaction_state', -9, '<>');
	}
	
	include( "iimxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'iimxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>