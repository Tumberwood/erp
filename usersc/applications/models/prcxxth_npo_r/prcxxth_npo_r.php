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
	
	$editor = Editor::inst( $db, 'prcittd_npo' )
		->debug(true)
		->fields(
			Field::inst( 'prcittd_npo.id' ),
			Field::inst( 'prcittd_npo.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'prcittd_npo.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'prcittd_npo.keterangan' ),
			Field::inst( 'prcittd_npo.id_iimxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'prcittd_npo.id_iumxxmh_unit' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'prcittd_npo.is_nextprocess' ),
			
			Field::inst( 'prcittd_npo.jumlah_unit' ),
			Field::inst( 'prcittd_npo.is_defaultprogram' ),
			Field::inst( 'prcxxth_npo.kode' ),
			Field::inst( 'prcxxth_npo.tanggal' )
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
				) )
			,
			
			Field::inst( 'iimxxmh.kode' ),
			Field::inst( 'iimxxmh.nama' ),
			Field::inst( 'iumxxmh_unit.kode' ),
			Field::inst( 'iwhxxmh.nama' ),
			Field::inst( 'grlxxmh.nama' ),
		)
		->leftJoin( 'iumxxmh as iumxxmh_unit','iumxxmh_unit.id','=','prcittd_npo.id_iumxxmh_unit' )
		->leftJoin( 'iimxxmh','iimxxmh.id','=','prcittd_npo.id_iimxxmh' )
		->leftJoin( 'prcxxth_npo','prcxxth_npo.id','=','prcittd_npo.id_prcxxth_npo' )
		->leftJoin( 'iwhxxmh','iwhxxmh.id','=','prcxxth_npo.id_iwhxxmh' )
		->leftJoin( 'grlxxmh','grlxxmh.id','=','prcxxth_npo.id_grlxxmh_supplier' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_prcxxth_npo'] == 0){
		$editor
			->where( 'prcxxth_npo.transaction_state', -9, '<>');
	}
	
	include( "prcxxth_npo_extra.php" );

	// BEGIN log
	$nama_table = 'prcxxth_npo';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>