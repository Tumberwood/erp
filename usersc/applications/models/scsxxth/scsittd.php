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
	
	if ( ! isset($_POST['id_scsxxth']) || ! is_numeric($_POST['id_scsxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'scsittd' )
			->debug(true)
			->fields(
				Field::inst( 'scsittd.id' ),
				Field::inst( 'scsittd.id_scsxxth' ),
				Field::inst( 'scsittd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'scsittd.id_sodxxth' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'scsittd.id_sodittd' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'scsittd.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'scsittd.kode' ),
				Field::inst( 'scsittd.nama' ),
				Field::inst( 'scsittd.keterangan' ),
				Field::inst( 'scsittd.created_by' ),
				Field::inst( 'scsittd.transaction_state' ),
				Field::inst( 'scsittd.approval_state' ),
				Field::inst( 'scsittd.start_at' ),
				Field::inst( 'scsittd.finish_at' ),
				Field::inst( 'scsittd.is_defaultprogram' ),
				Field::inst( 'scsittd.is_nextprocess' ),

				Field::inst( 'scsittd.harga_unit' ),
				Field::inst( 'scsittd.jumlah_unit' ),
				Field::inst( 'scsittd.diskon_jenis' ),
				Field::inst( 'scsittd.diskon_persen' ),
				Field::inst( 'scsittd.diskon_value' ),
				Field::inst( 'scsittd.diskon_final' ),
				Field::inst( 'scsittd.subtotal' ),
				Field::inst( 'scsittd.dpp' ),
				Field::inst( 'scsittd.jumlah_bom' ),

				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'iumxxmh_unit.kode' )
			)
			->leftJoin( 'iumxxmh as iumxxmh_unit','iumxxmh_unit.id','=','scsittd.id_iumxxmh_unit' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','scsittd.id_iimxxmh' )
			->where('scsittd.id_scsxxth',$_POST['id_scsxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_scsittd'] == 0){
			$editor
				->where( 'scsittd.transaction_state', -9, '<>');
		}
		
		include( "scsittd_extra.php" );

		// BEGIN log
		$nama_table = 'scsittd';
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