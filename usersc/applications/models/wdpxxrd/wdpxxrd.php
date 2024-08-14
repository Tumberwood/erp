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
	
	$editor = Editor::inst( $db, 'wdplptd' )
		->debug(true)
		->fields(
			Field::inst( 'wdplptd.id' ),
			Field::inst( 'wdplptd.id_wdpxxth' ),
			Field::inst( 'wdplptd.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'wdplptd.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'wdplptd.keterangan' ),
			Field::inst( 'wdplptd.id_iumxxmh_unit' ),
			Field::inst( 'wdplptd.id_iimxxmh' ),
			Field::inst( 'wdplptd.created_by' ),
			Field::inst( 'wdpxxth.transaction_state' ),
			Field::inst( 'wdplptd.transaction_state' ),
			Field::inst( 'wdplptd.approval_state' ),
			Field::inst( 'wdplptd.start_at' ),
			Field::inst( 'wdplptd.finish_at' ),
			Field::inst( 'wdplptd.jumlah_unit' ),
			Field::inst( 'wdplptd.jumlah_terkecil' ),
			Field::inst( 'wdplptd.wlpxxmh_kode' ),
			Field::inst( 'wdplptd.batch_number' ),
			Field::inst( 'wdplptd.expired_date' )
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
			Field::inst( 'wdplptd.is_nextprocess' ),

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
			Field::inst( 'iwhxxmh.nama' ),
			Field::inst( 'wdplptd.is_defaultprogram' ),
			Field::inst( 'asal.nama' ),
			Field::inst( 'tujuan.nama' ),
		)
		->leftJoin( 'wdpxxth','wdpxxth.id','=','wdplptd.id_wdpxxth' )
		->leftJoin( 'wloxxmh asal','asal.id','=','wdplptd.id_wloxxmh_asal' )
		->leftJoin( 'wloxxmh tujuan','tujuan.id','=','wdplptd.id_wloxxmh_tujuan' )
		->leftJoin( 'iimxxmh','iimxxmh.id','=','wdplptd.id_iimxxmh' )
		->leftJoin( 'iwhxxmh','iwhxxmh.id','=','wdplptd.id_iwhxxmh' )
		->leftJoin( 'iumxxmh','iumxxmh.id','=','wdplptd.id_iumxxmh_unit' )
		->leftJoin(
			'activity_log_ml as activity_log_ml_confirm', 
			'activity_log_ml_confirm.id_transaksi = wdplptd.id AND activity_log_ml_confirm.kode = "CONFIRM" AND activity_log_ml_confirm.nama = "wdplptd"', '', '' )
		;

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_wdpxxth'] == 0){
		$editor
			->where( 'wdplptd.transaction_state', -9, '<>');
	}
	
	// BEGIN log
	$nama_table = 'wdplptd';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>