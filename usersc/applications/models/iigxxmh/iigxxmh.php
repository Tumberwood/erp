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
	
	$editor = Editor::inst( $db, 'iigxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'iigxxmh.id' ),
			Field::inst( 'iigxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'iigxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'iigxxmh.keterangan' ),
			Field::inst( 'iigxxmh.created_by' ),
			Field::inst( 'iigxxmh.transaction_state' ),
			Field::inst( 'iigxxmh.approval_state' ),
			Field::inst( 'iigxxmh.start_at' ),
			Field::inst( 'iigxxmh.finish_at' ),
			Field::inst( 'iigxxmh.is_defaultprogram' ),
			Field::inst( 'iigxxmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_iigxxmh'] == 0){
		$editor
			->where( 'iigxxmh.transaction_state', -9, '<>');
	}
	
	include( "iigxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'iigxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>