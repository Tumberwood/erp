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
	
	$editor = Editor::inst( $db, 'hadxxtd' )
		->debug(true)
		->fields(
			Field::inst( 'hadxxtd.id' ),
			Field::inst( 'hadxxtd.id_hemxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hadxxtd.id_hadxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hadxxtd.id_havxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hadxxtd.id_files_bukti' )
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
			Field::inst( 'hadxxtd.id_files_dokumen' )
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
			Field::inst( 'hadxxtd.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hadxxtd.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hadxxtd.keterangan' ),
			Field::inst( 'hadxxtd.created_by' ),
			Field::inst( 'hadxxtd.transaction_state' ),
			Field::inst( 'hadxxtd.approval_state' ),
			Field::inst( 'hadxxtd.start_at' ),
			Field::inst( 'hadxxtd.finish_at' ),
			Field::inst( 'hadxxtd.is_defaultprogram' ),
			Field::inst( 'hadxxtd.tanggal_awal' )
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
			Field::inst( 'hadxxtd.tanggal_akhir' )
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

			Field::inst( 'concat(hemxxmh.kode," - ", hemxxmh.nama) as hemxxmh_data' ),
			Field::inst( 'hodxxmh.nama' ),
			Field::inst( 'hetxxmh.nama' ),

			Field::inst( 'hadxxmh.nama' ),
			Field::inst( 'havxxmh.nama' )

		)
		->leftJoin( 'hemxxmh','hemxxmh.id','=','hadxxtd.id_hemxxmh' )
		->leftJoin('hemjbmh','hemjbmh.id_hemxxmh','=','hemxxmh.id','LEFT' )
		->leftJoin('hetxxmh','hetxxmh.id','=','hemjbmh.id_hetxxmh','LEFT' )
		->leftJoin('hodxxmh','hodxxmh.id','=','hemjbmh.id_hodxxmh','LEFT' )

		->leftJoin('hadxxmh','hadxxmh.id','=','hadxxtd.id_hadxxmh','LEFT' )
		->leftJoin('havxxmh','havxxmh.id','=','hadxxtd.id_havxxmh','LEFT' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hadxxtd'] == 0){
		$editor
			->where( 'hadxxtd.transaction_state', -9, '<>');
	}
	
	include( "hadxxtd_extra.php" );

	// BEGIN log
	$nama_table = 'hadxxtd';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>