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
	
	$editor = Editor::inst( $db, 'hprstmh' )
		->debug(true)
		->fields(
			Field::inst( 'hprstmh.id' ),
			Field::inst( 'hprstmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hprstmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hprstmh.keterangan' ),
			Field::inst( 'hprstmh.created_by' ),
			Field::inst( 'hprstmh.transaction_state' ),
			Field::inst( 'hprstmh.approval_state' ),
			Field::inst( 'hprstmh.start_at' ),
			Field::inst( 'hprstmh.finish_at' ),
			Field::inst( 'hprstmh.is_defaultprogram' ),
			Field::inst( 'hprstmh.is_nextprocess' ),
			Field::inst( 'hprstmh.jenis' ),
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hprstmh'] == 0){
		$editor
			->where( 'hprstmh.transaction_state', -9, '<>');
	}
	
	include( "hprstmh_extra.php" );

	// BEGIN log
	$nama_table = 'hprstmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>