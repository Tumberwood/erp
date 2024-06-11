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
	
	$editor = Editor::inst( $db, 'wroxxth' )
		->debug(true)
		->fields(
			Field::inst( 'wroxxth.id' ),
			Field::inst( 'wroxxth.id_gcpxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gcpxxmh),
			Field::inst( 'wroxxth.id_gbrxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gbrxxmh),
			Field::inst( 'wroxxth.id_iitxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wroxxth.id_grlxxmh_supplier' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wroxxth.id_fpytmmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wroxxth.id_fcrxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wroxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'wroxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'wroxxth.keterangan' ),
			Field::inst( 'wroxxth.created_by' ),
			Field::inst( 'wroxxth.transaction_state' ),
			Field::inst( 'wroxxth.approval_state' ),
			Field::inst( 'wroxxth.start_at' ),
			Field::inst( 'wroxxth.finish_at' ),
			Field::inst( 'wroxxth.tanggal' )
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
			Field::inst( 'wroxxth.is_defaultprogram' ),
			Field::inst( 'wroxxth.is_nextprocess' ),
			Field::inst( 'wroxxth.subtotal' ),
			Field::inst( 'wroxxth.diskon_jenis' ),
			Field::inst( 'wroxxth.diskon_value' ),
			Field::inst( 'wroxxth.diskon_persen' ),
			Field::inst( 'wroxxth.diskon_final' ),
			Field::inst( 'wroxxth.dpp' ),
			Field::inst( 'wroxxth.dpp_final' ),

			Field::inst( 'wroxxth.is_pajak' ),
			Field::inst( 'wroxxth.pajak_in_ex' ),
			Field::inst( 'wroxxth.pajak_jenis' ),
			Field::inst( 'wroxxth.pajak_persen' ),
			Field::inst( 'wroxxth.pajak_final' ),
			Field::inst( 'wroxxth.grand_total' ),

			Field::inst( 'iitxxmh.nama' ),
			Field::inst( 'grlxxmh.nama' )
		)
		->leftJoin( 'iitxxmh','iitxxmh.id','=','wroxxth.id_iitxxmh' )
		->leftJoin( 'grlxxmh','grlxxmh.id','=','wroxxth.id_grlxxmh_supplier' )
		->where( 'wroxxth.tanggal', $_POST['start_date'], '>=' )
		->where( 'wroxxth.tanggal', $_POST['end_date'], '<=' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_wroxxth'] == 0){
		$editor
			->where( 'wroxxth.transaction_state', -9, '<>');
	}
	
	include( "wroxxth_extra.php" );

	// BEGIN log
	$nama_table = 'wroxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>