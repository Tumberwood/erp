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
	
	$editor = Editor::inst( $db, 'hesxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'hesxxmh.id' ),
			Field::inst( 'hesxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hesxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hesxxmh.keterangan' ),
			Field::inst( 'hesxxmh.created_by' ),
			Field::inst( 'hesxxmh.transaction_state' ),
			Field::inst( 'hesxxmh.approval_state' ),
			Field::inst( 'hesxxmh.start_at' ),
			Field::inst( 'hesxxmh.finish_at' ),
			Field::inst( 'hesxxmh.is_defaultprogram' ),
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hesxxmh'] == 0){
		$editor
			->where( 'hesxxmh.transaction_state', -9, '<>');
	}
	
	include( "hesxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'hesxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>