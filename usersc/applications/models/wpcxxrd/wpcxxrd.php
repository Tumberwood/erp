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
	
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];

	$editor = Editor::inst( $db, 'wpclptd' )
		->debug(true)
		->fields(
			Field::inst( 'wpclptd.id' ),
			Field::inst( 'wpclptd.id_wpcxxth' ),
			Field::inst( 'wpclptd.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'wpclptd.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'wpclptd.keterangan' ),
			Field::inst( 'wpclptd.id_iumxxmh_unit' ),
			Field::inst( 'wpclptd.id_iimxxmh' ),
			Field::inst( 'wpclptd.created_by' ),
			Field::inst( 'wpcxxth.transaction_state' ),
			Field::inst( 'wpclptd.transaction_state' ),
			Field::inst( 'wpclptd.approval_state' ),
			Field::inst( 'wpclptd.start_at' ),
			Field::inst( 'wpclptd.finish_at' ),
			Field::inst( 'wpclptd.jumlah_unit' ),
			Field::inst( 'wpclptd.jumlah_terkecil' ),
			Field::inst( 'wpclptd.wlpxxmh_kode' ),
			Field::inst( 'wpclptd.batch_number' ),
			Field::inst( 'wpclptd.expired_date' )
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
			Field::inst( 'wpclptd.is_nextprocess' ),
			Field::inst( 'wpclptd.status_dispatch' ),

			Field::inst( 'activity_log_ml_confirm.finish_on as tanggal_confirm' )
				->getFormatter( 'Format::datetime', array(
					'from' => 'Y-m-d H:i:s',
					'to' =>   'd M Y H:i'
				) )
				->setFormatter( 'Format::datetime', array(
					'from' => 'd M Y H:i',
					'to' =>   'Y-m-d H:i:s'
				) ),
			Field::inst( 'iimxxmh.kode' ),
			Field::inst( 'iumxxmh.kode' ),
			Field::inst( 'iimxxmh.nama' ),
			Field::inst( 'wpclptd.is_defaultprogram' ),
			Field::inst( 'iwhxxmh.kode' ),
			Field::inst( 'asal.nama' ),
			Field::inst( 'tujuan.nama' ),
			Field::inst( 'activity_log_ml_confirm.username as username' ),
		)
		->leftJoin( 'wpcxxth','wpcxxth.id','=','wpclptd.id_wpcxxth' )
		->leftJoin( 'iimxxmh','iimxxmh.id','=','wpclptd.id_iimxxmh' )
		->leftJoin( 'iumxxmh','iumxxmh.id','=','wpclptd.id_iumxxmh_unit' )
		->leftJoin( 'iwhxxmh','iwhxxmh.id','=','wpclptd.id_iwhxxmh' )
		->leftJoin( 'wloxxmh asal','asal.id','=','wpclptd.id_wloxxmh_asal' )
		->leftJoin( 'wloxxmh tujuan','tujuan.id','=','wpclptd.id_wloxxmh_tujuan' )
		->leftJoin(
			'activity_log_ml as activity_log_ml_confirm', 
			'activity_log_ml_confirm.id_transaksi = wpclptd.id AND activity_log_ml_confirm.kode = "CONFIRM" AND activity_log_ml_confirm.nama = "wpclptd"', '', '' )
		
		->where( 'activity_log_ml_confirm.finish_on', $start_date, '>=' )
		->where( 'activity_log_ml_confirm.finish_on', $end_date, '<=' )
		;

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_wpcxxth'] == 0){
		$editor
			->where( 'wpclptd.transaction_state', -9, '<>');
	}
	
	// BEGIN log
	$nama_table = 'wpclptd';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>