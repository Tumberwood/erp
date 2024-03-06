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
	
	$editor = Editor::inst( $db, 'wpmxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'wpmxxmh.id' ),
			Field::inst( 'wpmxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'wpmxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'wpmxxmh.keterangan' ),
			Field::inst( 'wpmxxmh.created_by' ),
			Field::inst( 'wpmxxmh.transaction_state' ),
			Field::inst( 'wpmxxmh.approval_state' ),
			Field::inst( 'wpmxxmh.start_at' ),
			Field::inst( 'wpmxxmh.finish_at' ),
			Field::inst( 'wpmxxmh.is_defaultprogram' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_wpmxxmh'] == 0){
		$editor
			->where( 'wpmxxmh.transaction_state', -9, '<>');
	}
	
	include( "wpmxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'wpmxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>