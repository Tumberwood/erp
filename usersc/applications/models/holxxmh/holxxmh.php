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
	
	$editor = Editor::inst( $db, 'holxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'holxxmh.id' ),
			Field::inst( 'holxxmh.id_gcpxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'holxxmh.id_gctxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'holxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'holxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'holxxmh.keterangan' ),
			Field::inst( 'holxxmh.created_by' ),
			Field::inst( 'holxxmh.transaction_state' ),
			Field::inst( 'holxxmh.approval_state' ),
			Field::inst( 'holxxmh.start_at' ),
			Field::inst( 'holxxmh.finish_at' ),
			Field::inst( 'holxxmh.is_defaultprogram' ),
			Field::inst( 'holxxmh.is_nextprocess' ),

			Field::inst( 'holxxmh.alamat' ),
			Field::inst( 'holxxmh.telepon' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_holxxmh'] == 0){
		$editor
			->where( 'holxxmh.transaction_state', -9, '<>');
	}
	
	include( "holxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'holxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>