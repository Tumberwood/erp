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
		DataTables\Editor\Result;

	use 
		Carbon\Carbon;
	
	$editor = Editor::inst( $db, '_demo_m' )
		->debug(true)
		->fields(
			Field::inst( '_demo_m.id' ),
			Field::inst( '_demo_m.id_gctxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( '_demo_m.id_files' )
				->setFormatter( Format::ifEmpty( 0 ) )
				->upload( Upload::inst(  $abs_us_root.$us_url_root.'usersc/files/uploads/__ID__.__EXTN__' )
					->db( 'files', 'id', array(
						'filename'		=> Upload::DB_FILE_NAME,
						'filesize'		=> Upload::DB_FILE_SIZE,
						'web_path'		=> Upload::DB_WEB_PATH,
						'system_path'		=> Upload::DB_SYSTEM_PATH,
						'extn'		=> Upload::DB_EXTN
					) )
					->validator( Validate::fileSize( 500000, 'Ukuran lampiran maksimal 500Kb' ) )
					->validator( Validate::fileExtensions( array( 'png', 'jpg', 'jpeg'), "Hanya boleh format png, jpg atau jpeg" ) )
				),
			Field::inst( '_demo_m.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( '_demo_m.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( '_demo_m.keterangan' ),
			Field::inst( '_demo_m.created_by' ),
			Field::inst( '_demo_m.transaction_state' ),
			Field::inst( '_demo_m.approval_state' ),
			Field::inst( '_demo_m.start_at' ),
			Field::inst( '_demo_m.finish_at' ),
			Field::inst( '_demo_m.is_defaultprogram' ),
			Field::inst( '_demo_m.is_nextprocess' ),
			Field::inst( '_demo_m.is_field' ),
			Field::inst( '_demo_m.is_show' ),
			Field::inst( '_demo_m.tanggal' )
				->getFormatter( function ( $val, $data, $opts ) {
					if ($val === '0000-00-00' || $val === null){
						return '';
					}else{
						return date( 'd M Y', strtotime( $val ) );
					}
				} )
				->setFormatter( 'Format::datetime', array(
					'from' => 'd M Y',
					'to' =>   'Y-m-d'
				) ),
			Field::inst( '_demo_m.tanggaljam' )
				->getFormatter( 'Format::datetime', array(
					'from' => 'Y-m-d H:i:s',
					'to' =>   'd M Y H:i'
				) )
				->setFormatter( 'Format::datetime', array(
					'from' => 'd M Y H:i',
					'to' =>   'Y-m-d H:i:s'
				) ),
			Field::inst( '_demo_m.jam' )
				->getFormatter( function ( $val, $data, $opts ) {
					if ($val === '00:00:00' || $val === null){
						return '';
					}else{
						return date( 'H:i', strtotime( $val ) );
					}
				} )
				->setFormatter( 'Format::datetime', array(
					'from' => 'H:i',
					'to' =>   'H:i:s'
				) ),
			Field::inst( '_demo_m.notes' )
		);
	
	if($_POST['start_date'] != ''){
		$editor->where( '_demo_m.tanggal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( '_demo_m.tanggal', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted__demo_m'] == 0){
		$editor
			->where( '_demo_m.transaction_state', -9, '<>');
	}
	
	include( "_demo_m_extra.php" );

	// BEGIN log
	$nama_table = '_demo_m';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>