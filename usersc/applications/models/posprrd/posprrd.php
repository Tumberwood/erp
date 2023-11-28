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
	
	$editor = Editor::inst( $db, 'podittd' )
		->debug(true)
		->fields(
			Field::inst( 'podittd.id' ),
			Field::inst( 'podittd.id_iimxxmh' ),
			Field::inst( 'podittd.id_iumxxmh' ),
			Field::inst( 'podittd.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'podittd.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'podittd.keterangan' ),
			Field::inst( 'podittd.created_by' ),
			Field::inst( 'podittd.transaction_state' ),
			Field::inst( 'podittd.approval_state' ),
			Field::inst( 'podittd.start_at' ),
			Field::inst( 'podittd.finish_at' ),
			Field::inst( 'podittd.is_defaultprogram' ),
			Field::inst( 'podittd.jumlah_unit' ),
			Field::inst( 'prqxxth.kode' ),
			Field::inst( 'podxxth.kode' ),
			Field::inst( 'iimxxmh.kode' ),
			Field::inst( 'iimxxmh.nama' ),
			Field::inst( 'prqittd.jumlah_unit' ),
			Field::inst( 'ium_po.nama' ),
			Field::inst( 'ium_pr.nama' )
		)
		->leftJoin( 'prqittd','prqittd.id','=','podittd.id_prqittd' )
		->leftJoin( 'prqxxth','prqxxth.id','=','prqittd.id_prqxxth' )
		->leftJoin( 'iimxxmh','iimxxmh.id','=','podittd.id_iimxxmh' )
		->leftJoin( 'podxxth','podxxth.id','=','podittd.id_podxxth' )
		->leftJoin( 'iumxxmh as ium_po','ium_po.id','=','podittd.id_iumxxmh' )
		->leftJoin( 'iumxxmh as ium_pr','ium_pr.id','=','prqittd.id_iumxxmh' )
		->where( 'podxxth.transaction_state', 1)
		;
	
	// do not erase

	// BEGIN log
	$nama_table = 'podittd';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>