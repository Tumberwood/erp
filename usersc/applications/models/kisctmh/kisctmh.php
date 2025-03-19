<?php
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../helpers/hakakses_s_fn.php" );
	include_once( "../../../helpers/SolusiIndonesiaUtilities.php" );
	
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
	
	$editor = Editor::inst( $db, 'kisctmh' )
		->debug(true)
		->fields(
			Field::inst( 'kisctmh.id' ),
			Field::inst( 'kisctmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'kisctmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'kisctmh.keterangan' ),
			Field::inst( 'kisctmh.created_by' ),
			Field::inst( 'kisctmh.transaction_state' ),
			Field::inst( 'kisctmh.approval_state' ),
			Field::inst( 'kisctmh.start_at' ),
			Field::inst( 'kisctmh.finish_at' ),
			Field::inst( 'kisctmh.is_defaultprogram' ),
			Field::inst( 'kisctmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_kisctmh'] == 0){
		$editor
			->where( 'kisctmh.transaction_state', -9, '<>');
	}
	
	include( "kisctmh_extra.php" );

	// BEGIN log
	$nama_table = 'kisctmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>