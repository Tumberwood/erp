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
	
	$editor = Editor::inst( $db, 'hevxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'hevxxmh.id' ),
			Field::inst( 'hevxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hevxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hevxxmh.keterangan' ),
			Field::inst( 'hevxxmh.created_by' ),
			Field::inst( 'hevxxmh.transaction_state' ),
			Field::inst( 'hevxxmh.approval_state' ),
			Field::inst( 'hevxxmh.start_at' ),
			Field::inst( 'hevxxmh.finish_at' ),
			Field::inst( 'hevxxmh.is_defaultprogram' ),
			Field::inst( 'hevxxmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hevxxmh'] == 0){
		$editor
			->where( 'hevxxmh.transaction_state', -9, '<>');
	}
	
	include( "hevxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'hevxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>