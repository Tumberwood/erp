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
	
	$editor = Editor::inst( $db, 'scuxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'scuxxmh.id' ),
			Field::inst( 'scuxxmh.id_gbuxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'scuxxmh.id_gctxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'scuxxmh.id_gpvxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'scuxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'scuxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'scuxxmh.keterangan' ),
			Field::inst( 'scuxxmh.created_by' ),
			Field::inst( 'scuxxmh.transaction_state' ),
			Field::inst( 'scuxxmh.approval_state' ),
			Field::inst( 'scuxxmh.start_at' ),
			Field::inst( 'scuxxmh.finish_at' ),
			Field::inst( 'scuxxmh.is_defaultprogram' ),
			Field::inst( 'scuxxmh.alamat' ),
			Field::inst( 'scuxxmh.telepon' ),
			Field::inst( 'scuxxmh.whatsapp' ),
			Field::inst( 'scuxxmh.fax' ),
			Field::inst( 'scuxxmh.email' ),
			Field::inst( 'scuxxmh.nik' ),
			Field::inst( 'scuxxmh.npwp' ),
			Field::inst( 'scuxxmh.kredit_limit' ),
			Field::inst( 'scuxxmh.tag' ),
			Field::inst( 'scuxxmh.default_pembayaran' ),
			Field::inst( 'scuxxmh.is_pkp' ),
			Field::inst( 'gctxxmh.nama' ),
			Field::inst( 'gpvxxmh.nama' )
		)
		->leftJoin( 'gctxxmh','gctxxmh.id','=','scuxxmh.id_gctxxmh' )
		->leftJoin( 'gpvxxmh','gpvxxmh.id','=','scuxxmh.id_gpvxxmh' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_scuxxmh'] == 0){
		$editor
			->where( 'scuxxmh.transaction_state', -9, '<>');
	}
	
	include( "scuxxmh_extra.php" );
	include( "../../../helpers/kode_fn_generate_confirm.php" );

	// BEGIN log
	$nama_table = 'scuxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>