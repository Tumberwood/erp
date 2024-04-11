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
	
	$editor = Editor::inst( $db, 'heyxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'heyxxmh.id' ),
			Field::inst( 'heyxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'heyxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'heyxxmh.keterangan' ),
			Field::inst( 'heyxxmh.created_by' ),
			Field::inst( 'heyxxmh.transaction_state' ),
			Field::inst( 'heyxxmh.approval_state' ),
			Field::inst( 'heyxxmh.start_at' ),
			Field::inst( 'heyxxmh.finish_at' ),
			Field::inst( 'heyxxmh.is_defaultprogram' ),
			Field::inst( 'heyxxmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_heyxxmh'] == 0){
		$editor
			->where( 'heyxxmh.transaction_state', -9, '<>');
	}
	
	include( "heyxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'heyxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>