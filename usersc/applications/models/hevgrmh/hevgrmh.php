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
	
	$editor = Editor::inst( $db, 'hevgrmh' )
		->debug(true)
		->fields(
			Field::inst( 'hevgrmh.id' ),
			Field::inst( 'hevgrmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hevgrmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hevgrmh.keterangan' ),
			Field::inst( 'hevgrmh.created_by' ),
			Field::inst( 'hevgrmh.transaction_state' ),
			Field::inst( 'hevgrmh.approval_state' ),
			Field::inst( 'hevgrmh.start_at' ),
			Field::inst( 'hevgrmh.finish_at' ),
			Field::inst( 'hevgrmh.is_defaultprogram' ),
			Field::inst( 'hevgrmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hevgrmh'] == 0){
		$editor
			->where( 'hevgrmh.transaction_state', -9, '<>');
	}
	
	include( "hevgrmh_extra.php" );

	// BEGIN log
	$nama_table = 'hevgrmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>