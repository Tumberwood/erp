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
	
	$editor = Editor::inst( $db, 'podxxth' )
		->debug(true)
		->fields(
			Field::inst( 'podxxth.id' ),
			Field::inst( 'podxxth.id_gcpxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gcpxxmh),
			Field::inst( 'podxxth.id_gbrxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gbrxxmh),
			Field::inst( 'podxxth.id_iittpmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'podxxth.id_psuxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'podxxth.id_fpytmmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'podxxth.id_fcrxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'podxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'podxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'podxxth.keterangan' ),
			Field::inst( 'podxxth.created_by' ),
			Field::inst( 'podxxth.transaction_state' ),
			Field::inst( 'podxxth.approval_state' ),
			Field::inst( 'podxxth.start_at' ),
			Field::inst( 'podxxth.finish_at' ),
			Field::inst( 'podxxth.tanggal' )
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
			Field::inst( 'podxxth.is_defaultprogram' ),
			Field::inst( 'podxxth.subtotal' ),
			Field::inst( 'podxxth.diskon_jenis' ),
			Field::inst( 'podxxth.diskon_value' ),
			Field::inst( 'podxxth.diskon_persen' ),
			Field::inst( 'podxxth.diskon_final' ),
			Field::inst( 'podxxth.dpp' ),
			Field::inst( 'podxxth.dpp_final' ),

			Field::inst( 'podxxth.is_pajak' ),
			Field::inst( 'podxxth.pajak_in_ex' ),
			Field::inst( 'podxxth.pajak_jenis' ),
			Field::inst( 'podxxth.pajak_persen' ),
			Field::inst( 'podxxth.pajak_final' ),
			Field::inst( 'podxxth.grand_total' ),

			Field::inst( 'iittpmh.nama' ),
			Field::inst( 'psuxxmh.nama' )
		)
		->leftJoin( 'iittpmh','iittpmh.id','=','podxxth.id_iittpmh' )
		->leftJoin( 'psuxxmh','psuxxmh.id','=','podxxth.id_psuxxmh' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_podxxth'] == 0){
		$editor
			->where( 'podxxth.transaction_state', -9, '<>');
	}
	
	include( "podxxth_extra.php" );

	// BEGIN log
	$nama_table = 'podxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>