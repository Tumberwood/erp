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
	
	$editor = Editor::inst( $db, 'iwhctmh' )
		->debug(true)
		->fields(
			Field::inst( 'iwhctmh.id' ),
			Field::inst( 'iwhctmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'iwhctmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'iwhctmh.keterangan' ),
			Field::inst( 'iwhctmh.created_by' ),
			Field::inst( 'iwhctmh.transaction_state' ),
			Field::inst( 'iwhctmh.approval_state' ),
			Field::inst( 'iwhctmh.start_at' ),
			Field::inst( 'iwhctmh.finish_at' ),
			Field::inst( 'iwhctmh.is_defaultprogram' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_iwhctmh'] == 0){
		$editor
			->where( 'iwhctmh.transaction_state', -9, '<>');
	}
	
	include( "iwhctmh_extra.php" );

	// BEGIN log
	$nama_table = 'iwhctmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>