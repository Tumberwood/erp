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
	
	if ( ! isset($_POST['id_wpkxxth']) || ! is_numeric($_POST['id_wpkxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'wpkittd' )
			->debug(true)
			->fields(
				Field::inst( 'wpkittd.id' ),
				Field::inst( 'wpkittd.id_wpkxxth' ),
				Field::inst( 'wpkittd.kode' ),
				Field::inst( 'wpkittd.nama' ),
				Field::inst( 'wpkittd.keterangan' ),
				Field::inst( 'wpkittd.created_by' ),
				Field::inst( 'wpkittd.transaction_state' ),
				Field::inst( 'wpkittd.approval_state' ),
				Field::inst( 'wpkittd.start_at' ),
				Field::inst( 'wpkittd.finish_at' ),
				Field::inst( 'wpkittd.is_nextprocess' ),
				Field::inst( 'wpkittd.is_defaultprogram' ),
				Field::inst( 'wpkittd.wlpxxmh_kode' ),
				Field::inst( 'wpkittd.batch_number' ),
				Field::inst( 'wpkittd.jumlah_default' ),
				Field::inst( 'wpkittd.jumlah_terkecil' ),
				Field::inst( 'wpkittd.jumlah_unit' ),
				Field::inst( 'wpkittd.expired_date' )
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
				Field::inst( 'wpkittd.is_defaultprogram' ),
				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iumxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'iwhxxmh.kode' ),
				Field::inst( 'asal.nama' ),
				Field::inst( 'tujuan.nama' ),
			)
			->leftJoin( 'iimxxmh','iimxxmh.id','=','wpkittd.id_iimxxmh' )
			->leftJoin( 'iumxxmh','iumxxmh.id','=','wpkittd.id_iumxxmh_unit' )
			->leftJoin( 'iwhxxmh','iwhxxmh.id','=','wpkittd.id_iwhxxmh' )
			->leftJoin( 'wloxxmh asal','asal.id','=','wpkittd.id_wloxxmh_asal' )
			->leftJoin( 'wloxxmh tujuan','tujuan.id','=','wpkittd.id_wloxxmh_tujuan' )
			->where('wpkittd.id_wpkxxth',$_POST['id_wpkxxth'])
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_wpkittd'] == 0){
			$editor
				->where( 'wpkittd.transaction_state', -9, '<>');
		}
		
		include( "wpkittd_extra.php" );

		// BEGIN log
		$nama_table = 'wpkittd';
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