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
	
	if ( ! isset($_POST['id_sdlxxth_sig1']) || ! is_numeric($_POST['id_sdlxxth_sig1']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'sdlittd_sig1' )
			->debug(true)
			->fields(
				Field::inst( 'sdlittd_sig1.id' ),
				Field::inst( 'sdlittd_sig1.id_sdlxxth_sig1' ),
				Field::inst( 'sdlittd_sig1.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sdlittd_sig1.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sdlittd_sig1.kode' ),
				Field::inst( 'sdlittd_sig1.nama' ),
				Field::inst( 'sdlittd_sig1.keterangan' ),
				Field::inst( 'sdlittd_sig1.created_by' ),
				Field::inst( 'sdlittd_sig1.transaction_state' ),
				Field::inst( 'sdlittd_sig1.approval_state' ),
				Field::inst( 'sdlittd_sig1.start_at' ),
				Field::inst( 'sdlittd_sig1.finish_at' ),
				Field::inst( 'sdlittd_sig1.is_defaultprogram' ),
				Field::inst( 'sdlittd_sig1.is_nextprocess' ),

				Field::inst( 'sdlittd_sig1.jumlah_unit' ),
				Field::inst( 'sdlittd_sig1.diskon_jenis' ),
				Field::inst( 'sdlittd_sig1.diskon_persen' ),
				Field::inst( 'sdlittd_sig1.diskon_value' ),
				Field::inst( 'sdlittd_sig1.diskon_final' ),
				Field::inst( 'sdlittd_sig1.subtotal' ),
				Field::inst( 'sdlittd_sig1.dpp' ),

				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'iumxxmh_unit.kode' )
			)
			->leftJoin( 'iumxxmh as iumxxmh_unit','iumxxmh_unit.id','=','sdlittd_sig1.id_iumxxmh_unit' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','sdlittd_sig1.id_iimxxmh' )
			->where('sdlittd_sig1.id_sdlxxth_sig1',$_POST['id_sdlxxth_sig1']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_sdlittd_sig1'] == 0){
			$editor
				->where( 'sdlittd_sig1.transaction_state', -9, '<>');
		}
		
		include( "sdlittd_sig1_extra.php" );

		// BEGIN log
		$nama_table = 'sdlittd_sig1';
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