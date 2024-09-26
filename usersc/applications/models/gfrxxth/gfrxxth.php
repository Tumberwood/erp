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
	
	$editor = Editor::inst( $db, 'gfrxxth' )
		->debug(true)
		->fields(
			Field::inst( 'gfrxxth.id' ),
			Field::inst( 'gfrxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'gfrxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'gfrxxth.keterangan' ),
			Field::inst( 'gfrxxth.created_by' ),
			Field::inst( 'gfrxxth.transaction_state' ),
			Field::inst( 'gfrxxth.approval_state' ),
			Field::inst( 'gfrxxth.start_at' ),
			Field::inst( 'gfrxxth.finish_at' ),
			Field::inst( 'gfrxxth.is_nextprocess' ),
			Field::inst( 'gfrxxth.is_defaultprogram' ),
			Field::inst( 'gfrxxth.nama_tabel' ),
		);

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_gfrxxth'] == 0){
		$editor
			->where( 'gfrxxth.transaction_state', -9, '<>');
	}
	
	include( "gfrxxth_extra.php" );

	// BEGIN log
	$nama_table = 'gfrxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>