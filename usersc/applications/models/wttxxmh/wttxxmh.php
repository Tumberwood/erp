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
	
	$editor = Editor::inst( $db, 'wttxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'wttxxmh.id' ),
			Field::inst( 'wttxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'wttxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'wttxxmh.keterangan' ),
			Field::inst( 'wttxxmh.created_by' ),
			Field::inst( 'wttxxmh.transaction_state' ),
			Field::inst( 'wttxxmh.approval_state' ),
			Field::inst( 'wttxxmh.start_at' ),
			Field::inst( 'wttxxmh.finish_at' ),
			Field::inst( 'wttxxmh.is_defaultprogram' ),
			Field::inst( 'wttxxmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_wttxxmh'] == 0){
		$editor
			->where( 'wttxxmh.transaction_state', -9, '<>');
	}
	
	include( "wttxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'wttxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>