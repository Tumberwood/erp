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
	
	$editor = Editor::inst( $db, 'gaptpmh' )
		->debug(true)
		->fields(
			Field::inst( 'gaptpmh.id' ),
			Field::inst( 'gaptpmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'gaptpmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'gaptpmh.keterangan' ),
			Field::inst( 'gaptpmh.created_by' ),
			Field::inst( 'gaptpmh.transaction_state' ),
			Field::inst( 'gaptpmh.approval_state' ),
			Field::inst( 'gaptpmh.start_at' ),
			Field::inst( 'gaptpmh.is_nextprocess' ),
			Field::inst( 'gaptpmh.finish_at' ),
			Field::inst( 'gaptpmh.is_defaultprogram' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_gaptpmh'] == 0){
		$editor
			->where( 'gaptpmh.transaction_state', -9, '<>');
	}
	
	include( "gaptpmh_extra.php" );

	// BEGIN log
	$nama_table = 'gaptpmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>