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
	
	$editor = Editor::inst( $db, 'hpcxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'hpcxxmh.id' ),
			Field::inst( 'hpcxxmh.id_gtbrlsh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hpcxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hpcxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hpcxxmh.keterangan' ),
			Field::inst( 'hpcxxmh.created_by' ),
			Field::inst( 'hpcxxmh.transaction_state' ),
			Field::inst( 'hpcxxmh.approval_state' ),
			Field::inst( 'hpcxxmh.start_at' ),
			Field::inst( 'hpcxxmh.finish_at' ),
			Field::inst( 'hpcxxmh.is_defaultprogram' ),
			Field::inst( 'hpcxxmh.is_nextprocess' ),
			Field::inst( 'hpcxxmh.jenis' ),
			Field::inst( 'hpcxxmh.periode' ),
			Field::inst( 'hpcxxmh.nominal' ),
			Field::inst( 'hpcxxmh.is_lain' ),
			Field::inst( 'hpcxxmh.is_fix' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hpcxxmh'] == 0){
		$editor
			->where( 'hpcxxmh.transaction_state', -9, '<>');
	}
	
	include( "hpcxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'hpcxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>