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
	
	$editor = Editor::inst( $db, 'iitxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'iitxxmh.id' ),
			Field::inst( 'iitxxmh.id_ftxxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'iitxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'iitxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'iitxxmh.keterangan' ),
			Field::inst( 'iitxxmh.created_by' ),
			Field::inst( 'iitxxmh.transaction_state' ),
			Field::inst( 'iitxxmh.approval_state' ),
			Field::inst( 'iitxxmh.start_at' ),
			Field::inst( 'iitxxmh.finish_at' ),
			Field::inst( 'iitxxmh.is_defaultprogram' ),
			Field::inst( 'ftxxxmh.kode' )
		)
		->leftJoin( 'ftxxxmh','ftxxxmh.id','=','iitxxmh.id_ftxxxmh' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_iitxxmh'] == 0){
		$editor
			->where( 'iitxxmh.transaction_state', -9, '<>');
	}
	
	include( "iitxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'iitxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>