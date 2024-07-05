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
	
	if ( ! isset($_POST['id_wdnxxth']) || ! is_numeric($_POST['id_wdnxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'wdnittd' )
			->debug(true)
			->fields(
				Field::inst( 'wdnittd.id' ),
				Field::inst( 'wdnittd.id_wdnxxth' ),
				Field::inst( 'wdnittd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wdnittd.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wdnittd.kode' ),
				Field::inst( 'wdnittd.nama' ),
				Field::inst( 'wdnittd.keterangan' ),
				Field::inst( 'wdnittd.created_by' ),
				Field::inst( 'wdnittd.transaction_state' ),
				Field::inst( 'wdnittd.approval_state' ),
				Field::inst( 'wdnittd.start_at' ),
				Field::inst( 'wdnittd.finish_at' ),
				Field::inst( 'wdnittd.is_defaultprogram' ),

				Field::inst( 'wdnittd.jumlah_unit' ),
				Field::inst( 'wdnittd.diskon_jenis' ),
				Field::inst( 'wdnittd.diskon_persen' ),
				Field::inst( 'wdnittd.diskon_value' ),
				Field::inst( 'wdnittd.diskon_final' ),
				Field::inst( 'wdnittd.subtotal' ),
				Field::inst( 'wdnittd.dpp' ),

				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'iumxxmh_unit.kode' )
			)
			->leftJoin( 'iumxxmh as iumxxmh_unit','iumxxmh_unit.id','=','wdnittd.id_iumxxmh_unit' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','wdnittd.id_iimxxmh' )
			->where('wdnittd.id_wdnxxth',$_POST['id_wdnxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_wdnittd'] == 0){
			$editor
				->where( 'wdnittd.transaction_state', -9, '<>');
		}
		
		include( "wdnittd_extra.php" );

		// BEGIN log
		$nama_table = 'wdnittd';
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