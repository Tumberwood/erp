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
	
	$editor = Editor::inst( $db, 'wktxxth' )
		->debug(true)
		->fields(
			Field::inst( 'wktxxth.id' ),
			Field::inst( 'wktxxth.id_wpmxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wktxxth.id_iwhxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wktxxth.id_iumxxmh_unit' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wktxxth.id_iimxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wktxxth.id_wloxxmh_out' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wktxxth.id_grlxxmh_customer' ),
			Field::inst( 'wktxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'wktxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'wktxxth.keterangan' ),
			Field::inst( 'wktxxth.created_by' ),
			Field::inst( 'wktxxth.transaction_state' ),
			Field::inst( 'wktxxth.approval_state' ),
			Field::inst( 'wktxxth.start_at' ),
			Field::inst( 'wktxxth.finish_at' ),
			Field::inst( 'wktxxth.is_nextprocess' ),
			Field::inst( 'wktxxth.is_defaultprogram' ),
			Field::inst( 'wktxxth.is_crossdocking' ),
			Field::inst( 'wktxxth.is_generate_lpn' ),
			Field::inst( 'wktxxth.is_all_wh' ),
			Field::inst( 'wktxxth.jumlah_unit' ),
			Field::inst( 'wktxxth.jumlah_final' ),
			Field::inst( 'wktxxth.is_backdate' )
			->set( Field::SET_CREATE )
			->setValue('1'),
			Field::inst( 'wktxxth.tanggal' )
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
			Field::inst( 'wpmxxmh.nama' ),
		)
		->leftJoin( 'wpmxxmh','wpmxxmh.id','=','wktxxth.id_wpmxxmh' )
		->where( 'wktxxth.is_backdate', 1 );
		;
	
	if($_POST['start_date'] != ''){
		$editor->where( 'wktxxth.tanggal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'wktxxth.tanggal', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_wktxxth'] == 0){
		$editor
			->where( 'wktxxth.transaction_state', -9, '<>');
	}
	
	include( "wktxxth_extra.php" );

	// BEGIN log
	$nama_table = 'wktxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>