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
	
	if ( ! isset($_POST['id_pivxxth']) || ! is_numeric($_POST['id_pivxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'pivittd' )
			->debug(true)
			->fields(
				Field::inst( 'pivittd.id' ),
				Field::inst( 'pivittd.id_pivxxth' ),
				Field::inst( 'pivittd.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'pivittd.id_iumxxmh_buy' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'pivittd.id_prcittd' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'pivittd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'pivittd.kode' ),
				Field::inst( 'pivittd.nama' ),
				Field::inst( 'pivittd.keterangan' ),
				Field::inst( 'pivittd.created_by' ),
				Field::inst( 'pivittd.transaction_state' ),
				Field::inst( 'pivittd.approval_state' ),
				Field::inst( 'pivittd.start_at' ),
				Field::inst( 'pivittd.finish_at' ),
				Field::inst( 'pivittd.tanggal_dibutuhkan' )
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
				Field::inst( 'pivittd.is_defaultprogram' ),
				Field::inst( 'pivittd.jumlah_unit' ),
				Field::inst( 'pivittd.jumlah_buy' ),
				Field::inst( 'pivittd.harga_unit' ),
				Field::inst( 'pivittd.harga_buy' ),
				Field::inst( 'pivittd.subtotal' ),
				Field::inst( 'pivittd.diskon_jenis' ),
				Field::inst( 'pivittd.diskon_value' ),
				Field::inst( 'pivittd.diskon_persen' ),
				Field::inst( 'pivittd.diskon_final' ),
				Field::inst( 'pivittd.dpp' ),

				Field::inst( 'iumxxmh.nama' ),
				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'prcxxth.kode' )
			)
			->leftJoin( 'iumxxmh','iumxxmh.id','=','pivittd.id_iumxxmh_unit' )
			->leftJoin( 'prcittd','prcittd.id','=','pivittd.id_prcittd' )
			->leftJoin( 'prcxxth','prcxxth.id','=','prcittd.id_prcxxth' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','pivittd.id_iimxxmh' )
			->where('pivittd.id_pivxxth',$_POST['id_pivxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_pivittd'] == 0){
			$editor
				->where( 'pivittd.transaction_state', -9, '<>');
		}
		
		// BEGIN log
		$nama_table = 'pivittd';
		$nama_table_before = 'prcittd';
		include( "pivittd_extra.php" );

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