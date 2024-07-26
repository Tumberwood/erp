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
	
	$editor = Editor::inst( $db, 'fbnxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'fbnxxmh.id' ),
			Field::inst( 'fbnxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'fbnxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'fbnxxmh.keterangan' ),
			Field::inst( 'fbnxxmh.created_by' ),
			Field::inst( 'fbnxxmh.transaction_state' ),
			Field::inst( 'fbnxxmh.approval_state' ),
			Field::inst( 'fbnxxmh.start_at' ),
			Field::inst( 'fbnxxmh.finish_at' ),
			Field::inst( 'fbnxxmh.is_nextprocess' ),
			Field::inst( 'fbnxxmh.is_defaultprogram' )
		)
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_fbnxxmh'] == 0){
		$editor
			->where( 'fbnxxmh.transaction_state', -9, '<>');
	}
	
	include( "fbnxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'fbnxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>