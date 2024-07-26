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
	
	if ( ! isset($_POST['id_wdoxxth']) || ! is_numeric($_POST['id_wdoxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'wdoittd' )
			->debug(true)
			->fields(
				Field::inst( 'wdoittd.id' ),
				Field::inst( 'wdoittd.id_wdoxxth' ),
				Field::inst( 'wdoittd.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wdoittd.id_prqittd' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wdoittd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wdoittd.kode' ),
				Field::inst( 'wdoittd.nama' ),
				Field::inst( 'wdoittd.keterangan' ),
				Field::inst( 'wdoittd.created_by' ),
				Field::inst( 'wdoittd.transaction_state' ),
				Field::inst( 'wdoittd.approval_state' ),
				Field::inst( 'wdoittd.start_at' ),
				Field::inst( 'wdoittd.finish_at' ),
				Field::inst( 'wdoittd.tanggal_dibutuhkan' )
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
					) ),
				Field::inst( 'wdoittd.is_nextprocess' ),
				Field::inst( 'wdoittd.is_defaultprogram' ),
				Field::inst( 'wdoittd.jumlah_unit' ),
				Field::inst( 'wdoittd.harga_unit' ),
				Field::inst( 'wdoittd.subtotal' ),
				Field::inst( 'wdoittd.diskon_jenis' ),
				Field::inst( 'wdoittd.diskon_value' ),
				Field::inst( 'wdoittd.diskon_persen' ),
				Field::inst( 'wdoittd.diskon_final' ),
				Field::inst( 'wdoittd.dpp' ),

				Field::inst( 'iumxxmh.nama' ),
				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'prqxxth.kode' )
			)
			->leftJoin( 'iumxxmh','iumxxmh.id','=','wdoittd.id_iumxxmh_unit' )
			->leftJoin( 'prqittd','prqittd.id','=','wdoittd.id_prqittd' )
			->leftJoin( 'prqxxth','prqxxth.id','=','prqittd.id_prqxxth' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','wdoittd.id_iimxxmh' )
			->where('wdoittd.id_wdoxxth',$_POST['id_wdoxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_wdoittd'] == 0){
			$editor
				->where( 'wdoittd.transaction_state', -9, '<>');
		}
		
		include( "wdoittd_extra.php" );

		// BEGIN log
		$nama_table = 'wdoittd';
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