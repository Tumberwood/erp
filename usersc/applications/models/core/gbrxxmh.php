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
	
	$editor = Editor::inst( $db, 'gbrxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'gbrxxmh.id' ),
			Field::inst( 'gbrxxmh.id_gcpxxmh' )
                ->setFormatter( Format::ifEmpty( 0 ) ),
            Field::inst( 'gbrxxmh.id_gctxxmh' )
                ->setFormatter( Format::ifEmpty( 0 ) ),
            Field::inst( 'gbrxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'gbrxxmh.nama' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'gbrxxmh.keterangan' ),
			Field::inst( 'gbrxxmh.created_by' ),
			Field::inst( 'gbrxxmh.transaction_state' ),
			Field::inst( 'gbrxxmh.approval_state' ),
			Field::inst( 'gbrxxmh.start_at' ),
			Field::inst( 'gbrxxmh.finish_at' ),
			Field::inst( 'gbrxxmh.is_defaultprogram' ),
			Field::inst( 'gbrxxmh.is_nextprocess' ),
			
			
			Field::inst( 'gbrxxmh.alamat' ),
			Field::inst( 'gbrxxmh.lat' ),
			Field::inst( 'gbrxxmh.lng' ),
			
            Field::inst( 'gcpxxmh.nama' ),
			Field::inst( 'gctxxmh.nama' )
		)
        ->leftJoin( 'gcpxxmh','gcpxxmh.id','=','gbrxxmh.id_gcpxxmh' )
        ->leftJoin( 'gctxxmh','gctxxmh.id','=','gbrxxmh.id_gctxxmh' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_gbrxxmh'] == 0){
		$editor
			->where( 'gbrxxmh.transaction_state', -9, '<>');
	}
	
	// include( "gbrxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'gbrxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>