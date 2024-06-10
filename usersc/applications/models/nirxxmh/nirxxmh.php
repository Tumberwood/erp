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
	
	$editor = Editor::inst( $db, 'nirxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'nirxxmh.id' ),
			Field::inst( 'nirxxmh.id_nibxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'nirxxmh.id_nirctmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'nirxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'nirxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'nirxxmh.keterangan' ),
			Field::inst( 'nirxxmh.created_by' ),
			Field::inst( 'nirxxmh.transaction_state' ),
			Field::inst( 'nirxxmh.approval_state' ),
			Field::inst( 'nirxxmh.start_at' ),
			Field::inst( 'nirxxmh.finish_at' ),
			Field::inst( 'nirxxmh.is_defaultprogram' ),
			Field::inst( 'nirxxmh.is_nextprocess' ),

			Field::inst( 'nibxxmh.nama' ),
			Field::inst( 'nirctmh.nama' )
		)
		->leftJoin( 'nibxxmh','nibxxmh.id','=','nirxxmh.id_nibxxmh' )
		->leftJoin( 'nirctmh','nirctmh.id','=','nirxxmh.id_nirctmh' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_nirxxmh'] == 0){
		$editor
			->where( 'nirxxmh.transaction_state', -9, '<>');
	}
	
	include( "nirxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'nirxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>