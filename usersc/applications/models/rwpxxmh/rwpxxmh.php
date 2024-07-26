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
	
	$editor = Editor::inst( $db, 'rwpxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'rwpxxmh.id' ),
			Field::inst( 'rwpxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'rwpxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'rwpxxmh.keterangan' ),
			Field::inst( 'rwpxxmh.created_by' ),
			Field::inst( 'rwpxxmh.transaction_state' ),
			Field::inst( 'rwpxxmh.approval_state' ),
			Field::inst( 'rwpxxmh.start_at' ),
			Field::inst( 'rwpxxmh.finish_at' ),
			Field::inst( 'rwpxxmh.is_nextprocess' ),
			Field::inst( 'rwpxxmh.is_defaultprogram' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_rwpxxmh'] == 0){
		$editor
			->where( 'rwpxxmh.transaction_state', -9, '<>');
	}
	
	include( "rwpxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'rwpxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>