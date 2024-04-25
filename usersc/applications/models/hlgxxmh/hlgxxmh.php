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
	
	$editor = Editor::inst( $db, 'hlgxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'hlgxxmh.id' ),
			Field::inst( 'hlgxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hlgxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hlgxxmh.keterangan' ),
			Field::inst( 'hlgxxmh.created_by' ),
			Field::inst( 'hlgxxmh.transaction_state' ),
			Field::inst( 'hlgxxmh.approval_state' ),
			Field::inst( 'hlgxxmh.start_at' ),
			Field::inst( 'hlgxxmh.finish_at' ),
			Field::inst( 'hlgxxmh.is_defaultprogram' ),
			Field::inst( 'hlgxxmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hlgxxmh'] == 0){
		$editor
			->where( 'hlgxxmh.transaction_state', -9, '<>');
	}
	
	include( "hlgxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'hlgxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>