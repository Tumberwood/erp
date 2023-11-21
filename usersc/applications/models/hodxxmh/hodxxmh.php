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
	
	$editor = Editor::inst( $db, 'hodxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'hodxxmh.id' ),
			Field::inst( 'hodxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hodxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hodxxmh.keterangan' ),
			Field::inst( 'hodxxmh.created_by' ),
			Field::inst( 'hodxxmh.transaction_state' ),
			Field::inst( 'hodxxmh.approval_state' ),
			Field::inst( 'hodxxmh.start_at' ),
			Field::inst( 'hodxxmh.finish_at' ),
			Field::inst( 'hodxxmh.is_defaultprogram' )
		)
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hodxxmh'] == 0){
		$editor
			->where( 'hodxxmh.transaction_state', -9, '<>');
	}
	
	include( "hodxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'hodxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>