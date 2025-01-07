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
	
	$editor = Editor::inst( $db, 'hfkxxth' )
		->debug(true)
		->fields(
			Field::inst( 'hfkxxth.id' ),
			Field::inst( 'hfkxxth.id_hemxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hfkxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hfkxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hfkxxth.keterangan' ),
			Field::inst( 'hfkxxth.created_by' ),
			Field::inst( 'hfkxxth.transaction_state' ),
			Field::inst( 'hfkxxth.approval_state' ),
			Field::inst( 'hfkxxth.start_at' ),
			Field::inst( 'hfkxxth.finish_at' ),
			Field::inst( 'hfkxxth.is_nextprocess' ),
			Field::inst( 'hfkxxth.is_defaultprogram' ),
			Field::inst( 'hfkxxth.tanggal_awal' )
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
			Field::inst( 'hfkxxth.tanggal_akhir' )
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
			
			Field::inst( 'hemxxmh.kode' ),
			Field::inst( 'hemxxmh.nama' ),
			Field::inst( 'hovxxmh.nama' ),
			Field::inst( 'hodxxmh.nama' ),
			Field::inst( 'hetxxmh.nama' ),
		)
		->leftJoin( 'hemxxmh','hemxxmh.id','=','hfkxxth.id_hemxxmh' )
		->leftJoin( 'hemjbmh','hemjbmh.id_hemxxmh','=','hemxxmh.id' )
		->leftJoin( 'hovxxmh','hovxxmh.id','=','hemjbmh.id_hovxxmh' )
		->leftJoin( 'hodxxmh','hodxxmh.id','=','hemjbmh.id_hodxxmh' )
		->leftJoin( 'hetxxmh','hetxxmh.id','=','hemjbmh.id_hetxxmh' )
		;
	
	if($_POST['start_date'] != ''){
		$editor->where( 'hfkxxth.tanggal_awal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'hfkxxth.tanggal_awal', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hfkxxth'] == 0){
		$editor
			->where( 'hfkxxth.transaction_state', -9, '<>');
	}
	
	include( "hfkxxth_extra.php" );

	// BEGIN log
	$nama_table = 'hfkxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>