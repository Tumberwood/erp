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
		$editor = Editor::inst( $db, 'wdnlptd' )
			->debug(true)
			->fields(
				Field::inst( 'wdnlptd.id' ),
				Field::inst( 'wdnlptd.id_wdnxxth' ),
				Field::inst( 'wdnlptd.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wdnlptd.id_iumxxmh_default' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wdnlptd.id_iumxxmh_terkecil' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wdnlptd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wdnlptd.id_wdplptd' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wdnlptd.id_wdoittd' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wdnlptd.kode' ),
				Field::inst( 'wdnlptd.nama' ),
				Field::inst( 'wdnlptd.keterangan' ),
				Field::inst( 'wdnlptd.created_by' ),
				Field::inst( 'wdnlptd.transaction_state' ),
				Field::inst( 'wdnlptd.approval_state' ),
				Field::inst( 'wdnlptd.start_at' ),
				Field::inst( 'wdnlptd.finish_at' ),
				Field::inst( 'wdnlptd.is_defaultprogram' ),
				Field::inst( 'wdnlptd.jumlah_unit' ),
				Field::inst( 'wdnlptd.jumlah_terkecil' ),
				Field::inst( 'wdnlptd.jumlah_default' ),
				
				Field::inst( 'wdnlptd.wlpxxmh_kode' ),
				Field::inst( 'wdnlptd.expired_date' )
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
				Field::inst( 'wdnlptd.batch_number' ),
				Field::inst( 'uom_default.kode' ),
				Field::inst( 'uom_terkecil.kode' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'wdplptd.kode' ),
			)
			->leftJoin( 'iumxxmh as uom_default','uom_default.id','=','wdnlptd.id_iumxxmh_default' )
			->leftJoin( 'iumxxmh as uom_terkecil','uom_terkecil.id','=','wdnlptd.id_iumxxmh_terkecil' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','wdnlptd.id_iimxxmh' )
			->leftJoin( 'wdplptd','wdplptd.id','=','wdnlptd.id_wdplptd' )
			->where('wdnlptd.id_wdnxxth',$_POST['id_wdnxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_wdnlptd'] == 0){
			$editor
				->where( 'wdnlptd.transaction_state', -9, '<>');
		}
		
		
		// BEGIN log
		$nama_table = 'wdnlptd';
		$nama_table_before = 'wdplptd';
		include( "wdnlptd_extra.php" );
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