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

	$editor = Editor::inst( $db, 'htpxxth' )
		->debug(true)
		->fields(
			Field::inst( 'htpxxth.id' ),
			Field::inst( 'htpxxth.id_hemxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'htpxxth.id_httlpmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'htpxxth.id_files_bukti' )
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
			Field::inst( 'htpxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'htpxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'htpxxth.keterangan' ),
			Field::inst( 'htpxxth.created_by' ),
			Field::inst( 'htpxxth.transaction_state' ),
			Field::inst( 'htpxxth.approval_state' ),
			Field::inst( 'htpxxth.start_at' ),
			Field::inst( 'htpxxth.finish_at' ),
			Field::inst( 'htpxxth.is_defaultprogram' ),
			
			Field::inst( 'htpxxth.tanggal' )
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
			Field::inst( 'htpxxth.jam_awal' )
				->getFormatter( function ( $val, $data, $opts ) {
					if ($val === '00:00:00' || $val === null){
						echo '';
					}else{
						return date( 'H:i', strtotime( $val ) );
					}
				} )
				->setFormatter( 'Format::datetime', array(
					'from' => 'H:i',
					'to' =>   'H:i:s'
				) ),
			Field::inst( 'htpxxth.jam_akhir' )
				->getFormatter( function ( $val, $data, $opts ) {
					if ($val === '00:00:00' || $val === null){
						echo '';
					}else{
						return date( 'H:i', strtotime( $val ) );
					}
				} )
				->setFormatter( 'Format::datetime', array(
					'from' => 'H:i',
					'to' =>   'H:i:s'
				) ),
			Field::inst( 'concat(hemxxmh.kode," - ",hemxxmh.nama) as hemxxmh_data' ),

			Field::inst( 'httlpmh.nama' ),
			Field::inst( 'hetxxmh.nama' ),
			Field::inst( 'hodxxmh.nama' )
		)
		->leftJoin( 'hemxxmh','hemxxmh.id','=','htpxxth.id_hemxxmh' )
		->leftJoin( 'httlpmh','httlpmh.id','=','htpxxth.id_httlpmh' )

		->leftJoin('hemjbmh','hemjbmh.id_hemxxmh','=','hemxxmh.id','LEFT' )
		->leftJoin('hetxxmh','hetxxmh.id','=','hemjbmh.id_hetxxmh','LEFT' )
		->leftJoin('hodxxmh','hodxxmh.id','=','hemjbmh.id_hodxxmh','LEFT' )
		->where( 'htpxxth.tanggal', $_POST['start_date'], '>=')
		->where( 'htpxxth.tanggal', $_POST['end_date'], '<=')
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_htpxxth'] == 0){
		$editor
			->where( 'htpxxth.transaction_state', -9 , '<>');
	}

	if ( $_POST['start_date'] != null){
		$editor
			->where( 'htpxxth.tanggal', $_POST['start_date'], '>=');
	}

	if ( $_POST['end_date'] != null){
		$editor
			->where( 'htpxxth.tanggal', $_POST['end_date'], '<=');
	}
	
	include( "htpxxth_extra.php" );

	// BEGIN log
	$nama_table = 'htpxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>