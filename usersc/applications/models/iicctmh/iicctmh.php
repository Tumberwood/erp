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
	
	$editor = Editor::inst( $db, 'iicctmh' )
		->debug(true)
		->fields(
			Field::inst( 'iicctmh.id' ),
			Field::inst( 'iicctmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'iicctmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'iicctmh.keterangan' ),
			Field::inst( 'iicctmh.created_by' ),
			Field::inst( 'iicctmh.transaction_state' ),
			Field::inst( 'iicctmh.approval_state' ),
			Field::inst( 'iicctmh.start_at' ),
			Field::inst( 'iicctmh.finish_at' ),
			Field::inst( 'iicctmh.is_defaultprogram' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_iicctmh'] == 0){
		$editor
			->where( 'iicctmh.transaction_state', -9, '<>');
	}
	
	include( "iicctmh_extra.php" );

	// BEGIN log
	$nama_table = 'iicctmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>