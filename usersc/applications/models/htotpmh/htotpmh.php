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
	
	$editor = Editor::inst( $db, 'htotpmh' )
		->debug(true)
		->fields(
			Field::inst( 'htotpmh.id' ),
			Field::inst( 'htotpmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'htotpmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'htotpmh.keterangan' ),
			Field::inst( 'htotpmh.created_by' ),
			Field::inst( 'htotpmh.transaction_state' ),
			Field::inst( 'htotpmh.approval_state' ),
			Field::inst( 'htotpmh.start_at' ),
			Field::inst( 'htotpmh.finish_at' ),
			Field::inst( 'htotpmh.is_defaultprogram' ),
			Field::inst( 'htotpmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_htotpmh'] == 0){
		$editor
			->where( 'htotpmh.transaction_state', -9, '<>');
	}
	
	include( "htotpmh_extra.php" );

	// BEGIN log
	$nama_table = 'htotpmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>