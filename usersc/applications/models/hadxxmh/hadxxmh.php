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
	
	$editor = Editor::inst( $db, 'hadxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'hadxxmh.id' ),
			Field::inst( 'hadxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hadxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hadxxmh.keterangan' ),
			Field::inst( 'hadxxmh.created_by' ),
			Field::inst( 'hadxxmh.transaction_state' ),
			Field::inst( 'hadxxmh.approval_state' ),
			Field::inst( 'hadxxmh.start_at' ),
			Field::inst( 'hadxxmh.finish_at' ),
			Field::inst( 'hadxxmh.is_defaultprogram' ),
			Field::inst( 'hadxxmh.is_nextprocess' ),

			Field::inst( 'hadxxmh.masa_berlaku_hari' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hadxxmh'] == 0){
		$editor
			->where( 'hadxxmh.transaction_state', -9, '<>');
	}
	
	include( "hadxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'hadxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>