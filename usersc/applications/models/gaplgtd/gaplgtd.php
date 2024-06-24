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
	
	$editor = Editor::inst( $db, 'gaplgtd' )
		->debug(true)
		->fields(
			Field::inst( 'gaplgtd.id' ),
			Field::inst( 'gaplgtd.id_users' ),
			Field::inst( 'gaplgtd.id_users_pengaju' ),
			Field::inst( 'gaplgtd.id_transaksi' ),
			Field::inst( 'gaplgtd.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'gaplgtd.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'gaplgtd.keterangan' ),
			Field::inst( 'gaplgtd.created_by' ),
			Field::inst( 'gaplgtd.transaction_state' ),
			Field::inst( 'gaplgtd.approval_state' ),
			Field::inst( 'gaplgtd.start_at' ),
			Field::inst( 'gaplgtd.finish_at' ),
			Field::inst( 'gaplgtd.is_defaultprogram' ),
			Field::inst( 'gaplgtd.tbl_name' ),
			Field::inst( 'gaplgtd.dt_pengajuan' )
				->getFormatter( 'Format::datetime', array(
					'from' => 'Y-m-d H:i:s',
					'to' =>   'd M Y H:i:s'
				) ),

			Field::inst( 'users_penyetuju.username' ),
			Field::inst( 'users_pengaju.username' )
		)
		->leftJoin( 'users as users_penyetuju','users_penyetuju.id','=','gaplgtd.id_users' )
		->leftJoin( 'users as users_pengaju','users_pengaju.id','=','gaplgtd.id_users_pengaju' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_gaplgtd'] == 0){
		$editor
			->where( 'gaplgtd.transaction_state', -9, '<>');
	}
	
	if($s_id_users > 100){
		$editor->where('gaplgtd.id_users', $s_id_users);
	}

	include( "gaplgtd_extra.php" );

	// BEGIN log
	$nama_table = 'gaplgtd';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>