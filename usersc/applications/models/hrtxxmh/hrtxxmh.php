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
	
	$editor = Editor::inst( $db, 'hrtxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'hrtxxmh.id' ),
			Field::inst( 'hrtxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hrtxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hrtxxmh.keterangan' ),
			Field::inst( 'hrtxxmh.created_by' ),
			Field::inst( 'hrtxxmh.transaction_state' ),
			Field::inst( 'hrtxxmh.approval_state' ),
			Field::inst( 'hrtxxmh.start_at' ),
			Field::inst( 'hrtxxmh.finish_at' ),
			Field::inst( 'hrtxxmh.is_defaultprogram' ),
			Field::inst( 'hrtxxmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hrtxxmh'] == 0){
		$editor
			->where( 'hrtxxmh.transaction_state', -9, '<>');
	}
	
	include( "hrtxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'hrtxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>