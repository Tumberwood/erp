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
	
	$editor = Editor::inst( $db, 'htsprrd' )
		->debug(true)
		->fields(
			Field::inst( 'htsprrd.id' ),
			Field::inst( 'htsprrd.id_hemxxmh' ),
			Field::inst( 'htsprrd.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'htsprrd.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'htsprrd.keterangan' ),
			Field::inst( 'htsprrd.created_by' ),
			Field::inst( 'htsprrd.transaction_state' ),
			Field::inst( 'htsprrd.approval_state' ),
			Field::inst( 'htsprrd.start_at' ),
			Field::inst( 'htsprrd.finish_at' ),
			Field::inst( 'htsprrd.is_defaultprogram' ),
			Field::inst( 'htsprrd.is_nextprocess' ),
			Field::inst( 'htsprrd.st_jadwal' ),
			Field::inst( 'htsprrd.clock_in' )
				->getFormatter( 'Format::datetime', array(
					'from' => 'Y-m-d H:i:s',
					'to' =>   'd M Y / H:i'
				) )
				->setFormatter( 'Format::datetime', array(
					'from' => 'd M Y / H:i',
					'to' =>   'Y-m-d H:i:s'
				) ),
			Field::inst( 'htsprrd.clock_out' )
				->getFormatter( 'Format::datetime', array(
					'from' => 'Y-m-d H:i:s',
					'to' =>   'd M Y / H:i'
				) )
				->setFormatter( 'Format::datetime', array(
					'from' => 'd M Y / H:i',
					'to' =>   'Y-m-d H:i:s'
				) ),
			Field::inst( 'htsprrd.status_presensi_in' ),
			Field::inst( 'htsprrd.status_presensi_out' ),
			Field::inst( 'htsprrd.htlxxrh_kode' ),
			Field::inst( 'htsprrd.st_clock_in' ),
			Field::inst( 'htsprrd.st_clock_out' ),
			Field::inst( 'htsprrd.tanggal' )
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
			Field::inst( 'hemxxmh.kode' ),
			Field::inst( 'hemxxmh.nama' ),
			Field::inst( 'hetxxmh.nama' ),
		)
		->leftJoin( 'hemxxmh','hemxxmh.id','=','htsprrd.id_hemxxmh' )
		->leftJoin( 'hemjbmh','hemjbmh.id_hemxxmh','=','hemxxmh.id' )
		->leftJoin( 'hetxxmh','hetxxmh.id','=','hemjbmh.id_hetxxmh' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_htsprrd'] == 0){
		$editor
			->where( 'htsprrd.transaction_state', -9,'<>');
	}
	
	// if ($_POST['status_approve'] == 0) {
	// 	$editor
	// 		->where( function ( $q ) {
	// 			$q->where( 'htsprrd.approval_state', '(0, -1)', 'IN', false);
	// 		} );
	// } else if($_POST['status_approve'] == 99) {
	// 	$editor
	// 		->where( function ( $q ) {
	// 			$q->where( 'htsprrd.approval_state', '(0, -1, -9, 1)', 'IN', false);
	// 		} );
	// } else {
	// 	$editor
	// 		->where( 'htsprrd.approval_state', $_POST['status_approve']);
	// }

	if ( $_POST['start_date'] != null){
		$editor
			->where( 'htsprrd.tanggal', $_POST['start_date'], '>=');
	}

	if ( $_POST['end_date'] != null){
		$editor
			->where( 'htsprrd.tanggal', $_POST['end_date'], '<=');
	}

	include( "htsprrd_extra.php" );

	// BEGIN log
	$nama_table = 'htsprrd';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>