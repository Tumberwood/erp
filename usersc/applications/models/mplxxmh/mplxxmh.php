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
	
	$editor = Editor::inst( $db, 'mplxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'mplxxmh.id' ),
			Field::inst( 'mplxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'mplxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'mplxxmh.keterangan' ),
			Field::inst( 'mplxxmh.created_by' ),
			Field::inst( 'mplxxmh.transaction_state' ),
			Field::inst( 'mplxxmh.approval_state' ),
			Field::inst( 'mplxxmh.start_at' ),
			Field::inst( 'mplxxmh.finish_at' ),
			Field::inst( 'mplxxmh.is_defaultprogram' ),
			Field::inst( 'mplxxmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_mplxxmh'] == 0){
		$editor
			->where( 'mplxxmh.transaction_state', -9, '<>');
	}
	
	include( "mplxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'mplxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>