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
	
	if ( ! isset($_POST['id_sdlxxth']) || ! is_numeric($_POST['id_sdlxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'sdlittd' )
			->debug(true)
			->fields(
				Field::inst( 'sdlittd.id' ),
				Field::inst( 'sdlittd.id_sdlxxth' ),
				Field::inst( 'sdlittd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sdlittd.id_sodxxth' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sdlittd.id_sodittd' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sdlittd.id_podittd' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sdlittd.id_podxxth' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sdlittd.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sdlittd.id_scsittd' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sdlittd.kode' ),
				Field::inst( 'sdlittd.nama' ),
				Field::inst( 'sdlittd.keterangan' ),
				Field::inst( 'sdlittd.created_by' ),
				Field::inst( 'sdlittd.transaction_state' ),
				Field::inst( 'sdlittd.approval_state' ),
				Field::inst( 'sdlittd.start_at' ),
				Field::inst( 'sdlittd.finish_at' ),
				Field::inst( 'sdlittd.is_defaultprogram' ),
				Field::inst( 'sdlittd.is_nextprocess' ),

				Field::inst( 'sdlittd.harga_unit' ),
				Field::inst( 'sdlittd.jumlah_unit' ),
				Field::inst( 'sdlittd.diskon_jenis' ),
				Field::inst( 'sdlittd.diskon_persen' ),
				Field::inst( 'sdlittd.diskon_value' ),
				Field::inst( 'sdlittd.diskon_final' ),
				Field::inst( 'sdlittd.subtotal' ),
				Field::inst( 'sdlittd.dpp' ),
				Field::inst( 'sdlittd.jumlah_bom' ),

				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'iumxxmh_unit.kode' )
			)
			->leftJoin( 'iumxxmh as iumxxmh_unit','iumxxmh_unit.id','=','sdlittd.id_iumxxmh_unit' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','sdlittd.id_iimxxmh' )
			->where('sdlittd.id_sdlxxth',$_POST['id_sdlxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_sdlittd'] == 0){
			$editor
				->where( 'sdlittd.transaction_state', -9, '<>');
		}
		
		include( "sdlittd_extra.php" );

		// BEGIN log
		$nama_table = 'sdlittd';
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