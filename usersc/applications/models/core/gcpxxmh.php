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
	
	$editor = Editor::inst( $db, 'gcpxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'gcpxxmh.id' ),
			Field::inst( 'gcpxxmh.id_gbuxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'gcpxxmh.id_gctxxmh' )
                ->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'gcpxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'gcpxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'gcpxxmh.keterangan' ),
			Field::inst( 'gcpxxmh.created_by' ),
			Field::inst( 'gcpxxmh.transaction_state' ),
			Field::inst( 'gcpxxmh.approval_state' ),
			Field::inst( 'gcpxxmh.start_at' ),
			Field::inst( 'gcpxxmh.finish_at' ),
			Field::inst( 'gcpxxmh.is_defaultprogram' ),
			Field::inst( 'gcpxxmh.alamat' ),
			Field::inst( 'gcpxxmh.npwp' ),
			Field::inst( 'gcpxxmh.klu' ),

            Field::inst( 'gctxxmh.nama' ),
            Field::inst( 'gbuxxmh.kode' )
		)
		->leftJoin( 'gbuxxmh','gbuxxmh.id','=','gcpxxmh.id_gbuxxmh' )
        ->leftJoin( 'gctxxmh','gctxxmh.id','=','gcpxxmh.id_gctxxmh' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_gcpxxmh'] == 0){
		$editor
			->where( 'gcpxxmh.transaction_state', -9, '<>');
	}
	
	// include( "gcpxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'gcpxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>