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
	
	$editor = Editor::inst( $db, 'wdoxxth' )
		->debug(true)
		->fields(
			Field::inst( 'wdoxxth.id' ),
			Field::inst( 'wdoxxth.id_gcpxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gcpxxmh),
			Field::inst( 'wdoxxth.id_gbrxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gbrxxmh),
			Field::inst( 'wdoxxth.id_iitxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wdoxxth.id_grlxxmh_customer' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wdoxxth.id_fpytmmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wdoxxth.id_fcrxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wdoxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'wdoxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'wdoxxth.keterangan' ),
			Field::inst( 'wdoxxth.created_by' ),
			Field::inst( 'wdoxxth.transaction_state' ),
			Field::inst( 'wdoxxth.approval_state' ),
			Field::inst( 'wdoxxth.start_at' ),
			Field::inst( 'wdoxxth.finish_at' ),
			Field::inst( 'wdoxxth.tanggal' )
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
			Field::inst( 'wdoxxth.is_defaultprogram' ),
			Field::inst( 'wdoxxth.is_nextprocess' ),
			Field::inst( 'wdoxxth.subtotal' ),
			Field::inst( 'wdoxxth.diskon_jenis' ),
			Field::inst( 'wdoxxth.diskon_value' ),
			Field::inst( 'wdoxxth.diskon_persen' ),
			Field::inst( 'wdoxxth.diskon_final' ),
			Field::inst( 'wdoxxth.dpp' ),
			Field::inst( 'wdoxxth.dpp_final' ),

			Field::inst( 'wdoxxth.is_pajak' ),
			Field::inst( 'wdoxxth.pajak_in_ex' ),
			Field::inst( 'wdoxxth.pajak_jenis' ),
			Field::inst( 'wdoxxth.pajak_persen' ),
			Field::inst( 'wdoxxth.pajak_final' ),
			Field::inst( 'wdoxxth.grand_total' ),

			Field::inst( 'iitxxmh.nama' ),
			Field::inst( 'grlxxmh.nama' )
		)
		->leftJoin( 'iitxxmh','iitxxmh.id','=','wdoxxth.id_iitxxmh' )
		->leftJoin( 'grlxxmh','grlxxmh.id','=','wdoxxth.id_grlxxmh_customer' )
		->where( 'wdoxxth.tanggal', $_POST['start_date'], '>=' )
		->where( 'wdoxxth.tanggal', $_POST['end_date'], '<=' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_wdoxxth'] == 0){
		$editor
			->where( 'wdoxxth.transaction_state', -9, '<>');
	}
	
	include( "wdoxxth_extra.php" );

	// BEGIN log
	$nama_table = 'wdoxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>