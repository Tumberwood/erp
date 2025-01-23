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
	
	$editor = Editor::inst( $db, 'aatxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'aatxxmh.id' ),
			Field::inst( 'aatxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'aatxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'aatxxmh.keterangan' ),
			Field::inst( 'aatxxmh.created_by' ),
			Field::inst( 'aatxxmh.transaction_state' ),
			Field::inst( 'aatxxmh.approval_state' ),
			Field::inst( 'aatxxmh.start_at' ),
			Field::inst( 'aatxxmh.finish_at' ),
			Field::inst( 'aatxxmh.is_defaultprogram' ),
			Field::inst( 'aatxxmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_aatxxmh'] == 0){
		$editor
			->where( 'aatxxmh.transaction_state', -9, '<>');
	}
	
	include( "aatxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'aatxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>