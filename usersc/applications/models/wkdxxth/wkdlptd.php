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
	
	if ( ! isset($_POST['id_wkdxxth']) || ! is_numeric($_POST['id_wkdxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'wkdlptd' )
			->debug(true)
			->fields(
				Field::inst( 'wkdlptd.id' ),
				Field::inst( 'wkdlptd.id_wkdxxth' ),
				Field::inst( 'wkdlptd.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wkdlptd.id_iumxxmh_default' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wkdlptd.id_iumxxmh_terkecil' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wkdlptd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wkdlptd.id_iwhxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wkdlptd.id_wloxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wkdlptd.id_wpcxxth' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wkdlptd.kode' ),
				Field::inst( 'wkdlptd.wloxxmh_nama' ),
				Field::inst( 'wkdlptd.nama' ),
				Field::inst( 'wkdlptd.keterangan' ),
				Field::inst( 'wkdlptd.created_by' ),
				Field::inst( 'wkdlptd.transaction_state' ),
				Field::inst( 'wkdlptd.approval_state' ),
				Field::inst( 'wkdlptd.start_at' ),
				Field::inst( 'wkdlptd.finish_at' ),
				Field::inst( 'wkdlptd.is_defaultprogram' ),
				Field::inst( 'wkdlptd.is_nextprocess' ),
				Field::inst( 'wkdlptd.jumlah_unit' ),
				Field::inst( 'wkdlptd.jumlah_terkecil' ),
				Field::inst( 'wkdlptd.jumlah_default' ),
				Field::inst( 'wkdlptd.id_wjtxxmh' )
				->set( Field::SET_CREATE )
				->setValue('1'),
				
				Field::inst( 'wkdlptd.wlpxxmh_kode' ),
				Field::inst( 'wkdlptd.expired_date' )
					->getFormatter( function ( $val, $data, $opts ) {
						if ($val === '0000-00-00' || $val === null){
							return '';
						}else{
							return date( 'd M Y', strtotime( $val ) );
						}
					} )
					->setFormatter( 'Format::datetime', array(
						'from' => 'd M Y',
						'to' =>   'Y-m-d'
					) ),
				Field::inst( 'wkdlptd.batch_number' ),
				Field::inst( 'uom_default.kode' ),
				Field::inst( 'uom_terkecil.kode' ),
				Field::inst( 'wpcxxth.kode' ),
				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'wloxxmh.nama' ),
			)
			->leftJoin( 'iumxxmh as uom_default','uom_default.id','=','wkdlptd.id_iumxxmh_default' )
			->leftJoin( 'iumxxmh as uom_terkecil','uom_terkecil.id','=','wkdlptd.id_iumxxmh_terkecil' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','wkdlptd.id_iimxxmh' )
			->leftJoin( 'wloxxmh','wloxxmh.id','=','wkdlptd.id_wloxxmh' )
			->leftJoin( 'wpcxxth','wpcxxth.id','=','wkdlptd.id_wpcxxth' )
			->where('wkdlptd.id_wkdxxth',$_POST['id_wkdxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_wkdlptd'] == 0){
			$editor
				->where( 'wkdlptd.transaction_state', -9, '<>');
		}
		
		
		// BEGIN log
		$nama_table = 'wkdlptd';
		$nama_table_before = 'wdoittd';
		include( "wkdlptd_extra.php" );
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