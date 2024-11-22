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
	
	if ( ! isset($_POST['id_wktxxth']) || ! is_numeric($_POST['id_wktxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'wktlptd' )
			->debug(true)
			->fields(
				Field::inst( 'wktlptd.id' ),
				Field::inst( 'wktlptd.id_wktxxth' ),
				Field::inst( 'wktlptd.id_iumxxmh_default' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wktlptd.id_iumxxmh_terkecil' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wktlptd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wktlptd.id_wloxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wktlptd.id_wpcxxth' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wktlptd.kode' ),
				Field::inst( 'wktlptd.nama' ),
				Field::inst( 'wktlptd.keterangan' ),
				Field::inst( 'wktlptd.created_by' ),
				Field::inst( 'wktlptd.transaction_state' ),
				Field::inst( 'wktlptd.approval_state' ),
				Field::inst( 'wktlptd.start_at' ),
				Field::inst( 'wktlptd.finish_at' ),
				Field::inst( 'wktlptd.is_defaultprogram' ),
				Field::inst( 'wktlptd.is_nextprocess' ),
				Field::inst( 'wktlptd.jumlah_unit' ),
				Field::inst( 'wktlptd.jumlah_terkecil' ),
				Field::inst( 'wktlptd.jumlah_default' ),
				
				Field::inst( 'wktlptd.wlpxxmh_kode' ),
				Field::inst( 'wktlptd.expired_date' )
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
				Field::inst( 'wktlptd.batch_number' ),
				Field::inst( 'uom_default.kode' ),
				Field::inst( 'uom_terkecil.kode' ),
				Field::inst( 'wpcxxth.kode' ),
				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'wloxxmh.nama' ),
			)
			->leftJoin( 'iumxxmh as uom_default','uom_default.id','=','wktlptd.id_iumxxmh_default' )
			->leftJoin( 'iumxxmh as uom_terkecil','uom_terkecil.id','=','wktlptd.id_iumxxmh_terkecil' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','wktlptd.id_iimxxmh' )
			->leftJoin( 'wloxxmh','wloxxmh.id','=','wktlptd.id_wloxxmh' )
			->leftJoin( 'wpcxxth','wpcxxth.id','=','wktlptd.id_wpcxxth' )
			->where('wktlptd.id_wktxxth',$_POST['id_wktxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_wktlptd'] == 0){
			$editor
				->where( 'wktlptd.transaction_state', -9, '<>');
		}
		
		
		// BEGIN log
		$nama_table = 'wktlptd';
		$nama_table_before = 'wdoittd';
		include( "wktlptd_extra.php" );
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