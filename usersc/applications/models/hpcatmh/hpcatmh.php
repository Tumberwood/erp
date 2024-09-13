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
	
	$editor = Editor::inst( $db, 'hpcatmh' )
		->debug(true)
		->fields(
			Field::inst( 'hpcatmh.id' ),
			Field::inst( 'hpcatmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hpcatmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hpcatmh.keterangan' ),
			Field::inst( 'hpcatmh.created_by' ),
			Field::inst( 'hpcatmh.transaction_state' ),
			Field::inst( 'hpcatmh.approval_state' ),
			Field::inst( 'hpcatmh.start_at' ),
			Field::inst( 'hpcatmh.finish_at' ),
			Field::inst( 'hpcatmh.is_nextprocess' ),
			Field::inst( 'hpcatmh.is_defaultprogram' ),
			Field::inst( 'hpcatmh.nominal_awal' ),
			Field::inst( 'hpcatmh.nominal_akhir' ),
			Field::inst( 'hpcatmh.persen' ),
			Field::inst( 'hpcatmh.kategori' ),
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hpcatmh'] == 0){
		$editor
			->where( 'hpcatmh.transaction_state', -9, '<>');
	}
	
	include( "hpcatmh_extra.php" );

	// BEGIN log
	$nama_table = 'hpcatmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>