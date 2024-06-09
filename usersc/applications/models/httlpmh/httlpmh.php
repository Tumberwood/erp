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
	
	$editor = Editor::inst( $db, 'httlpmh' )
		->debug(true)
		->fields(
			Field::inst( 'httlpmh.id' ),
			Field::inst( 'httlpmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'httlpmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'httlpmh.keterangan' ),
			Field::inst( 'httlpmh.created_by' ),
			Field::inst( 'httlpmh.transaction_state' ),
			Field::inst( 'httlpmh.approval_state' ),
			Field::inst( 'httlpmh.start_at' ),
			Field::inst( 'httlpmh.finish_at' ),
			Field::inst( 'httlpmh.is_defaultprogram' ),
			Field::inst( 'httlpmh.is_nextprocess' ),

			Field::inst( 'httlpmh.is_potongcuti' ),
			Field::inst( 'httlpmh.jenis' ),
			Field::inst( 'httlpmh.jenis_jam' ),
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_httlpmh'] == 0){
		$editor
			->where( 'httlpmh.transaction_state', -9, '<>');
	}
	
	include( "httlpmh_extra.php" );

	// BEGIN log
	$nama_table = 'httlpmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>