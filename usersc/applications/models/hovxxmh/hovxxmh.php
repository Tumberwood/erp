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
	
	$editor = Editor::inst( $db, 'hovxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'hovxxmh.id' ),
			Field::inst( 'hovxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hovxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hovxxmh.keterangan' ),
			Field::inst( 'hovxxmh.created_by' ),
			Field::inst( 'hovxxmh.transaction_state' ),
			Field::inst( 'hovxxmh.approval_state' ),
			Field::inst( 'hovxxmh.start_at' ),
			Field::inst( 'hovxxmh.finish_at' ),
			Field::inst( 'hovxxmh.is_defaultprogram' ),
			Field::inst( 'hovxxmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hovxxmh'] == 0){
		$editor
			->where( 'hovxxmh.transaction_state', -9, '<>');
	}
	
	include( "hovxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'hovxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>