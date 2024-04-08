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
	
	$editor = Editor::inst( $db, 'ndoxxth' )
		->debug(true)
		->fields(
			Field::inst( 'ndoxxth.id' ),
			Field::inst( 'ndoxxth.id_users_penerima' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'ndoxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'ndoxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'ndoxxth.keterangan' ),
			Field::inst( 'ndoxxth.created_by' ),
			Field::inst( 'ndoxxth.transaction_state' ),
			Field::inst( 'ndoxxth.approval_state' ),
			Field::inst( 'ndoxxth.start_at' ),
			Field::inst( 'ndoxxth.finish_at' ),
			Field::inst( 'ndoxxth.is_defaultprogram' ),
			Field::inst( 'ndoxxth.is_nextprocess' ),

			Field::inst( 'ndoxxth.tanggal_jam_to' )
				->getFormatter( 'Format::datetime', array(
					'from' => 'Y-m-d H:i:s',
					'to' =>   'd M Y H:i'
				) )
				->setFormatter( 'Format::datetime', array(
					'from' => 'd M Y H:i',
					'to' =>   'Y-m-d H:i:s'
				) ),

			Field::inst( 'users_pengirim.username' ),
			Field::inst( 'users_penerima.username' )
		)
		->leftJoin(
			'activity_log_ml as activity_log_ml_c', 
			'activity_log_ml_c.id_transaksi = ndoxxth.id AND activity_log_ml_c.kode = "CREATE" AND activity_log_ml_c.nama = "ndoxxth"', '', '' )

		->leftJoin( 'users as users_pengirim','users_pengirim.id','=','activity_log_ml_c.created_by' )
		->leftJoin( 'users as users_penerima','users_penerima.id','=','ndoxxth.id_users_penerima' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_ndoxxth'] == 0){
		$editor
			->where( 'ndoxxth.transaction_state', -9, '<>');
	}
	
	include( "ndoxxth_extra.php" );

	// BEGIN log
	$nama_table = 'ndoxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>