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
	
	$editor = Editor::inst( $db, 'wlpxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'wlpxxmh.id' ),
			Field::inst( 'wlpxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'wlpxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'wlpxxmh.keterangan' ),
			Field::inst( 'wlpxxmh.created_by' ),
			Field::inst( 'wlpxxmh.transaction_state' ),
			Field::inst( 'wlpxxmh.approval_state' ),
			Field::inst( 'wlpxxmh.start_at' ),
			Field::inst( 'wlpxxmh.finish_at' ),
			Field::inst( 'wlpxxmh.is_defaultprogram' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_wlpxxmh'] == 0){
		$editor
			->where( 'wlpxxmh.transaction_state', -9, '<>');
	}
	
	include( "wlpxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'wlpxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>