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
	
	$editor = Editor::inst( $db, 'hrctstd_cfit' )
		->debug(true)
		->fields(
			Field::inst( 'hrctstd_cfit.id' ),
			Field::inst( 'hrctstd_cfit.id_hrctsth_cfit' ),
			Field::inst( 'hrctstd_cfit.id_hcdxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hrctstd_cfit.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hrctstd_cfit.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hrctstd_cfit.keterangan' ),
			Field::inst( 'hrctstd_cfit.created_by' ),
			Field::inst( 'hrctstd_cfit.transaction_state' ),
			Field::inst( 'hrctstd_cfit.approval_state' ),
			Field::inst( 'hrctstd_cfit.start_at' ),
			Field::inst( 'hrctstd_cfit.finish_at' ),
			Field::inst( 'hrctstd_cfit.is_defaultprogram' ),
			Field::inst( 'hrctstd_cfit.is_nextprocess' ),
			Field::inst( 'hrctstd_cfit.total_benar' ),
			Field::inst( 'hrctstd_cfit.total_nilai' ),
			Field::inst( 'hrctstd_cfit.iq' ),
			
			Field::inst( 'hrctsth_cfit.kode' ),
			Field::inst( 'hrctsth_cfit.tanggal' )
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
			Field::inst( 'hcdxxmh.nama' )
		)
		->leftJoin( 'hrctsth_cfit','hrctsth_cfit.id','=','hrctstd_cfit.id_hrctsth_cfit' )
		->leftJoin( 'hcdxxmh','hcdxxmh.id','=','hrctstd_cfit.id_hcdxxmh' )
		;

	// function show / hide inactive document
	if ( $_POST['show_deleted_hrctstd_cfit'] == 0){
		$editor
			->where( 'hrctstd_cfit.transaction_state', -9, '<>');
	}

	// BEGIN log
	$nama_table = 'hrctstd_cfit';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>