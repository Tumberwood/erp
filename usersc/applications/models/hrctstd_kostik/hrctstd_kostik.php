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
	
	$editor = Editor::inst( $db, 'hrctstd_kostik' )
		->debug(true)
		->fields(
			Field::inst( 'hrctstd_kostik.id' ),
			Field::inst( 'hrctstd_kostik.id_hrctsth_kostik' ),
			Field::inst( 'hrctsth_kostik.id_hcdxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hrctstd_kostik.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hrctstd_kostik.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hrctstd_kostik.keterangan' ),
			Field::inst( 'hrctstd_kostik.created_by' ),
			Field::inst( 'hrctstd_kostik.transaction_state' ),
			Field::inst( 'hrctstd_kostik.approval_state' ),
			Field::inst( 'hrctstd_kostik.start_at' ),
			Field::inst( 'hrctstd_kostik.finish_at' ),
			Field::inst( 'hrctstd_kostik.is_defaultprogram' ),
			Field::inst( 'hrctstd_kostik.is_nextprocess' ),
			Field::inst( 'hrctstd_kostik.N' ),
			Field::inst( 'hrctstd_kostik.G' ),
			Field::inst( 'hrctstd_kostik.A' ),
			Field::inst( 'hrctstd_kostik.L' ),
			Field::inst( 'hrctstd_kostik.P' ),
			Field::inst( 'hrctstd_kostik.I' ),
			Field::inst( 'hrctstd_kostik.T' ),
			Field::inst( 'hrctstd_kostik.V' ),
			Field::inst( 'hrctstd_kostik.X' ),
			Field::inst( 'hrctstd_kostik.S' ),
			Field::inst( 'hrctstd_kostik.B' ),
			Field::inst( 'hrctstd_kostik.O' ),
			Field::inst( 'hrctstd_kostik.R' ),
			Field::inst( 'hrctstd_kostik.D' ),
			Field::inst( 'hrctstd_kostik.C' ),
			Field::inst( 'hrctstd_kostik.Z' ),
			Field::inst( 'hrctstd_kostik.work_direction' ),
			Field::inst( 'hrctstd_kostik.leadership' ),
			Field::inst( 'hrctstd_kostik.activiti' ),
			Field::inst( 'hrctstd_kostik.social_nature' ),
			Field::inst( 'hrctstd_kostik.work_style' ),
			Field::inst( 'hrctstd_kostik.temprament' ),
			Field::inst( 'hrctstd_kostik.follower' ),
			
			Field::inst( 'hrctsth_kostik.kode' ),
			Field::inst( 'hrctsth_kostik.tanggal' )
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
		->leftJoin( 'hrctsth_kostik','hrctsth_kostik.id','=','hrctstd_kostik.id_hrctsth_kostik' )
		->leftJoin( 'hcdxxmh','hcdxxmh.id','=','hrctsth_kostik.id_hcdxxmh' )
		;

	// function show / hide inactive document
	if ( $_POST['show_deleted_hrctstd_kostik'] == 0){
		$editor
			->where( 'hrctstd_kostik.transaction_state', -9, '<>');
	}

	// BEGIN log
	$nama_table = 'hrctstd_kostik';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>