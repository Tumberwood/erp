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
	
	$editor = Editor::inst( $db, 'ndixxth' )
		->debug(true)
		->fields(
			Field::inst( 'ndixxth.id' ),
			Field::inst( 'ndixxth.id_ndoxxth' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'ndixxth.id_users_penerima' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'ndixxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'ndixxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'ndixxth.keterangan' ),
			Field::inst( 'ndixxth.created_by' ),
			Field::inst( 'ndixxth.transaction_state' ),
			Field::inst( 'ndixxth.approval_state' ),
			Field::inst( 'ndixxth.start_at' ),
			Field::inst( 'ndixxth.finish_at' ),
			Field::inst( 'ndixxth.is_defaultprogram' ),

			Field::inst( 'ndixxth.tanggal_jam_ti' )
				->getFormatter( 'Format::datetime', array(
					'from' => 'Y-m-d H:i:s',
					'to' =>   'd M Y H:i'
				) )
				->setFormatter( 'Format::datetime', array(
					'from' => 'd M Y H:i',
					'to' =>   'Y-m-d H:i:s'
				) ),
			
			Field::inst( 'ndoxxth.kode' ),

			Field::inst( 'users_pengirim.username' ),
			Field::inst( 'users_penerima.username' )
		)
		->leftJoin( 'ndoxxth','ndoxxth.id','=','ndixxth.id_ndoxxth' )
		->leftJoin(
			'activity_log_ml as activity_log_ml_c', 
			'activity_log_ml_c.id_transaksi = ndixxth.id AND activity_log_ml_c.kode = "CREATE" AND activity_log_ml_c.nama = "ndixxth"', '', '' )

		->leftJoin( 'users as users_pengirim','users_pengirim.id','=','activity_log_ml_c.created_by' )
		->leftJoin( 'users as users_penerima','users_penerima.id','=','ndixxth.id_users_penerima' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_ndixxth'] == 0){
		$editor
			->where( 'ndixxth.transaction_state', -9, '<>');
	}
	
	include( "ndixxth_extra.php" );

	// BEGIN log
	$nama_table = 'ndixxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>