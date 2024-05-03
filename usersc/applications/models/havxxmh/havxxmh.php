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
	
	$editor = Editor::inst( $db, 'havxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'havxxmh.id' ),
			Field::inst( 'havxxmh.id_hadxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'havxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'havxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'havxxmh.keterangan' ),
			Field::inst( 'havxxmh.created_by' ),
			Field::inst( 'havxxmh.transaction_state' ),
			Field::inst( 'havxxmh.approval_state' ),
			Field::inst( 'havxxmh.start_at' ),
			Field::inst( 'havxxmh.finish_at' ),
			Field::inst( 'havxxmh.is_defaultprogram' ),
			Field::inst( 'havxxmh.is_nextprocess' ),

			Field::inst( 'hadxxmh.nama' )
		)
		->leftJoin( 'hadxxmh','hadxxmh.id','=','havxxmh.id_hadxxmh' );

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_havxxmh'] == 0){
		$editor
			->where( 'havxxmh.transaction_state', -9, '<>');
	}
	
	include( "havxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'havxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>