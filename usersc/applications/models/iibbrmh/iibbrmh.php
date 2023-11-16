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
	
	$editor = Editor::inst( $db, 'iibbrmh' )
		->debug(true)
		->fields(
			Field::inst( 'iibbrmh.id' ),
			Field::inst( 'iibbrmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'iibbrmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'iibbrmh.keterangan' ),
			Field::inst( 'iibbrmh.created_by' ),
			Field::inst( 'iibbrmh.transaction_state' ),
			Field::inst( 'iibbrmh.approval_state' ),
			Field::inst( 'iibbrmh.start_at' ),
			Field::inst( 'iibbrmh.finish_at' ),
			Field::inst( 'iibbrmh.is_defaultprogram' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_iibbrmh'] == 0){
		$editor
			->where( 'iibbrmh.transaction_state', -9, '<>');
	}
	
	include( "iibbrmh_extra.php" );

	// BEGIN log
	$nama_table = 'iibbrmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>