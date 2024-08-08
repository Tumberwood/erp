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
	
	$editor = Editor::inst( $db, 'wptittd' )
		->debug(true)
		->fields(
			Field::inst( 'wptittd.id' ),
			Field::inst( 'wptittd.id_gcpxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gcpxxmh),
			Field::inst( 'wptittd.id_gbrxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gbrxxmh),
			Field::inst( 'wptittd.id_wjtxxmh' )  //Master job_type
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wptittd.id_wpttpmh' ) //Master Put Away, Seperti Normal, Marathon
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wptittd.id_iwhxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wptittd.id_wloxxmh_asal' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wptittd.id_wloxxmh_tujuan' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wptittd.id_iimxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wptittd.id_iumxxmh_unit' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wptittd.id_iumxxmh_terkecil' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wptittd.id_iumxxmh_default' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wptittd.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'wptittd.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'wptittd.keterangan' ),
			Field::inst( 'wptittd.created_by' ),
			Field::inst( 'wptittd.transaction_state' ),
			Field::inst( 'wptittd.approval_state' ),
			Field::inst( 'wptittd.start_at' ),
			Field::inst( 'wptittd.finish_at' ),
			Field::inst( 'wptittd.is_defaultprogram' ),
			Field::inst( 'wptittd.is_nextprocess' ),
			Field::inst( 'wptittd.is_drop' ),

			Field::inst( 'wptittd.wlpxxmh_kode' ),
			Field::inst( 'wptittd.jumlah_unit' ),
			Field::inst( 'wptittd.jumlah_konversi' ),
			Field::inst( 'wptittd.expired_date' )
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
			Field::inst( 'wptittd.batch_number' ),
			Field::inst( 'wptittd.is_cancel_drop' ),

			Field::inst( 'iimxxmh.kode' ),
			Field::inst( 'iimxxmh.nama' ),
			Field::inst( 'wloxxmh.nama' ),

			Field::inst( 'iumxxmh.kode' )
		)
		->leftJoin( 'iimxxmh','iimxxmh.id','=','wptittd.id_iimxxmh' )
		->leftJoin( 'iumxxmh','iumxxmh.id','=','wptittd.id_iumxxmh_unit' )
		->leftJoin( 'wloxxmh','wloxxmh.id','=','wptittd.id_wloxxmh_tujuan' )
		->where( 'DATE(wptittd.start_at)', $start_date, '>=' )
		->where( 'DATE(wptittd.start_at)', $end_date, '<=' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_wptittd'] == 0){
		$editor
			->where( 'wptittd.transaction_state', -9, '<>');
	}
	
	
	// BEGIN log
	$nama_table = 'wptittd';
	include( "wptittd_extra.php" );
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>