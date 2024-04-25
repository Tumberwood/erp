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
	
	$editor = Editor::inst( $db, 'htrxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'htrxxmh.id' ),
			Field::inst( 'htrxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'htrxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'htrxxmh.keterangan' ),
			Field::inst( 'htrxxmh.created_by' ),
			Field::inst( 'htrxxmh.transaction_state' ),
			Field::inst( 'htrxxmh.approval_state' ),
			Field::inst( 'htrxxmh.start_at' ),
			Field::inst( 'htrxxmh.finish_at' ),
			Field::inst( 'htrxxmh.is_defaultprogram' ),
			Field::inst( 'htrxxmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_htrxxmh'] == 0){
		$editor
			->where( 'htrxxmh.transaction_state', -9, '<>');
	}
	
	include( "htrxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'htrxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>