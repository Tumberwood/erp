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
	
	$editor = Editor::inst( $db, 'edpxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'edpxxmh.id' ),
			Field::inst( 'edpxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'edpxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'edpxxmh.keterangan' ),
			Field::inst( 'edpxxmh.created_by' ),
			Field::inst( 'edpxxmh.transaction_state' ),
			Field::inst( 'edpxxmh.approval_state' ),
			Field::inst( 'edpxxmh.start_at' ),
			Field::inst( 'edpxxmh.finish_at' ),
			Field::inst( 'edpxxmh.is_defaultprogram' ),
			Field::inst( 'edpxxmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_edpxxmh'] == 0){
		$editor
			->where( 'edpxxmh.transaction_state', -9, '<>');
	}
	
	include( "edpxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'edpxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>