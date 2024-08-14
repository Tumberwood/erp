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
	
	if ( ! isset($_POST['id_prcxxth_sig1']) || ! is_numeric($_POST['id_prcxxth_sig1']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'prcittd_sig1' )
			->debug(true)
			->fields(
				Field::inst( 'prcittd_sig1.id' ),
				Field::inst( 'prcittd_sig1.id_prcxxth_sig1' ),
				Field::inst( 'prcittd_sig1.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'prcittd_sig1.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'prcittd_sig1.kode' ),
				Field::inst( 'prcittd_sig1.nama' ),
				Field::inst( 'prcittd_sig1.keterangan' ),
				Field::inst( 'prcittd_sig1.created_by' ),
				Field::inst( 'prcittd_sig1.transaction_state' ),
				Field::inst( 'prcittd_sig1.approval_state' ),
				Field::inst( 'prcittd_sig1.start_at' ),
				Field::inst( 'prcittd_sig1.finish_at' ),
				Field::inst( 'prcittd_sig1.is_defaultprogram' ),
				Field::inst( 'prcittd_sig1.is_nextprocess' ),

				Field::inst( 'prcittd_sig1.jumlah_unit' ),
				Field::inst( 'prcittd_sig1.harga_unit' ),
				Field::inst( 'prcittd_sig1.diskon_jenis' ),
				Field::inst( 'prcittd_sig1.diskon_persen' ),
				Field::inst( 'prcittd_sig1.diskon_value' ),
				Field::inst( 'prcittd_sig1.diskon_final' ),
				Field::inst( 'prcittd_sig1.subtotal' ),
				Field::inst( 'prcittd_sig1.dpp' ),

				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'iumxxmh_unit.kode' )
			)
			->leftJoin( 'iumxxmh as iumxxmh_unit','iumxxmh_unit.id','=','prcittd_sig1.id_iumxxmh_unit' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','prcittd_sig1.id_iimxxmh' )
			->where('prcittd_sig1.id_prcxxth_sig1',$_POST['id_prcxxth_sig1']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_prcittd_sig1'] == 0){
			$editor
				->where( 'prcittd_sig1.transaction_state', -9, '<>');
		}
		
		include( "prcittd_sig1_extra.php" );

		// BEGIN log
		$nama_table = 'prcittd_sig1';
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