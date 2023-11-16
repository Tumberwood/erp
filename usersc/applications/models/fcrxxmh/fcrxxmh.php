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
	
	$editor = Editor::inst( $db, 'fcrxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'fcrxxmh.id' ),
			Field::inst( 'fcrxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'fcrxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'fcrxxmh.keterangan' ),
			Field::inst( 'fcrxxmh.created_by' ),
			Field::inst( 'fcrxxmh.transaction_state' ),
			Field::inst( 'fcrxxmh.approval_state' ),
			Field::inst( 'fcrxxmh.start_at' ),
			Field::inst( 'fcrxxmh.finish_at' ),
			Field::inst( 'fcrxxmh.is_defaultprogram' ),
			Field::inst( 'fcrxxmh.simbol' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_fcrxxmh'] == 0){
		$editor
			->where( 'fcrxxmh.transaction_state', -9, '<>');
	}
	
	include( "fcrxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'fcrxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>