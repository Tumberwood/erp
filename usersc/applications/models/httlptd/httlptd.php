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
	
	$editor = Editor::inst( $db, 'httlptd' )
		->debug(true)
		->fields(
			Field::inst( 'httlptd.id' ),
			Field::inst( 'httlptd.id_httlpmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'httlptd.id_hemxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'httlptd.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'httlptd.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'httlptd.keterangan' ),
			Field::inst( 'httlptd.created_by' ),
			Field::inst( 'httlptd.transaction_state' ),
			Field::inst( 'httlptd.approval_state' ),
			Field::inst( 'httlptd.start_at' ),
			Field::inst( 'httlptd.finish_at' ),
			Field::inst( 'httlptd.is_defaultprogram' ),
			Field::inst( 'httlptd.is_nextprocess' ),
			Field::inst( 'httlptd.jenis' ),

			Field::inst( 'httlptd.tanggal_awal' )
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
			Field::inst( 'httlptd.tanggal_akhir' )
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
			Field::inst( 'httlptd.jam_awal' )
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
			Field::inst( 'httlptd.jam_akhir' )
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

			Field::inst( 'httlpmh.nama' ),
			Field::inst( 'hemxxmh.kode' ),
			Field::inst( 'hemxxmh.nama' )
		)
		->leftJoin( 'httlpmh','httlpmh.id','=','httlptd.id_httlpmh' )
		->leftJoin( 'hemxxmh','hemxxmh.id','=','httlptd.id_hemxxmh' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_httlptd'] == 0){
		$editor
			->where( 'httlptd.transaction_state', -9, '<>');
	}
	
	include( "httlptd_extra.php" );

	// BEGIN log
	$nama_table = 'httlptd';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>