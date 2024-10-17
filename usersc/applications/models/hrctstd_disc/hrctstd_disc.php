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
	
	$editor = Editor::inst( $db, 'hrctstd_disc' )
		->debug(true)
		->fields(
			Field::inst( 'hrctstd_disc.id' ),
			Field::inst( 'hrctstd_disc.id_hrctsth_disc' ),
			Field::inst( 'hrctsth_disc.id_hcdxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hrctstd_disc.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hrctstd_disc.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hrctstd_disc.keterangan' ),
			Field::inst( 'hrctstd_disc.created_by' ),
			Field::inst( 'hrctstd_disc.transaction_state' ),
			Field::inst( 'hrctstd_disc.approval_state' ),
			Field::inst( 'hrctstd_disc.start_at' ),
			Field::inst( 'hrctstd_disc.finish_at' ),
			Field::inst( 'hrctstd_disc.is_defaultprogram' ),
			Field::inst( 'hrctstd_disc.is_nextprocess' ),
			Field::inst( 'hrctstd_disc.hasil_line1' ),
			Field::inst( 'hrctstd_disc.hasil_line2' ),
			Field::inst( 'hrctstd_disc.hasil_line3' ),
			
			Field::inst( 'hrctsth_disc.kode' ),
			Field::inst( 'hrctsth_disc.tanggal' )
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
		->leftJoin( 'hrctsth_disc','hrctsth_disc.id','=','hrctstd_disc.id_hrctsth_disc' )
		->leftJoin( 'hcdxxmh','hcdxxmh.id','=','hrctsth_disc.id_hcdxxmh' )
		;

	// function show / hide inactive document
	if ( $_POST['show_deleted_hrctstd_disc'] == 0){
		$editor
			->where( 'hrctstd_disc.transaction_state', -9, '<>');
	}

	// BEGIN log
	$nama_table = 'hrctstd_disc';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>