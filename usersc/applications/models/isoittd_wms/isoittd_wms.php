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

	$editor = Editor::inst( $db, 'isoittd_wms' )
		->debug(true)
		->fields(
			Field::inst( 'isoittd_wms.id' ),
			Field::inst( 'isoittd_wms.id_files_pointer' )
			->setFormatter( Format::ifEmpty( 0 ) )
			->upload( Upload::inst(  $abs_us_root.$us_url_root.'usersc/files/isoxxth_wms/__ID__.__EXTN__' )
				->db( 'files', 'id', array(
					'filename'		=> Upload::DB_FILE_NAME,
					'filesize'		=> Upload::DB_FILE_SIZE,
					'web_path'		=> Upload::DB_WEB_PATH,
					'system_path'	=> Upload::DB_SYSTEM_PATH,
					'extn'		=> Upload::DB_EXTN
				) )
				->validator( Validate::fileSize( 5000000, 'Ukuran lampiran maksimal 5Mb' ) )
				->validator( Validate::fileExtensions( array( 'png', 'jpg', 'jpeg'), "Hanya boleh format png, jpg, dan jpeg" ) )
			),
			Field::inst( 'isoittd_wms.id_isoxxth_wms' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'isoittd_wms.id_iumxxmh_unit' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'isoittd_wms.id_iumxxmh_default' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'isoittd_wms.id_iumxxmh_terkecil' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'isoittd_wms.id_iimxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'isoittd_wms.id_gcpxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'isoittd_wms.id_gbrxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'isoittd_wms.id_iwhxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'isoittd_wms.id_wloxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'isoittd_wms.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'isoittd_wms.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'isoittd_wms.keterangan' ),
			Field::inst( 'isoittd_wms.created_by' ),
			Field::inst( 'isoittd_wms.transaction_state' ),
			Field::inst( 'isoittd_wms.approval_state' ),
			Field::inst( 'isoittd_wms.start_at' ),
			Field::inst( 'isoittd_wms.finish_at' ),
			Field::inst( 'isoittd_wms.wloxxmh_nama' ),
			Field::inst( 'isoittd_wms.iimxxmh_kode' ),
			Field::inst( 'isoittd_wms.iimxxmh_nama' ),
			Field::inst( 'isoittd_wms.jumlah_terkecil' ),
			Field::inst( 'isoittd_wms.jumlah_unit' ),
			Field::inst( 'isoittd_wms.jumlah_default' ),
			Field::inst( 'isoittd_wms.wlpxxmh_kode' ),
			Field::inst( 'isoittd_wms.batch_number' ),
			Field::inst( 'isoittd_wms.jumlah_iiv_terkecil' ),
			Field::inst( 'isoittd_wms.is_add_new' )
			->set( Field::SET_CREATE ),
			Field::inst( 'isoittd_wms.is_scan' )
			->set( Field::SET_CREATE )
			->setValue(1),
			Field::inst( 'isoittd_wms.expired_date' )
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
			Field::inst( 'isoittd_wms.tanggal' )
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
			Field::inst( 'isoittd_wms.is_nextprocess' ),
			Field::inst( 'isoittd_wms.is_defaultprogram' ),
			Field::inst( 'iimxxmh.nama' ),
			Field::inst( 'wloxxmh.nama' ),
			Field::inst( 'iumxxmh_unit.kode' ),
		)
		->leftJoin( 'iimxxmh','iimxxmh.id','=','isoittd_wms.id_iimxxmh' )
		->leftJoin( 'wloxxmh','wloxxmh.id','=','isoittd_wms.id_wloxxmh' )
		->leftJoin( 'iumxxmh iumxxmh_unit','iumxxmh_unit.id','=','isoittd_wms.id_iumxxmh_unit' )
		;

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_isoittd_wms'] == 0){
		$editor
			->where( 'isoittd_wms.transaction_state', -9, '<>');
	}
	
	include( "isoittd_wms_extra.php" );

	// BEGIN log
	$nama_table = 'isoittd_wms';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>