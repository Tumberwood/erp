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
	
	$editor = Editor::inst( $db, 'sodxxth' )
		->debug(true)
		->fields(
			Field::inst( 'sodxxth.id' ),
			Field::inst( 'sodxxth.id_gcpxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gcpxxmh),
			Field::inst( 'sodxxth.id_gbrxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gbrxxmh),
			Field::inst( 'sodxxth.id_iitxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sodxxth.id_grlxxmh_customer' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sodxxth.id_fpytmmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sodxxth.id_fcrxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sodxxth.id_licxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sodxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'sodxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'sodxxth.keterangan' ),
			Field::inst( 'sodxxth.created_by' ),
			Field::inst( 'sodxxth.transaction_state' ),
			Field::inst( 'sodxxth.approval_state' ),
			Field::inst( 'sodxxth.start_at' ),
			Field::inst( 'sodxxth.finish_at' ),
			Field::inst( 'sodxxth.tanggal' )
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
			Field::inst( 'sodxxth.is_defaultprogram' ),
			Field::inst( 'sodxxth.is_nextprocess' ),
			Field::inst( 'sodxxth.subtotal' ),
			Field::inst( 'sodxxth.diskon_jenis' ),
			Field::inst( 'sodxxth.diskon_value' ),
			Field::inst( 'sodxxth.diskon_persen' ),
			Field::inst( 'sodxxth.diskon_final' ),
			Field::inst( 'sodxxth.dpp' ),
			Field::inst( 'sodxxth.dpp_final' ),

			Field::inst( 'sodxxth.is_pajak' ),
			Field::inst( 'sodxxth.pajak_in_ex' ),
			Field::inst( 'sodxxth.pajak_jenis' ),
			Field::inst( 'sodxxth.pajak_persen' ),
			Field::inst( 'sodxxth.pajak_final' ),
			Field::inst( 'sodxxth.grand_total' ),

			Field::inst( 'iitxxmh.nama' ),
			Field::inst( 'grlxxmh.nama' )
		)
		->leftJoin( 'iitxxmh','iitxxmh.id','=','sodxxth.id_iitxxmh' )
		->leftJoin( 'grlxxmh','grlxxmh.id','=','sodxxth.id_grlxxmh_customer' )
		->where( 'sodxxth.tanggal', $_POST['start_date'], '>=' )
		->where( 'sodxxth.tanggal', $_POST['end_date'], '<=' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_sodxxth'] == 0){
		$editor
			->where( 'sodxxth.transaction_state', -9, '<>');
	}
	
	include( "sodxxth_extra.php" );

	// BEGIN log
	$nama_table = 'sodxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>