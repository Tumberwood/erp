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
	
	$editor = Editor::inst( $db, 'gtxpkmh' )
		->debug(true)
		->fields(
			Field::inst( 'gtxpkmh.id' ),
			Field::inst( 'gtxpkmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'gtxpkmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'gtxpkmh.keterangan' ),
			Field::inst( 'gtxpkmh.created_by' ),
			Field::inst( 'gtxpkmh.transaction_state' ),
			Field::inst( 'gtxpkmh.approval_state' ),
			Field::inst( 'gtxpkmh.start_at' ),
			Field::inst( 'gtxpkmh.finish_at' ),
			Field::inst( 'gtxpkmh.is_defaultprogram' ),
			Field::inst( 'gtxpkmh.is_nextprocess' ),
			Field::inst( 'gtxpkmh.amount' ),
			Field::inst( 'gtxpkmh.kategori_kelas' ),
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_gtxpkmh'] == 0){
		$editor
			->where( 'gtxpkmh.transaction_state', -9, '<>');
	}
	
	include( "gtxpkmh_extra.php" );

	// BEGIN log
	$nama_table = 'gtxpkmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>