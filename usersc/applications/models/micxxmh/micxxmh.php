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
	
	$editor = Editor::inst( $db, 'micxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'micxxmh.id' ),
			Field::inst( 'micxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'micxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'micxxmh.keterangan' ),
			Field::inst( 'micxxmh.created_by' ),
			Field::inst( 'micxxmh.transaction_state' ),
			Field::inst( 'micxxmh.approval_state' ),
			Field::inst( 'micxxmh.start_at' ),
			Field::inst( 'micxxmh.finish_at' ),
			Field::inst( 'micxxmh.is_defaultprogram' ),
			Field::inst( 'micxxmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_micxxmh'] == 0){
		$editor
			->where( 'micxxmh.transaction_state', -9, '<>');
	}
	
	include( "micxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'micxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>