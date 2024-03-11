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
	
	$editor = Editor::inst( $db, 'iibxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'iibxxmh.id' ),
			Field::inst( 'iibxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'iibxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'iibxxmh.keterangan' ),
			Field::inst( 'iibxxmh.created_by' ),
			Field::inst( 'iibxxmh.transaction_state' ),
			Field::inst( 'iibxxmh.approval_state' ),
			Field::inst( 'iibxxmh.start_at' ),
			Field::inst( 'iibxxmh.finish_at' ),
			Field::inst( 'iibxxmh.is_defaultprogram' ),
			Field::inst( 'iibxxmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_iibxxmh'] == 0){
		$editor
			->where( 'iibxxmh.transaction_state', -9, '<>');
	}
	
	include( "iibxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'iibxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>