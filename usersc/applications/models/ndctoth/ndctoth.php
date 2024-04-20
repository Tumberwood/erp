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
	
	$editor = Editor::inst( $db, 'ndctoth' )
		->debug(true)
		->fields(
			Field::inst( 'ndctoth.id' ),
			Field::inst( 'ndctoth.id_users_penerima' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'ndctoth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'ndctoth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'ndctoth.keterangan' ),
			Field::inst( 'ndctoth.created_by' ),
			Field::inst( 'ndctoth.transaction_state' ),
			Field::inst( 'ndctoth.approval_state' ),
			Field::inst( 'ndctoth.start_at' ),
			Field::inst( 'ndctoth.finish_at' ),
			Field::inst( 'ndctoth.is_defaultprogram' ),
			Field::inst( 'ndctoth.is_nextprocess' ),

			Field::inst( 'ndctoth.tanggal_jam_to' )
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
			'activity_log_ml_c.id_transaksi = ndctoth.id AND activity_log_ml_c.kode = "CREATE" AND activity_log_ml_c.nama = "ndctoth"', '', '' )

		->leftJoin( 'users as users_pengirim','users_pengirim.id','=','activity_log_ml_c.created_by' )
		->leftJoin( 'users as users_penerima','users_penerima.id','=','ndctoth.id_users_penerima' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_ndctoth'] == 0){
		$editor
			->where( 'ndctoth.transaction_state', -9, '<>');
	}
	
	include( "ndctoth_extra.php" );

	// BEGIN log
	$nama_table = 'ndctoth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>