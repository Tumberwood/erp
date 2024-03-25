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
	
	$editor = Editor::inst( $db, 'lvtxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'lvtxxmh.id' ),
			Field::inst( 'lvtxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'lvtxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'lvtxxmh.keterangan' ),
			Field::inst( 'lvtxxmh.created_by' ),
			Field::inst( 'lvtxxmh.transaction_state' ),
			Field::inst( 'lvtxxmh.approval_state' ),
			Field::inst( 'lvtxxmh.start_at' ),
			Field::inst( 'lvtxxmh.finish_at' ),
			Field::inst( 'lvtxxmh.is_defaultprogram' ),
			Field::inst( 'lvtxxmh.golongan' ),
			Field::inst( 'lvtxxmh.tonase' ),
			Field::inst( 'lvtxxmh.kubikasi' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_lvtxxmh'] == 0){
		$editor
			->where( 'lvtxxmh.transaction_state', -9, '<>');
	}
	
	include( "lvtxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'lvtxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>