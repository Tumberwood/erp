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
	
	$editor = Editor::inst( $db, 'hactpmh' )
		->debug(true)
		->fields(
			Field::inst( 'hactpmh.id' ),
			Field::inst( 'hactpmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hactpmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hactpmh.keterangan' ),
			Field::inst( 'hactpmh.created_by' ),
			Field::inst( 'hactpmh.transaction_state' ),
			Field::inst( 'hactpmh.approval_state' ),
			Field::inst( 'hactpmh.start_at' ),
			Field::inst( 'hactpmh.finish_at' ),
			Field::inst( 'hactpmh.is_defaultprogram' ),
			Field::inst( 'hactpmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hactpmh'] == 0){
		$editor
			->where( 'hactpmh.transaction_state', -9, '<>');
	}
	
	include( "hactpmh_extra.php" );

	// BEGIN log
	$nama_table = 'hactpmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>