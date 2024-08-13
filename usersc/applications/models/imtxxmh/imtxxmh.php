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
	
	$editor = Editor::inst( $db, 'imtxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'imtxxmh.id' ),
			Field::inst( 'imtxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'imtxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'imtxxmh.keterangan' ),
			Field::inst( 'imtxxmh.created_by' ),
			Field::inst( 'imtxxmh.transaction_state' ),
			Field::inst( 'imtxxmh.approval_state' ),
			Field::inst( 'imtxxmh.start_at' ),
			Field::inst( 'imtxxmh.finish_at' ),
			Field::inst( 'imtxxmh.is_defaultprogram' ),
			Field::inst( 'imtxxmh.is_nextprocess' ),
			Field::inst( 'imtxxmh.movement_type' ),
			Field::inst( 'imtxxmh.module' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_imtxxmh'] == 0){
		$editor
			->where( 'imtxxmh.transaction_state', -9, '<>');
	}
	
	include( "imtxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'imtxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>