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
	
	$editor = Editor::inst( $db, 'nibxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'nibxxmh.id' ),
			Field::inst( 'nibxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'nibxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'nibxxmh.keterangan' ),
			Field::inst( 'nibxxmh.created_by' ),
			Field::inst( 'nibxxmh.transaction_state' ),
			Field::inst( 'nibxxmh.approval_state' ),
			Field::inst( 'nibxxmh.start_at' ),
			Field::inst( 'nibxxmh.finish_at' ),
			Field::inst( 'nibxxmh.is_defaultprogram' ),
			Field::inst( 'nibxxmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_nibxxmh'] == 0){
		$editor
			->where( 'nibxxmh.transaction_state', -9, '<>');
	}
	
	include( "nibxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'nibxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>