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
	
	if ( ! isset($_POST['id_wplxxth']) || ! is_numeric($_POST['id_wplxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'wpllptd' )
			->debug(true)
			->fields(
				Field::inst( 'wpllptd.id' ),
				Field::inst( 'wpllptd.id_wplxxth' ),
				Field::inst( 'wpllptd.id_iumxxmh_default' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wpllptd.id_iumxxmh_terkecil' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wpllptd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wpllptd.id_wloxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wpllptd.id_wpcxxth' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wpllptd.kode' ),
				Field::inst( 'wpllptd.nama' ),
				Field::inst( 'wpllptd.keterangan' ),
				Field::inst( 'wpllptd.created_by' ),
				Field::inst( 'wpllptd.transaction_state' ),
				Field::inst( 'wpllptd.approval_state' ),
				Field::inst( 'wpllptd.start_at' ),
				Field::inst( 'wpllptd.finish_at' ),
				Field::inst( 'wpllptd.is_defaultprogram' ),
				Field::inst( 'wpllptd.jumlah_unit' ),
				Field::inst( 'wpllptd.jumlah_terkecil' ),
				Field::inst( 'wpllptd.jumlah_default' ),
				
				Field::inst( 'wpllptd.wlpxxmh_kode' ),
				Field::inst( 'wpllptd.expired_date' )
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
				Field::inst( 'wpllptd.batch_number' ),
				Field::inst( 'uom_default.kode' ),
				Field::inst( 'uom_terkecil.kode' ),
				Field::inst( 'wpcxxth.kode' ),
				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'wloxxmh.nama' ),
			)
			->leftJoin( 'iumxxmh as uom_default','uom_default.id','=','wpllptd.id_iumxxmh_default' )
			->leftJoin( 'iumxxmh as uom_terkecil','uom_terkecil.id','=','wpllptd.id_iumxxmh_terkecil' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','wpllptd.id_iimxxmh' )
			->leftJoin( 'wloxxmh','wloxxmh.id','=','wpllptd.id_wloxxmh' )
			->leftJoin( 'wpcxxth','wpcxxth.id','=','wpllptd.id_wpcxxth' )
			->where('wpllptd.id_wplxxth',$_POST['id_wplxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_wpllptd'] == 0){
			$editor
				->where( 'wpllptd.transaction_state', -9, '<>');
		}
		
		
		// BEGIN log
		$nama_table = 'wpllptd';
		$nama_table_before = 'wdoittd';
		include( "wpllptd_extra.php" );
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