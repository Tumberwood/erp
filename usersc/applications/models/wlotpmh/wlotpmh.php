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
	
	$editor = Editor::inst( $db, 'wlotpmh' )
		->debug(true)
		->fields(
			Field::inst( 'wlotpmh.id' ),
			Field::inst( 'wlotpmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'wlotpmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'wlotpmh.keterangan' ),
			Field::inst( 'wlotpmh.created_by' ),
			Field::inst( 'wlotpmh.transaction_state' ),
			Field::inst( 'wlotpmh.approval_state' ),
			Field::inst( 'wlotpmh.start_at' ),
			Field::inst( 'wlotpmh.finish_at' ),
			Field::inst( 'wlotpmh.is_nextprocess' ),
			Field::inst( 'wlotpmh.is_defaultprogram' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_wlotpmh'] == 0){
		$editor
			->where( 'wlotpmh.transaction_state', -9, '<>');
	}
	
	include( "wlotpmh_extra.php" );

	// BEGIN log
	$nama_table = 'wlotpmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>