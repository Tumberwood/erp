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
	
	$editor = Editor::inst( $db, 'grlxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'grlxxmh.id' ),
			Field::inst( 'grlxxmh.id_gbuxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'grlxxmh.id_gctxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'grlxxmh.id_gpvxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'grlxxmh.id_fpytmmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'grlxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'grlxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'grlxxmh.keterangan' ),
			Field::inst( 'grlxxmh.created_by' ),
			Field::inst( 'grlxxmh.transaction_state' ),
			Field::inst( 'grlxxmh.approval_state' ),
			Field::inst( 'grlxxmh.start_at' ),
			Field::inst( 'grlxxmh.finish_at' ),
			Field::inst( 'grlxxmh.is_defaultprogram' ),
			Field::inst( 'grlxxmh.alamat' ),
			Field::inst( 'grlxxmh.telepon' ),
			Field::inst( 'grlxxmh.whatsapp' ),
			Field::inst( 'grlxxmh.fax' ),
			Field::inst( 'grlxxmh.email' ),
			Field::inst( 'grlxxmh.nik' ),
			Field::inst( 'grlxxmh.npwp' ),
			Field::inst( 'grlxxmh.kredit_limit' ),
			Field::inst( 'grlxxmh.tag' ),
			Field::inst( 'grlxxmh.default_pembayaran' ),
			Field::inst( 'grlxxmh.is_pkp' ),
			Field::inst( 'grlxxmh.is_customer' )
				->setValue(1)
				->set( Field::SET_CREATE ),

			Field::inst( 'gctxxmh.nama' ),
			Field::inst( 'gpvxxmh.nama' ),
			Field::inst( 'fpytmmh.nama' )
		)
		->leftJoin( 'gctxxmh','gctxxmh.id','=','grlxxmh.id_gctxxmh' )
		->leftJoin( 'gpvxxmh','gpvxxmh.id','=','grlxxmh.id_gpvxxmh' )
		->leftJoin( 'fpytmmh','fpytmmh.id','=','grlxxmh.id_fpytmmh' )
		->where( 'grlxxmh.is_customer', 1 )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_grlxxmh'] == 0){
		$editor
			->where( 'grlxxmh.transaction_state', -9, '<>');
	}
	
	include( "scuxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'grlxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>