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
	
	$editor = Editor::inst( $db, 'iittpmh' )
		->debug(true)
		->fields(
			Field::inst( 'iittpmh.id' ),
			Field::inst( 'iittpmh.id_ftxxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'iittpmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'iittpmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'iittpmh.keterangan' ),
			Field::inst( 'iittpmh.created_by' ),
			Field::inst( 'iittpmh.transaction_state' ),
			Field::inst( 'iittpmh.approval_state' ),
			Field::inst( 'iittpmh.start_at' ),
			Field::inst( 'iittpmh.finish_at' ),
			Field::inst( 'iittpmh.is_defaultprogram' ),
			Field::inst( 'ftxxxmh.kode' )
		)
		->leftJoin( 'ftxxxmh','ftxxxmh.id','=','iittpmh.id_ftxxxmh' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_iittpmh'] == 0){
		$editor
			->where( 'iittpmh.transaction_state', -9, '<>');
	}
	
	include( "iittpmh_extra.php" );

	// BEGIN log
	$nama_table = 'iittpmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>