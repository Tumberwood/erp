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
	
	$editor = Editor::inst( $db, 'iigx2mh' )
		->debug(true)
		->fields(
			Field::inst( 'iigx2mh.id' ),
			Field::inst( 'iigx2mh.id_iigxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'iigx2mh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'iigx2mh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'iigx2mh.keterangan' ),
			Field::inst( 'iigx2mh.created_by' ),
			Field::inst( 'iigx2mh.transaction_state' ),
			Field::inst( 'iigx2mh.approval_state' ),
			Field::inst( 'iigx2mh.start_at' ),
			Field::inst( 'iigx2mh.finish_at' ),
			Field::inst( 'iigx2mh.is_defaultprogram' ),
			Field::inst( 'iigx2mh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_iigx2mh'] == 0){
		$editor
			->where( 'iigx2mh.transaction_state', -9, '<>');
	}
	
	include( "iigx2mh_extra.php" );

	// BEGIN log
	$nama_table = 'iigx2mh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>