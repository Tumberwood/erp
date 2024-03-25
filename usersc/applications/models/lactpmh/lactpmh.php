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
	
	$editor = Editor::inst( $db, 'lactpmh' )
		->debug(true)
		->fields(
			Field::inst( 'lactpmh.id' ),
			Field::inst( 'lactpmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'lactpmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'lactpmh.keterangan' ),
			Field::inst( 'lactpmh.created_by' ),
			Field::inst( 'lactpmh.transaction_state' ),
			Field::inst( 'lactpmh.approval_state' ),
			Field::inst( 'lactpmh.start_at' ),
			Field::inst( 'lactpmh.finish_at' ),
			Field::inst( 'lactpmh.is_defaultprogram' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_lactpmh'] == 0){
		$editor
			->where( 'lactpmh.transaction_state', -9, '<>');
	}
	
	include( "lactpmh_extra.php" );

	// BEGIN log
	$nama_table = 'lactpmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>