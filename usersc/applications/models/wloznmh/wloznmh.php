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
	
	$editor = Editor::inst( $db, 'wloznmh' )
		->debug(true)
		->fields(
			Field::inst( 'wloznmh.id' ),
			Field::inst( 'wloznmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'wloznmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'wloznmh.keterangan' ),
			Field::inst( 'wloznmh.created_by' ),
			Field::inst( 'wloznmh.transaction_state' ),
			Field::inst( 'wloznmh.approval_state' ),
			Field::inst( 'wloznmh.start_at' ),
			Field::inst( 'wloznmh.finish_at' ),
			Field::inst( 'wloznmh.is_defaultprogram' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_wloznmh'] == 0){
		$editor
			->where( 'wloznmh.transaction_state', -9, '<>');
	}
	
	include( "wloznmh_extra.php" );

	// BEGIN log
	$nama_table = 'wloznmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>