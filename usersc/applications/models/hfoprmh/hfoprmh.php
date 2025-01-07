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
	
	$editor = Editor::inst( $db, 'hfoprmh' )
		->debug(true)
		->fields(
			Field::inst( 'hfoprmh.id' ),
			Field::inst( 'hfoprmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hfoprmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hfoprmh.keterangan' ),
			Field::inst( 'hfoprmh.created_by' ),
			Field::inst( 'hfoprmh.transaction_state' ),
			Field::inst( 'hfoprmh.approval_state' ),
			Field::inst( 'hfoprmh.start_at' ),
			Field::inst( 'hfoprmh.finish_at' ),
			Field::inst( 'hfoprmh.is_defaultprogram' ),
			Field::inst( 'hfoprmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hfoprmh'] == 0){
		$editor
			->where( 'hfoprmh.transaction_state', -9, '<>');
	}
	
	include( "hfoprmh_extra.php" );

	// BEGIN log
	$nama_table = 'hfoprmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>