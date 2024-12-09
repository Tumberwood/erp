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
	
	$editor = Editor::inst( $db, 'wkdxxth' )
		->debug(true)
		->fields(
			Field::inst( 'wkdxxth.id' ),
			Field::inst( 'wkdxxth.id_wpmxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wkdxxth.id_iwhxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wkdxxth.id_wlpxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wkdxxth.id_iumxxmh_unit' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wkdxxth.id_iimxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wkdxxth.id_wloxxmh_out' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wkdxxth.id_grlxxmh_customer' ),
			Field::inst( 'wkdxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'wkdxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'wkdxxth.keterangan' ),
			Field::inst( 'wkdxxth.created_by' ),
			Field::inst( 'wkdxxth.transaction_state' ),
			Field::inst( 'wkdxxth.approval_state' ),
			Field::inst( 'wkdxxth.start_at' ),
			Field::inst( 'wkdxxth.finish_at' ),
			Field::inst( 'wkdxxth.is_nextprocess' ),
			Field::inst( 'wkdxxth.is_defaultprogram' ),
			Field::inst( 'wkdxxth.is_crossdocking' ),
			Field::inst( 'wkdxxth.is_generate_lpn' ),
			Field::inst( 'wkdxxth.is_all_wh' ),
			Field::inst( 'wkdxxth.jumlah_unit' ),
			Field::inst( 'wkdxxth.jumlah_final' ),
			Field::inst( 'wkdxxth.is_backdate' ),
			Field::inst( 'wkdxxth.is_lpn_sama' ),
			Field::inst( 'wkdxxth.wlpxxmh_kode_kitting' ),
			Field::inst( 'wkdxxth.tanggal' )
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
		->leftJoin( 'wpmxxmh','wpmxxmh.id','=','wkdxxth.id_wpmxxmh' )
		->where( 'wkdxxth.is_backdate', 0 );
		;
	
	if($_POST['start_date'] != ''){
		$editor->where( 'wkdxxth.tanggal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'wkdxxth.tanggal', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_wkdxxth'] == 0){
		$editor
			->where( 'wkdxxth.transaction_state', -9, '<>');
	}
	
	include( "wkdxxth_extra.php" );

	// BEGIN log
	$nama_table = 'wkdxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>