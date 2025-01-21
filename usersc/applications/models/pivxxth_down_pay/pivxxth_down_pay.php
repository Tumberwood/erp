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
	
	$editor = Editor::inst( $db, 'pivxxth' )
		->debug(true)
		->fields(
			Field::inst( 'pivxxth.id' ),
			Field::inst( 'pivxxth.id_podxxth' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'pivxxth.id_grlxxmh_supplier' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'pivxxth.id_fpytmmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'pivxxth.id_iitxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'pivxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'pivxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'pivxxth.keterangan' ),
			Field::inst( 'pivxxth.created_by' ),
			Field::inst( 'pivxxth.transaction_state' ),
			Field::inst( 'pivxxth.approval_state' ),
			Field::inst( 'pivxxth.start_at' ),
			Field::inst( 'pivxxth.finish_at' ),
			Field::inst( 'pivxxth.is_defaultprogram' ),
			Field::inst( 'pivxxth.is_nextprocess' ),
			Field::inst( 'pivxxth.tanggal' )
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
		
			Field::inst( 'pivxxth.subtotal' ),
			Field::inst( 'pivxxth.diskon_jenis' ),
			Field::inst( 'pivxxth.diskon_value' ),
			Field::inst( 'pivxxth.diskon_persen' ),
			Field::inst( 'pivxxth.diskon_final' ),
			Field::inst( 'pivxxth.dpp' ),
			Field::inst( 'pivxxth.dpp_final' ),
			
			Field::inst( 'pivxxth.is_pajak' ),
			Field::inst( 'pivxxth.pajak_in_ex' ),
			Field::inst( 'pivxxth.pajak_jenis' ),
			Field::inst( 'pivxxth.pajak_persen' ),
			Field::inst( 'pivxxth.pajak_final' ),
			Field::inst( 'pivxxth.grand_total' ),
			Field::inst( 'pivxxth.down_payment' ),
		
			Field::inst( 'podxxth.kode' ),
			Field::inst( 'podxxth.grand_total' ),
			Field::inst( 'grlxxmh.nama' )
		)
		->leftJoin( 'podxxth','podxxth.id','=','pivxxth.id_podxxth' )
		->leftJoin( 'grlxxmh','grlxxmh.id','=','pivxxth.id_grlxxmh_supplier' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_pivxxth'] == 0){
		$editor
			->where( 'pivxxth.transaction_state', -9, '<>');
	}
	
	include( "pivxxth_extra.php" );

	// BEGIN log
	$nama_table = 'pivxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>