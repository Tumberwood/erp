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
	
	$editor = Editor::inst( $db, 'lacxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'lacxxmh.id' ),
			Field::inst( 'lacxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'lacxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'lacxxmh.keterangan' ),
			Field::inst( 'lacxxmh.created_by' ),
			Field::inst( 'lacxxmh.transaction_state' ),
			Field::inst( 'lacxxmh.approval_state' ),
			Field::inst( 'lacxxmh.start_at' ),
			Field::inst( 'lacxxmh.is_nextprocess' ),
			Field::inst( 'lacxxmh.finish_at' ),
			Field::inst( 'lacxxmh.is_defaultprogram' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_lacxxmh'] == 0){
		$editor
			->where( 'lacxxmh.transaction_state', -9, '<>');
	}
	
	include( "lacxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'lacxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>