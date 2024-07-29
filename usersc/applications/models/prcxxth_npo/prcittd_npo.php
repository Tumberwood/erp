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
	
	if ( ! isset($_POST['id_prcxxth_npo']) || ! is_numeric($_POST['id_prcxxth_npo']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'prcittd_npo' )
			->debug(true)
			->fields(
				Field::inst( 'prcittd_npo.id' ),
				Field::inst( 'prcittd_npo.id_prcxxth_npo' ),
				Field::inst( 'prcittd_npo.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'prcittd_npo.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'prcittd_npo.kode' ),
				Field::inst( 'prcittd_npo.nama' ),
				Field::inst( 'prcittd_npo.keterangan' ),
				Field::inst( 'prcittd_npo.created_by' ),
				Field::inst( 'prcittd_npo.transaction_state' ),
				Field::inst( 'prcittd_npo.approval_state' ),
				Field::inst( 'prcittd_npo.start_at' ),
				Field::inst( 'prcittd_npo.finish_at' ),
				Field::inst( 'prcittd_npo.is_defaultprogram' ),
				Field::inst( 'prcittd_npo.is_nextprocess' ),

				Field::inst( 'prcittd_npo.jumlah_unit' ),
				Field::inst( 'prcittd_npo.harga_unit' ),
				Field::inst( 'prcittd_npo.diskon_jenis' ),
				Field::inst( 'prcittd_npo.diskon_persen' ),
				Field::inst( 'prcittd_npo.diskon_value' ),
				Field::inst( 'prcittd_npo.diskon_final' ),
				Field::inst( 'prcittd_npo.subtotal' ),
				Field::inst( 'prcittd_npo.dpp' ),

				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'iumxxmh_unit.kode' )
			)
			->leftJoin( 'iumxxmh as iumxxmh_unit','iumxxmh_unit.id','=','prcittd_npo.id_iumxxmh_unit' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','prcittd_npo.id_iimxxmh' )
			->where('prcittd_npo.id_prcxxth_npo',$_POST['id_prcxxth_npo']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_prcittd_npo'] == 0){
			$editor
				->where( 'prcittd_npo.transaction_state', -9, '<>');
		}
		
		include( "prcittd_npo_extra.php" );

		// BEGIN log
		$nama_table = 'prcittd_npo';
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