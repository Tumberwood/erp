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
	
	$editor = Editor::inst( $db, 'wloxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'wloxxmh.id' ),
			Field::inst( 'wloxxmh.id_iwhxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wloxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'wloxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'wloxxmh.keterangan' ),
			Field::inst( 'wloxxmh.created_by' ),
			Field::inst( 'wloxxmh.transaction_state' ),
			Field::inst( 'wloxxmh.approval_state' ),
			Field::inst( 'wloxxmh.start_at' ),
			Field::inst( 'wloxxmh.finish_at' ),
			Field::inst( 'wloxxmh.is_defaultprogram' ),
			Field::inst( 'iwhxxmh.nama' )
		)
		->leftJoin( 'iwhxxmh','iwhxxmh.id','=','wloxxmh.id_iwhxxmh' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_wloxxmh'] == 0){
		$editor
			->where( 'wloxxmh.transaction_state', -9, '<>');
	}
	
	include( "wloxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'wloxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>