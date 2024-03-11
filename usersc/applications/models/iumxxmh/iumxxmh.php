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
	
	$editor = Editor::inst( $db, 'iumxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'iumxxmh.id' ),
			Field::inst( 'iumxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'iumxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'iumxxmh.keterangan' ),
			Field::inst( 'iumxxmh.created_by' ),
			Field::inst( 'iumxxmh.transaction_state' ),
			Field::inst( 'iumxxmh.approval_state' ),
			Field::inst( 'iumxxmh.start_at' ),
			Field::inst( 'iumxxmh.finish_at' ),
			Field::inst( 'iumxxmh.is_defaultprogram' ),
			Field::inst( 'iumxxmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_iumxxmh'] == 0){
		$editor
			->where( 'iumxxmh.transaction_state', -9, '<>');
	}
	
	include( "iumxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'iumxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>