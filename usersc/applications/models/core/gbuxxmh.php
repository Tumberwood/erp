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

	$editor = Editor::inst( $db, 'gbuxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'gbuxxmh.id' ),
			Field::inst( 'gbuxxmh.kode' ),
			Field::inst( 'gbuxxmh.nama' ),
			Field::inst( 'gbuxxmh.keterangan' ),
			Field::inst( 'gbuxxmh.created_by' ),
			Field::inst( 'gbuxxmh.transaction_state' ),
			Field::inst( 'gbuxxmh.approval_state' ),
			Field::inst( 'gbuxxmh.start_at' ),
			Field::inst( 'gbuxxmh.finish_at' ),
			Field::inst( 'gbuxxmh.is_defaultprogram' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_gbuxxmh'] == 0){
		$editor
			->where( 'gbuxxmh.transaction_state', -9, '<>');
	}
	
	// include( "gbuxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'gbuxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>