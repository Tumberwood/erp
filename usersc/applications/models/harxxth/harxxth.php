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
	
	$editor = Editor::inst( $db, 'harxxth' )
		->debug(true)
		->fields(
			Field::inst( 'harxxth.id' ),
			
			Field::inst( 'harxxth.id_hemxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'harxxth.id_hovxxmh_awal' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'harxxth.id_hovxxmh_akhir' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'harxxth.id_hodxxmh_awal' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'harxxth.id_hodxxmh_akhir' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'harxxth.id_hosxxmh_awal' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'harxxth.id_hosxxmh_akhir' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'harxxth.id_hevxxmh_awal' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'harxxth.id_hevxxmh_akhir' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'harxxth.id_hetxxmh_awal' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'harxxth.id_hetxxmh_akhir' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'harxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'harxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'harxxth.keterangan' ),
			Field::inst( 'harxxth.created_by' ),
			Field::inst( 'harxxth.transaction_state' ),
			Field::inst( 'harxxth.approval_state' ),
			Field::inst( 'harxxth.start_at' ),
			Field::inst( 'harxxth.finish_at' ),
			Field::inst( 'harxxth.is_nextprocess' ),
			Field::inst( 'harxxth.is_defaultprogram' ),
			
			Field::inst( 'harxxth.tanggal_efektif' )
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
			Field::inst( 'CONCAT(hemxxmh.kode," - ",hemxxmh.nama) as hemxxmh_data' )
	)
	->leftJoin( 'hemxxmh','hemxxmh.id','=','harxxth.id_hemxxmh' )
	;
	
	if($_POST['start_date'] != ''){
		$editor->where( 'harxxth.tanggal_efektif',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'harxxth.tanggal_efektif', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_harxxth'] == 0){
		$editor
			->where( 'harxxth.transaction_state', -9, '<>');
	}
	
	include( "harxxth_extra.php" );

	// BEGIN log
	$nama_table = 'harxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>