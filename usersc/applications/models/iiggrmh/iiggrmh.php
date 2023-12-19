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
	
	$editor = Editor::inst( $db, 'iiggrmh' )
		->debug(true)
		->fields(
			Field::inst( 'iiggrmh.id' ),
			Field::inst( 'iiggrmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'iiggrmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'iiggrmh.keterangan' ),
			Field::inst( 'iiggrmh.created_by' ),
			Field::inst( 'iiggrmh.transaction_state' ),
			Field::inst( 'iiggrmh.approval_state' ),
			Field::inst( 'iiggrmh.start_at' ),
			Field::inst( 'iiggrmh.finish_at' ),
			Field::inst( 'iiggrmh.is_defaultprogram' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_iiggrmh'] == 0){
		$editor
			->where( 'iiggrmh.transaction_state', -9, '<>');
	}
	
	include( "iiggrmh_extra.php" );

	// BEGIN log
	$nama_table = 'iiggrmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>