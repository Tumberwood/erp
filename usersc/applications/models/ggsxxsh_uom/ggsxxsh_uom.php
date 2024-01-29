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
	
	$editor = Editor::inst( $db, 'ggsxxsh' )
		->debug(true)
		->fields(
			Field::inst( 'ggsxxsh.id' ),
			Field::inst( 'ggsxxsh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'ggsxxsh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'ggsxxsh.keterangan' ),
			Field::inst( 'ggsxxsh.created_by' ),
			Field::inst( 'ggsxxsh.transaction_state' ),
			Field::inst( 'ggsxxsh.approval_state' ),
			Field::inst( 'ggsxxsh.start_at' ),
			Field::inst( 'ggsxxsh.finish_at' ),
			Field::inst( 'ggsxxsh.id_iumxxmh_panjang' ),
			Field::inst( 'ggsxxsh.id_iumxxmh_berat' ),
			Field::inst( 'ggsxxsh.is_defaultprogram' ),
			Field::inst( 'berat.nama' ),
			Field::inst( 'panjang.nama' )
		)
		->leftJoin( 'iumxxmh AS panjang','panjang.id','=','ggsxxsh.id_iumxxmh_panjang' )
		->leftJoin( 'iumxxmh AS berat','berat.id','=','ggsxxsh.id_iumxxmh_berat' )
		;
	
	// do not erase
	// function show / hide inactive document

	// BEGIN log
	$nama_table = 'ggsxxsh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>