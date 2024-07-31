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
	
	$editor = Editor::inst( $db, 'wloxxmh_upload' )
		->debug(true)
		->fields(
			Field::inst( 'wloxxmh_upload.id' ),
			Field::inst( 'wloxxmh_upload.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'wloxxmh_upload.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'wloxxmh_upload.keterangan' ),
			Field::inst( 'wloxxmh_upload.created_by' ),
			Field::inst( 'wloxxmh_upload.transaction_state' ),
			Field::inst( 'wloxxmh_upload.approval_state' ),
			Field::inst( 'wloxxmh_upload.start_at' ),
			Field::inst( 'wloxxmh_upload.finish_at' ),
			Field::inst( 'wloxxmh_upload.is_nextprocess' ),
			Field::inst( 'wloxxmh_upload.is_defaultprogram' ),
			Field::inst( 'wloxxmh_upload.company' ),
			Field::inst( 'wloxxmh_upload.cabang' ),
			Field::inst( 'wloxxmh_upload.warehouse' ),
		)
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_wloxxmh_upload'] == 0){
		$editor
			->where( 'wloxxmh_upload.transaction_state', -9, '<>');
	}
	
	include( "wloxxmh_upload_extra.php" );

	// BEGIN log
	$nama_table = 'wloxxmh_upload';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>