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
	
	$editor = Editor::inst( $db, 'gctxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'gctxxmh.id' ),
			Field::inst( 'gctxxmh.id_gpvxxmh' )
                ->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'gctxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'gctxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'gctxxmh.keterangan' ),
			Field::inst( 'gctxxmh.created_by' ),
			Field::inst( 'gctxxmh.transaction_state' ),
			Field::inst( 'gctxxmh.approval_state' ),
			Field::inst( 'gctxxmh.start_at' ),
			Field::inst( 'gctxxmh.finish_at' ),
			Field::inst( 'gctxxmh.is_defaultprogram' ),
			Field::inst( 'gctxxmh.is_nextprocess' ),

			Field::inst( 'gpvxxmh.nama' )
		)
        ->leftJoin( 'gpvxxmh','gpvxxmh.id','=','gctxxmh.id_gpvxxmh' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_gctxxmh'] == 0){
		$editor
			->where( 'gctxxmh.transaction_state', -9, '<>');
	}
	
	// include( "gctxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'gctxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>