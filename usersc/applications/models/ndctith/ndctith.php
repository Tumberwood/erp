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
	
	$editor = Editor::inst( $db, 'ndctith' )
		->debug(true)
		->fields(
			Field::inst( 'ndctith.id' ),
			Field::inst( 'ndctith.id_ndctoth' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'ndctith.id_users_penerima' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'ndctith.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'ndctith.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'ndctith.keterangan' ),
			Field::inst( 'ndctith.created_by' ),
			Field::inst( 'ndctith.transaction_state' ),
			Field::inst( 'ndctith.approval_state' ),
			Field::inst( 'ndctith.start_at' ),
			Field::inst( 'ndctith.finish_at' ),
			Field::inst( 'ndctith.is_defaultprogram' ),

			Field::inst( 'ndctith.tanggal_jam_ti' )
				->getFormatter( 'Format::datetime', array(
					'from' => 'Y-m-d H:i:s',
					'to' =>   'd M Y H:i'
				) )
				->setFormatter( 'Format::datetime', array(
					'from' => 'd M Y H:i',
					'to' =>   'Y-m-d H:i:s'
				) ),
			
			Field::inst( 'ndctoth.kode' ),

			Field::inst( 'users_pengirim.username' ),
			Field::inst( 'users_penerima.username' )
		)
		->leftJoin( 'ndctoth','ndctoth.id','=','ndctith.id_ndctoth' )
		->leftJoin(
			'activity_log_ml as activity_log_ml_c', 
			'activity_log_ml_c.id_transaksi = ndctith.id AND activity_log_ml_c.kode = "CREATE" AND activity_log_ml_c.nama = "ndctith"', '', '' )

		->leftJoin( 'users as users_pengirim','users_pengirim.id','=','activity_log_ml_c.created_by' )
		->leftJoin( 'users as users_penerima','users_penerima.id','=','ndctith.id_users_penerima' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_ndctith'] == 0){
		$editor
			->where( 'ndctith.transaction_state', -9, '<>');
	}
	
	include( "ndctith_extra.php" );

	// BEGIN log
	$nama_table = 'ndctith';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>