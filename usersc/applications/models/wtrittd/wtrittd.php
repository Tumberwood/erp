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
	
	$editor = Editor::inst( $db, 'wtrittd' )
		->debug(true)
		->fields(
			Field::inst( 'wtrittd.id' ),
			Field::inst( 'wtrittd.id_gcpxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gcpxxmh),
			Field::inst( 'wtrittd.id_gbrxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gbrxxmh),
			Field::inst( 'wtrittd.id_wjtxxmh' )  //Master job_type
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wtrittd.id_wpttpmh' ) //Master Put Away, Seperti Normal, Marathon
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wtrittd.id_iwhxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wtrittd.id_wloxxmh_asal' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wtrittd.id_wloxxmh_tujuan' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wtrittd.id_iimxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wtrittd.id_iumxxmh_unit' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wtrittd.id_iumxxmh_terkecil' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wtrittd.id_iumxxmh_default' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wtrittd.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'wtrittd.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'wtrittd.keterangan' ),
			Field::inst( 'wtrittd.created_by' ),
			Field::inst( 'wtrittd.transaction_state' ),
			Field::inst( 'wtrittd.approval_state' ),
			Field::inst( 'wtrittd.start_at' ),
			Field::inst( 'wtrittd.finish_at' ),
			Field::inst( 'wtrittd.is_defaultprogram' ),
			Field::inst( 'wtrittd.is_nextprocess' ),
			Field::inst( 'wtrittd.is_gabung_lpn' ),

			Field::inst( 'wtrittd.wlpxxmh_kode' ),
			Field::inst( 'wtrittd.wlpxxmh_kode_tujuan' ),
			Field::inst( 'wtrittd.jumlah_unit' ),
			Field::inst( 'wtrittd.jumlah_konversi' ),
			Field::inst( 'wtrittd.expired_date' )
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
			Field::inst( 'wtrittd.batch_number' ),

			Field::inst( 'iimxxmh.kode' ),
			Field::inst( 'iimxxmh.nama' ),

			Field::inst( 'iumxxmh.kode' )
		)
		->leftJoin( 'iimxxmh','iimxxmh.id','=','wtrittd.id_iimxxmh' )
		->leftJoin( 'iumxxmh','iumxxmh.id','=','wtrittd.id_iumxxmh_unit' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_wtrittd'] == 0){
		$editor
			->where( 'wtrittd.transaction_state', -9, '<>');
	}
	
	
	// BEGIN log
	$nama_table = 'wtrittd';
	include( "wtrittd_extra.php" );
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>