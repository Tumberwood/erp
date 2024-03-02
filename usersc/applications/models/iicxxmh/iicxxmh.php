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
	
	$editor = Editor::inst( $db, 'iicxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'iicxxmh.id' ),
			Field::inst( 'iicxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'iicxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'iicxxmh.keterangan' ),
			Field::inst( 'iicxxmh.created_by' ),
			Field::inst( 'iicxxmh.transaction_state' ),
			Field::inst( 'iicxxmh.approval_state' ),
			Field::inst( 'iicxxmh.start_at' ),
			Field::inst( 'iicxxmh.finish_at' ),
			Field::inst( 'iicxxmh.is_defaultprogram' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_iicxxmh'] == 0){
		$editor
			->where( 'iicxxmh.transaction_state', -9, '<>');
	}
	
	include( "iicxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'iicxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>