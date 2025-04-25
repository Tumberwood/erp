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
		DataTables\Editor\Result,
		Carbon\Carbon,
		SolusiIndonesia\Utilities\Converter;
	
	$editor = Editor::inst( $db, 'wloxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'wloxxmh.id' ),
			Field::inst( 'wloxxmh.id_iwhxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wloxxmh.id_wloctmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wloxxmh.id_wlotpmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wloxxmh.id_wloznmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wloxxmh.id_iumxxmh_kapasitas' )
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
			Field::inst( 'wloxxmh.is_default' ),
			Field::inst( 'wloxxmh.is_nextprocess' ),
			Field::inst( 'wloxxmh.is_generate_nama' ),
			Field::inst( 'wloxxmh.is_smaller' ),
			Field::inst( 'wloxxmh.depth' ),

			Field::inst( 'wloxxmh.kapasitas' ),
			Field::inst( 'wloxxmh.rack' ),
			Field::inst( 'wloxxmh.rack_name' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'wloxxmh.bay' ),
			Field::inst( 'wloxxmh.bay_name' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'wloxxmh.level' ),
			Field::inst( 'wloxxmh.level_name' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'wloxxmh.position' ),
			Field::inst( 'wloxxmh.position_name' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			
			Field::inst( 'wloxxmh.koord_x' ),
			Field::inst( 'wloxxmh.koord_y' ),
			Field::inst( 'wloxxmh.koord_z' ),
			
			Field::inst( 'iwhxxmh.nama' ),
			Field::inst( 'wloctmh.nama' ),
			Field::inst( 'wlotpmh.nama' ),
			Field::inst( 'wloznmh.nama' )
		)
		->leftJoin( 'iwhxxmh','iwhxxmh.id','=','wloxxmh.id_iwhxxmh' )
		->leftJoin( 'wloctmh','wloctmh.id','=','wloxxmh.id_wloctmh' )
		->leftJoin( 'wlotpmh','wlotpmh.id','=','wloxxmh.id_wlotpmh' )
		->leftJoin( 'wloznmh','wloznmh.id','=','wloxxmh.id_wloznmh' )
		->leftJoin( 'iumxxmh','iumxxmh.id','=','wloxxmh.id_iumxxmh_kapasitas' );
	
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