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

	$editor = Editor::inst( $db, 'sqtxxth' )
		->debug(true)
		->fields(
			Field::inst( 'sqtxxth.id' ),
			Field::inst( 'sqtxxth.id_gcpxxmh' )
				->set( Field::SET_CREATE )
				->setValue(1),
			Field::inst( 'sqtxxth.id_gbrxxmh' )
				->set( Field::SET_CREATE )
				->setValue(1),
			Field::inst( 'sqtxxth.id_grlxxmh_customer' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sqtxxth.id_fpytmmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sqtxxth.id_fcrxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sqtxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'sqtxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'sqtxxth.keterangan' ),
			Field::inst( 'sqtxxth.created_by' ),
			Field::inst( 'sqtxxth.transaction_state' ),
			Field::inst( 'sqtxxth.approval_state' ),
			Field::inst( 'sqtxxth.start_at' ),
			Field::inst( 'sqtxxth.finish_at' ),
			Field::inst( 'sqtxxth.is_defaultprogram' ),
			Field::inst( 'sqtxxth.is_nextprocess' ),
			Field::inst( 'sqtxxth.tanggal' )
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
			Field::inst( 'sqtxxth.tanggal_validity' )
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
			Field::inst( 'sqtxxth.up1' ),

			Field::inst( 'sqtxxth.subtotal' ),
			Field::inst( 'sqtxxth.diskon_jenis' ),
			Field::inst( 'sqtxxth.diskon_value' ),
			Field::inst( 'sqtxxth.diskon_persen' ),
			Field::inst( 'sqtxxth.diskon_final' ),
			Field::inst( 'sqtxxth.dpp' ),
			Field::inst( 'sqtxxth.dpp_final' ),

			Field::inst( 'sqtxxth.is_pajak' ),
			Field::inst( 'sqtxxth.pajak_in_ex' ),
			Field::inst( 'sqtxxth.pajak_jenis' ),
			Field::inst( 'sqtxxth.pajak_persen' ),
			Field::inst( 'sqtxxth.pajak_final' ),
			Field::inst( 'sqtxxth.grand_total' ),

			Field::inst( 'grlxxmh.nama' ),
			
			Field::inst( 'activity_log_ml_c.created_by' )
		)
		->leftJoin( 'grlxxmh','grlxxmh.id','=','sqtxxth.id_grlxxmh_customer' )
		->leftJoin( 
			'activity_log_ml as activity_log_ml_c', 
			'activity_log_ml_c.id_transaksi = sqtxxth.id AND activity_log_ml_c.kode = "CREATE" AND activity_log_ml_c.nama = "sqtxxth"', '', '' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_sqtxxth'] == 0){
		$editor
			->where( 'sqtxxth.transaction_state', -9, '<>');
	}
	
	if($s_id_users > 100){
		if($s_where_data_permission == 1){
			$editor->where('activity_log_ml_c.created_by', $s_id_users);
		}else{
			
		}
	}

	include( "sqtxxth_extra.php" );


	// BEGIN log
	$nama_table = 'sqtxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>