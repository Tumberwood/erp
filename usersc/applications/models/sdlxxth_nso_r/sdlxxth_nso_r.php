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
	
	$editor = Editor::inst( $db, 'sdlittd_nso' )
		->debug(true)
		->fields(
			Field::inst( 'sdlittd_nso.id' ),
			Field::inst( 'sdlittd_nso.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'sdlittd_nso.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'sdlittd_nso.keterangan' ),
			Field::inst( 'sdlittd_nso.id_iimxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sdlittd_nso.id_iumxxmh_unit' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sdlittd_nso.is_nextprocess' ),
			
			Field::inst( 'sdlittd_nso.jumlah_unit' ),
			Field::inst( 'sdlittd_nso.is_defaultprogram' ),
			Field::inst( 'sdlxxth_nso.kode' ),
			Field::inst( 'sdlxxth_nso.tanggal' )
				->getFormatter( function ( $val, $data, $opts ) {
					if ($val === '0000-00-00' || $val === null){
						echo '';
					}else{
						return date( 'd M Y', strtotime( $val ) );
					}
				} )
				->setFormatter( 'Format::datetime', array(
					'from' => 'd M Y',
					'to' =>   'Y-m-d'
				) )
			,
			
			Field::inst( 'sdlittd_nso.harga_unit' ),
			Field::inst( 'sdlittd_nso.subtotal' ),
			Field::inst( 'sdlittd_nso.diskon_final' ),
			Field::inst( 'sdlittd_nso.dpp' ),

			Field::inst( 'iimxxmh.kode' ),
			Field::inst( 'iimxxmh.nama' ),
			Field::inst( 'iumxxmh_unit.kode' ),
			Field::inst( 'iwhxxmh.nama' ),
			Field::inst( 'grlxxmh.nama' ),
		)
		->leftJoin( 'iumxxmh as iumxxmh_unit','iumxxmh_unit.id','=','sdlittd_nso.id_iumxxmh_unit' )
		->leftJoin( 'iimxxmh','iimxxmh.id','=','sdlittd_nso.id_iimxxmh' )
		->leftJoin( 'sdlxxth_nso','sdlxxth_nso.id','=','sdlittd_nso.id_sdlxxth_nso' )
		->leftJoin( 'iwhxxmh','iwhxxmh.id','=','sdlxxth_nso.id_iwhxxmh' )
		->leftJoin( 'grlxxmh','grlxxmh.id','=','sdlxxth_nso.id_grlxxmh_customer' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_sdlxxth_nso'] == 0){
		$editor
			->where( 'sdlxxth_nso.transaction_state', -9, '<>');
	}
	
	include( "sdlxxth_nso_extra.php" );

	// BEGIN log
	$nama_table = 'sdlxxth_nso';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>