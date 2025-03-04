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
	
	$editor = Editor::inst( $db, 'dd_manifest' )
		->debug(true)
		->fields(
			Field::inst( 'dd_manifest.id' ),
			Field::inst( 'dd_manifest.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'dd_manifest.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'dd_manifest.keterangan' ),
			Field::inst( 'dd_manifest.created_by' ),
			Field::inst( 'dd_manifest.transaction_state' ),
			Field::inst( 'dd_manifest.approval_state' ),
			Field::inst( 'dd_manifest.start_at' ),
			Field::inst( 'dd_manifest.finish_at' ),
			Field::inst( 'dd_manifest.is_defaultprogram' ),
			Field::inst( 'dd_manifest.is_nextprocess' ),

			Field::inst( 'dd_manifest.nama_pengirim' ),
			Field::inst( 'dd_manifest.alamat_pengirim' ),
			Field::inst( 'dd_manifest.telepon_pengirim' ),
			Field::inst( 'dd_manifest.passport_pengirim' ),
			Field::inst( 'dd_manifest.status_pmi' ),
			Field::inst( 'dd_manifest.nama_penerima' ),
			Field::inst( 'dd_manifest.alamat_penerima' ),
			Field::inst( 'dd_manifest.koli_ke' ),
			Field::inst( 'dd_manifest.ukuran' ),
			Field::inst( 'dd_manifest.berat' ),
			Field::inst( 'dd_manifest.uraian_barang' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_dd_manifest'] == 0){
		$editor
			->where( 'dd_manifest.transaction_state', -9, '<>');
	}
	
	include( "dd_manifest_extra.php" );

	// BEGIN log
	$nama_table = 'dd_manifest';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>