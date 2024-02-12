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
	
	$editor = Editor::inst( $db, 'ftxxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'ftxxxmh.id' ),
			Field::inst( 'ftxxxmh.kode' ),
			Field::inst( 'ftxxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'ftxxxmh.keterangan' ),
			Field::inst( 'ftxxxmh.created_by' ),
			Field::inst( 'ftxxxmh.transaction_state' ),
			Field::inst( 'ftxxxmh.approval_state' ),
			Field::inst( 'ftxxxmh.start_at' ),
			Field::inst( 'ftxxxmh.finish_at' ),
			Field::inst( 'ftxxxmh.is_defaultprogram' ),
			Field::inst( 'ftxxxmh.is_progressif' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_ftxxxmh'] == 0){
		$editor
			->where( 'ftxxxmh.transaction_state', -9, '<>');
	}
	
	include( "ftxxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'ftxxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>