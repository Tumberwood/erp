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
	
	$editor = Editor::inst( $db, 'rmsxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'rmsxxmh.id' ),
			Field::inst( 'rmsxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'rmsxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'rmsxxmh.keterangan' ),
			Field::inst( 'rmsxxmh.created_by' ),
			Field::inst( 'rmsxxmh.transaction_state' ),
			Field::inst( 'rmsxxmh.approval_state' ),
			Field::inst( 'rmsxxmh.start_at' ),
			Field::inst( 'rmsxxmh.finish_at' ),
			Field::inst( 'rmsxxmh.is_defaultprogram' ),
			Field::inst( 'rmsxxmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_rmsxxmh'] == 0){
		$editor
			->where( 'rmsxxmh.transaction_state', -9, '<>');
	}
	
	include( "rmsxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'rmsxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>