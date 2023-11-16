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
	
	$editor = Editor::inst( $db, 'gpvxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'gpvxxmh.id' ),
			Field::inst( 'gpvxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'gpvxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'gpvxxmh.keterangan' ),
			Field::inst( 'gpvxxmh.created_by' ),
			Field::inst( 'gpvxxmh.transaction_state' ),
			Field::inst( 'gpvxxmh.approval_state' ),
			Field::inst( 'gpvxxmh.start_at' ),
			Field::inst( 'gpvxxmh.finish_at' ),
			Field::inst( 'gpvxxmh.is_defaultprogram' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_gpvxxmh'] == 0){
		$editor
			->where( 'gpvxxmh.transaction_state', -9, '<>');
	}
	
	// include( "gpvxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'gpvxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>