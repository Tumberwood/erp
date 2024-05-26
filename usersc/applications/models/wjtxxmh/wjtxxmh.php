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
	
	$editor = Editor::inst( $db, 'wjtxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'wjtxxmh.id' ),
			Field::inst( 'wjtxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'wjtxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'wjtxxmh.keterangan' ),
			Field::inst( 'wjtxxmh.created_by' ),
			Field::inst( 'wjtxxmh.transaction_state' ),
			Field::inst( 'wjtxxmh.approval_state' ),
			Field::inst( 'wjtxxmh.start_at' ),
			Field::inst( 'wjtxxmh.finish_at' ),
			Field::inst( 'wjtxxmh.is_defaultprogram' ),
			Field::inst( 'wjtxxmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_wjtxxmh'] == 0){
		$editor
			->where( 'wjtxxmh.transaction_state', -9, '<>');
	}
	
	include( "wjtxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'wjtxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>