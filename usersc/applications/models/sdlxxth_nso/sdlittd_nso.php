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
	
	if ( ! isset($_POST['id_sdlxxth_nso']) || ! is_numeric($_POST['id_sdlxxth_nso']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'sdlittd_nso' )
			->debug(true)
			->fields(
				Field::inst( 'sdlittd_nso.id' ),
				Field::inst( 'sdlittd_nso.id_sdlxxth_nso' ),
				Field::inst( 'sdlittd_nso.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sdlittd_nso.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sdlittd_nso.kode' ),
				Field::inst( 'sdlittd_nso.nama' ),
				Field::inst( 'sdlittd_nso.keterangan' ),
				Field::inst( 'sdlittd_nso.created_by' ),
				Field::inst( 'sdlittd_nso.transaction_state' ),
				Field::inst( 'sdlittd_nso.approval_state' ),
				Field::inst( 'sdlittd_nso.start_at' ),
				Field::inst( 'sdlittd_nso.finish_at' ),
				Field::inst( 'sdlittd_nso.is_defaultprogram' ),
				Field::inst( 'sdlittd_nso.is_nextprocess' ),

				Field::inst( 'sdlittd_nso.harga_unit' ),
				Field::inst( 'sdlittd_nso.jumlah_unit' ),
				Field::inst( 'sdlittd_nso.diskon_jenis' ),
				Field::inst( 'sdlittd_nso.diskon_persen' ),
				Field::inst( 'sdlittd_nso.diskon_value' ),
				Field::inst( 'sdlittd_nso.diskon_final' ),
				Field::inst( 'sdlittd_nso.subtotal' ),
				Field::inst( 'sdlittd_nso.dpp' ),

				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'iumxxmh_unit.kode' )
			)
			->leftJoin( 'iumxxmh as iumxxmh_unit','iumxxmh_unit.id','=','sdlittd_nso.id_iumxxmh_unit' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','sdlittd_nso.id_iimxxmh' )
			->where('sdlittd_nso.id_sdlxxth_nso',$_POST['id_sdlxxth_nso']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_sdlittd_nso'] == 0){
			$editor
				->where( 'sdlittd_nso.transaction_state', -9, '<>');
		}
		
		include( "sdlittd_nso_extra.php" );

		// BEGIN log
		$nama_table = 'sdlittd_nso';
		include( "../../../helpers/edt_log.php" );
		// END log
		
		$json = $editor
			->process( $_POST )
			->data();

		// debugging hak akses
		$json['hakakses'] = $hakakses;

		echo json_encode( $json );

	}
?>