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
	
	$editor = Editor::inst( $db, 'sivxxth' )
		->debug(true)
		->fields(
			Field::inst( 'sivxxth.id' ),
			Field::inst( 'sivxxth.id_gcpxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gcpxxmh),
			Field::inst( 'sivxxth.id_gbrxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gbrxxmh),
			Field::inst( 'sivxxth.id_sdlxxth' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sivxxth.id_iitxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sivxxth.id_sodxxth' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sivxxth.id_grlxxmh_customer' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sivxxth.id_fpytmmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sivxxth.id_fcrxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sivxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'sivxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'sivxxth.keterangan' ),
			Field::inst( 'sivxxth.created_by' ),
			Field::inst( 'sivxxth.transaction_state' ),
			Field::inst( 'sivxxth.approval_state' ),
			Field::inst( 'sivxxth.start_at' ),
			Field::inst( 'sivxxth.finish_at' ),
			Field::inst( 'sivxxth.tanggal' )
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
			Field::inst( 'sivxxth.is_defaultprogram' ),
			Field::inst( 'sivxxth.is_nextprocess' ),
			Field::inst( 'sivxxth.subtotal' ),
			Field::inst( 'sivxxth.diskon_jenis' ),
			Field::inst( 'sivxxth.diskon_value' ),
			Field::inst( 'sivxxth.diskon_persen' ),
			Field::inst( 'sivxxth.diskon_final' ),
			Field::inst( 'sivxxth.dpp' ),
			Field::inst( 'sivxxth.dpp_final' ),

			Field::inst( 'sivxxth.is_pajak' ),
			Field::inst( 'sivxxth.pajak_in_ex' ),
			Field::inst( 'sivxxth.pajak_jenis' ),
			Field::inst( 'sivxxth.pajak_persen' ),
			Field::inst( 'sivxxth.pajak_final' ),
			Field::inst( 'sivxxth.grand_total' ),
			Field::inst( 'sivxxth.selisih_bayar' ),

			Field::inst( 'sdlxxth.kode' ),
			Field::inst( 'sodxxth.kode' ),
			Field::inst( 'grlxxmh.nama' )
		)
		->leftJoin( 'sdlxxth','sdlxxth.id','=','sivxxth.id_sdlxxth' )
		->leftJoin( 'sodxxth','sodxxth.id','=','sivxxth.id_sodxxth' )
		->leftJoin( 'grlxxmh','grlxxmh.id','=','sivxxth.id_grlxxmh_customer' )
		->where( 'sivxxth.tanggal', $_POST['start_date'], '>=' )
		->where( 'sivxxth.tanggal', $_POST['end_date'], '<=' )
		->where( 'sivxxth.is_down_payment', 0)
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_sivxxth'] == 0){
		$editor
			->where( 'sivxxth.transaction_state', -9, '<>');
	}
	
	include( "sivxxth_extra.php" );

	// BEGIN log
	$nama_table = 'sivxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>