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
	
	$editor = Editor::inst( $db, 'hosxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'hosxxmh.id' ),
			Field::inst( 'hosxxmh.id_hodxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hosxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hosxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hosxxmh.keterangan' ),
			Field::inst( 'hosxxmh.created_by' ),
			Field::inst( 'hosxxmh.transaction_state' ),
			Field::inst( 'hosxxmh.approval_state' ),
			Field::inst( 'hosxxmh.start_at' ),
			Field::inst( 'hosxxmh.finish_at' ),
			Field::inst( 'hosxxmh.is_defaultprogram' ),
			Field::inst( 'hosxxmh.is_nextprocess' ),

			Field::inst( 'hodxxmh.nama' )
		)
		->leftJoin( 'hodxxmh','hodxxmh.id','=','hosxxmh.id_hodxxmh' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hosxxmh'] == 0){
		$editor
			->where( 'hosxxmh.transaction_state', -9, '<>');
	}
	
	include( "hosxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'hosxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>