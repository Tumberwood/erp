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
	
	$editor = Editor::inst( $db, 'wreittd' )
		->debug(true)
		->fields(
			Field::inst( 'wreittd.id' ),
			Field::inst( 'wreittd.id_gcpxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gcpxxmh),
			Field::inst( 'wreittd.id_gbrxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gbrxxmh),
			Field::inst( 'wreittd.id_iwhxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wreittd.id_wloxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wreittd.id_wroittd' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wreittd.id_wroxxth' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wreittd.id_grlxxmh_supplier' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wreittd.id_wlpxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wreittd.id_iimxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wreittd.id_iumxxmh_unit' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wreittd.id_iumxxmh_terkecil' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wreittd.id_iumxxmh_default' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wreittd.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'wreittd.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'wreittd.keterangan' ),
			Field::inst( 'wreittd.created_by' ),
			Field::inst( 'wreittd.transaction_state' ),
			Field::inst( 'wreittd.approval_state' ),
			Field::inst( 'wreittd.start_at' ),
			Field::inst( 'wreittd.finish_at' ),
			Field::inst( 'wreittd.is_defaultprogram' ),
			Field::inst( 'wreittd.is_nextprocess' ),

			Field::inst( 'wreittd.wlpxxmh_kode' ),
			Field::inst( 'wreittd.wpaxxmh_kode' )
			->set( Field::SET_CREATE )
			->setValue('Pallet 1'),
			Field::inst( 'wreittd.jumlah_unit' ),
			Field::inst( 'wreittd.jumlah_konversi' ),
			Field::inst( 'wreittd.expired_date' )
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
			Field::inst( 'wreittd.batch_number' ),

			Field::inst( 'grlxxmh.nama' ),
			
			Field::inst( 'iimxxmh.kode' ),
			Field::inst( 'iimxxmh.nama' ),
			Field::inst( 'activity_log_ml_confirm.finish_on as tanggal_confirm' )
				->getFormatter( 'Format::datetime', array(
					'from' => 'Y-m-d H:i:s',
					'to' =>   'd M Y H:i'
				) )
				->setFormatter( 'Format::datetime', array(
					'from' => 'd M Y H:i',
					'to' =>   'Y-m-d H:i:s'
				) ),

			Field::inst( 'iumxxmh.kode' ),
			Field::inst( 'wloxxmh.nama' ),
			Field::inst( 'iwhxxmh.kode' ),
			Field::inst( 'activity_log_ml_confirm.username as username' ),
			
		)
		->leftJoin( 'wroxxth','wroxxth.id','=','wreittd.id_wroxxth' )
		->leftJoin( 'iimxxmh','iimxxmh.id','=','wreittd.id_iimxxmh' )
		->leftJoin( 'wloxxmh','wloxxmh.id','=','wreittd.id_wloxxmh' )
		->leftJoin( 'iwhxxmh','iwhxxmh.id','=','wreittd.id_iwhxxmh' )
		->leftJoin( 'iumxxmh','iumxxmh.id','=','wreittd.id_iumxxmh_unit' )
		->leftJoin( 'grlxxmh','grlxxmh.id','=','wroxxth.id_grlxxmh_supplier' )
		->leftJoin(
			'activity_log_ml as activity_log_ml_confirm', 
			'activity_log_ml_confirm.id_transaksi = wreittd.id AND activity_log_ml_confirm.kode = "CONFIRM" AND activity_log_ml_confirm.nama = "wreittd"', '', '' )
		// ->where( 'DATE(activity_log_ml_c.created_on)', $_POST['start_date'], '>=' )
		// ->where( 'DATE(activity_log_ml_c.created_on)', $_POST['end_date'], '<=' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_wreittd'] == 0){
		$editor
			->where( 'wreittd.transaction_state', -9, '<>');
	}
	
	
	//Extra kalkulasi jumlah_unit_os
	$nama_table        = 'wreittd';
	$nama_table_before = 'wroittd';
	include( "wreittd_extra.php" );
	// include( "../../../helpers/fn_extra_transaksi_before.php" );

	// BEGIN log
	$nama_table = 'wreittd';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>