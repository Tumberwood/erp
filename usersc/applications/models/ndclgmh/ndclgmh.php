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
	
	$editor = Editor::inst( $db, 'ndclgmh' )
		->debug(true)
		->fields(
			Field::inst( 'ndclgmh.id' ),
			Field::inst( 'ndclgmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'ndclgmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'ndclgmh.keterangan' ),
			Field::inst( 'ndclgmh.created_by' ),
			Field::inst( 'ndclgmh.transaction_state' ),
			Field::inst( 'ndclgmh.approval_state' ),
			Field::inst( 'ndclgmh.start_at' ),
			Field::inst( 'ndclgmh.finish_at' ),
			Field::inst( 'ndclgmh.is_defaultprogram' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_ndclgmh'] == 0){
		$editor
			->where( 'ndclgmh.transaction_state', -9, '<>');
	}
	
	include( "ndclgmh_extra.php" );

	// BEGIN log
	$nama_table = 'ndclgmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>