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
	
	$editor = Editor::inst( $db, 'psuxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'psuxxmh.id' ),
			Field::inst( 'psuxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'psuxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			
			Field::inst( 'psuxxmh.id_gbuxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'psuxxmh.id_gctxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'psuxxmh.id_gpvxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'psuxxmh.keterangan' ),
			Field::inst( 'psuxxmh.created_by' ),
			Field::inst( 'psuxxmh.transaction_state' ),
			Field::inst( 'psuxxmh.approval_state' ),
			Field::inst( 'psuxxmh.start_at' ),
			Field::inst( 'psuxxmh.finish_at' ),
			Field::inst( 'psuxxmh.is_defaultprogram' ),
			Field::inst( 'psuxxmh.alamat' ),
			Field::inst( 'psuxxmh.telepon' ),
			Field::inst( 'psuxxmh.whatsapp' ),
			Field::inst( 'psuxxmh.fax' ),
			Field::inst( 'psuxxmh.email' ),
			Field::inst( 'psuxxmh.nik' ),
			Field::inst( 'psuxxmh.npwp' ),
			Field::inst( 'psuxxmh.kredit_limit' ),
			Field::inst( 'psuxxmh.tag' ),
			Field::inst( 'psuxxmh.default_pembayaran' ),
			Field::inst( 'psuxxmh.is_pkp' ),
			Field::inst( 'gctxxmh.nama' ),
			Field::inst( 'gpvxxmh.nama' )
		)
		->leftJoin( 'gctxxmh','gctxxmh.id','=','psuxxmh.id_gctxxmh' )
		->leftJoin( 'gpvxxmh','gpvxxmh.id','=','psuxxmh.id_gpvxxmh' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_psuxxmh'] == 0){
		$editor
			->where( 'psuxxmh.transaction_state', -9, '<>');
	}
	
	include( "psuxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'psuxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>