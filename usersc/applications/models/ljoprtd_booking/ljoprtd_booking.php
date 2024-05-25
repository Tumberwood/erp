<?php
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../helpers/hakakses_s_fn.php" );
	
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
	
	$editor = Editor::inst( $db, 'ljoxxth' )
		->debug(true)
		->fields(

			Field::inst( 'ljoxxth.id' ),
			Field::inst( 'ljoxxth.id_lacxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'ljoxxth.id_lvtxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'ljoxxth.id_lprxxmh_last' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'ljoxxth.id_grlxxmh_expedition' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'ljoxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'ljoxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'ljoxxth.keterangan' ),
			Field::inst( 'ljoxxth.created_by' ),
			Field::inst( 'ljoxxth.transaction_state' ),
			Field::inst( 'ljoxxth.approval_state' ),
			Field::inst( 'ljoxxth.start_at' ),
			Field::inst( 'ljoxxth.finish_at' ),
			Field::inst( 'ljoxxth.is_defaultprogram' ),
			Field::inst( 'ljoxxth.is_nextprocess' ),
			Field::inst( 'ljoxxth.tanggal' )
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
			Field::inst( 'ljoxxth.supir_nama' ),
			Field::inst( 'ljoxxth.kernet_nama' ),
			Field::inst( 'ljoxxth.berat_muatan' ),
			Field::inst( 'ljoxxth.dimensi_muatan' ),
			Field::inst( 'ljoxxth.plat_no' ),

			Field::inst( 'ljoprtd.id' ),
			Field::inst( 'ljoprtd.id_ljoxxth' ),
			Field::inst( 'ljoprtd.id_lprxxmh' ),
			Field::inst( 'ljoprtd.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'ljoprtd.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'ljoprtd.keterangan' ),
			Field::inst( 'ljoprtd.created_by' ),
			Field::inst( 'ljoprtd.transaction_state' ),
			Field::inst( 'ljoprtd.approval_state' ),
			Field::inst( 'ljoprtd.start_at' ),
			Field::inst( 'ljoprtd.finish_at' ),
			Field::inst( 'ljoprtd.is_defaultprogram' ),
			Field::inst( 'ljoprtd.tanggaljam_start' )
				->getFormatter( 'Format::datetime', array(
					'from' => 'Y-m-d H:i:s',
					'to' =>   'd M Y H:i'
				) ),
			Field::inst( 'ljoprtd.tanggaljam_finish' )
				->getFormatter( 'Format::datetime', array(
					'from' => 'Y-m-d H:i:s',
					'to' =>   'd M Y H:i'
				) ),
			Field::inst( 'ljoprtd.durasi_detik' ),

			Field::inst( 'lacxxmh.nama' ),
			Field::inst( 'lvtxxmh.nama' ),
			Field::inst( 'grlxxmh.nama' )
		)
		->leftJoin( 'ljoprtd','ljoprtd.id_ljoxxth','=','ljoxxth.id' )
		// ->leftJoin( 'ljoprtd','ljoprtd.id_ljoxxth = ljoxxth.id AND ljoprtd.id_lprxxmh = 1','','' )
		->leftJoin( 'lacxxmh','lacxxmh.id','=','ljoxxth.id_lacxxmh' )
		->leftJoin( 'lvtxxmh','lvtxxmh.id','=','ljoxxth.id_lvtxxmh' )
		->leftJoin( 'grlxxmh','grlxxmh.id','=','ljoxxth.id_grlxxmh_expedition' )
		// ->where( 'ljoxxth.id_lprxxmh_last', 1 )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_ljoxxth'] == 0){
		$editor
			->where( 'ljoxxth.transaction_state', -9, '<>');
	}
	
	include( "ljoprtd_booking_extra.php" );

	// BEGIN log
	$nama_table = 'ljoxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>