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
	
	$editor = Editor::inst( $db, 'fpytmmh' )
		->debug(true)
		->fields(
			Field::inst( 'fpytmmh.id' ),
			Field::inst( 'fpytmmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'fpytmmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'fpytmmh.keterangan' ),
			Field::inst( 'fpytmmh.created_by' ),
			Field::inst( 'fpytmmh.transaction_state' ),
			Field::inst( 'fpytmmh.approval_state' ),
			Field::inst( 'fpytmmh.start_at' ),
			Field::inst( 'fpytmmh.finish_at' ),
			Field::inst( 'fpytmmh.is_defaultprogram' ),
			Field::inst( 'fpytmmh.is_default' ),
			Field::inst( 'fpytmmh.jatuh_tempo' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_fpytmmh'] == 0){
		$editor
			->where( 'fpytmmh.transaction_state', -9, '<>');
	}
	
	include( "fpytmmh_extra.php" );

	// BEGIN log
	$nama_table = 'fpytmmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>