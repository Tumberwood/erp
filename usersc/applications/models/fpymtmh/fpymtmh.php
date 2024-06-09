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
	
	$editor = Editor::inst( $db, 'fpymtmh' )
		->debug(true)
		->fields(
			Field::inst( 'fpymtmh.id' ),
			Field::inst( 'fpymtmh.id_aakxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'fpymtmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'fpymtmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'fpymtmh.keterangan' ),
			Field::inst( 'fpymtmh.created_by' ),
			Field::inst( 'fpymtmh.transaction_state' ),
			Field::inst( 'fpymtmh.approval_state' ),
			Field::inst( 'fpymtmh.start_at' ),
			Field::inst( 'fpymtmh.finish_at' ),
			Field::inst( 'fpymtmh.is_default' ),
			Field::inst( 'fpymtmh.is_defaultprogram' ),
			Field::inst( 'fpymtmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_fpymtmh'] == 0){
		$editor
			->where( 'fpymtmh.transaction_state', -9, '<>');
	}
	
	include( "fpymtmh_extra.php" );

	// BEGIN log
	$nama_table = 'fpymtmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>