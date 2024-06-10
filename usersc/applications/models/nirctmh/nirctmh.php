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
	
	$editor = Editor::inst( $db, 'nirctmh' )
		->debug(true)
		->fields(
			Field::inst( 'nirctmh.id' ),
			Field::inst( 'nirctmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'nirctmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'nirctmh.keterangan' ),
			Field::inst( 'nirctmh.created_by' ),
			Field::inst( 'nirctmh.transaction_state' ),
			Field::inst( 'nirctmh.approval_state' ),
			Field::inst( 'nirctmh.start_at' ),
			Field::inst( 'nirctmh.finish_at' ),
			Field::inst( 'nirctmh.is_defaultprogram' ),
			Field::inst( 'nirctmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_nirctmh'] == 0){
		$editor
			->where( 'nirctmh.transaction_state', -9, '<>');
	}
	
	include( "nirctmh_extra.php" );

	// BEGIN log
	$nama_table = 'nirctmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>