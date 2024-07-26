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
	
	$editor = Editor::inst( $db, 'ndcrctd' )
		->debug(true)
		->fields(
			Field::inst( 'ndcrctd.id' ),
			Field::inst( 'ndcrctd.id_grlxxmh_expedisi' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'ndcrctd.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'ndcrctd.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'ndcrctd.keterangan' ),
			Field::inst( 'ndcrctd.created_by' ),
			Field::inst( 'ndcrctd.transaction_state' ),
			Field::inst( 'ndcrctd.approval_state' ),
			Field::inst( 'ndcrctd.start_at' ),
			Field::inst( 'ndcrctd.finish_at' ),
			Field::inst( 'ndcrctd.is_nextprocess' ),
			Field::inst( 'ndcrctd.is_defaultprogram' ),

			
			Field::inst( 'ndcrctd.tanggal_jam_terima' )
				->getFormatter( 'Format::datetime', array(
					'from' => 'Y-m-d H:i:s',
					'to' =>   'd M Y H:i'
				) )
				->setFormatter( 'Format::datetime', array(
					'from' => 'd M Y H:i',
					'to' =>   'Y-m-d H:i:s'
				) ),
			Field::inst( 'ndcrctd.pengirim' ),
			Field::inst( 'ndcrctd.kepada' ),

			Field::inst( 'grlxxmh.nama' ),

			Field::inst( 'ndcxxmh.dokumen_nomor' ),
			Field::inst( 'ndcxxmh.keterangan' )
		)
		->leftJoin( 'grlxxmh','grlxxmh.id','=','ndcrctd.id_grlxxmh_expedisi' )
		->leftJoin( 'ndcxxmh','ndcxxmh.id','=','ndcrctd.id_ndcxxmh' );

	if($_POST['start_date'] != ''){
		$editor->where( 'DATE(ndcrctd.tanggal_jam_terima)',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'DATE(ndcrctd.tanggal_jam_terima)', $_POST['end_date'], '<=' );
	}
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_ndcrctd'] == 0){
		$editor
			->where( 'ndcrctd.transaction_state', -9, '<>');
	}
	
	include( "ndcrctd_extra.php" );

	// BEGIN log
	$nama_table = 'ndcrctd';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>