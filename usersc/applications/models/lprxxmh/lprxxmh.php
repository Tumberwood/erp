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
	
	$editor = Editor::inst( $db, 'lprxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'lprxxmh.id' ),
			Field::inst( 'lprxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'lprxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'lprxxmh.keterangan' ),
			Field::inst( 'lprxxmh.created_by' ),
			Field::inst( 'lprxxmh.transaction_state' ),
			Field::inst( 'lprxxmh.approval_state' ),
			Field::inst( 'lprxxmh.start_at' ),
			Field::inst( 'lprxxmh.finish_at' ),
			Field::inst( 'lprxxmh.is_defaultprogram' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_lprxxmh'] == 0){
		$editor
			->where( 'lprxxmh.transaction_state', -9, '<>');
	}
	
	include( "lprxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'lprxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>