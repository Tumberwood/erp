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
	
	$editor = Editor::inst( $db, 'iimxxmh_upload' )
		->debug(true)
		->fields(
			Field::inst( 'iimxxmh_upload.id' ),
			Field::inst( 'iimxxmh_upload.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'iimxxmh_upload.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'iimxxmh_upload.keterangan' ),
			Field::inst( 'iimxxmh_upload.created_by' ),
			Field::inst( 'iimxxmh_upload.transaction_state' ),
			Field::inst( 'iimxxmh_upload.approval_state' ),
			Field::inst( 'iimxxmh_upload.start_at' ),
			Field::inst( 'iimxxmh_upload.finish_at' ),
			Field::inst( 'iimxxmh_upload.is_nextprocess' ),
			Field::inst( 'iimxxmh_upload.is_defaultprogram' ),
			Field::inst( 'iimxxmh_upload.company' ),
			Field::inst( 'iimxxmh_upload.cabang' ),
			Field::inst( 'iimxxmh_upload.satuan' ),
		)
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_iimxxmh_upload'] == 0){
		$editor
			->where( 'iimxxmh_upload.transaction_state', -9, '<>');
	}
	
	include( "iimxxmh_upload_extra.php" );

	// BEGIN log
	$nama_table = 'iimxxmh_upload';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>