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
	
	$editor = Editor::inst( $db, 'hrcivth' )
		->debug(true)
		->fields(
			Field::inst( 'hrcivth.id' ),
			Field::inst( 'hrcivth.id_hrcemtd' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hrcivth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hrcivth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hrcivth.keterangan' ),
			Field::inst( 'hrcivth.created_by' ),
			Field::inst( 'hrcivth.transaction_state' ),
			Field::inst( 'hrcivth.approval_state' ),
			Field::inst( 'hrcivth.start_at' ),
			Field::inst( 'hrcivth.finish_at' ),
			Field::inst( 'hrcivth.is_nextprocess' ),
			Field::inst( 'hrcivth.is_defaultprogram' ),
			Field::inst( 'hrcivth.catatan' ),
			Field::inst( 'hrcivth.saran' ),
			Field::inst( 'hrcivth.tanggal' )
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
			Field::inst( 'hcdxxmh.nama' ),
			Field::inst( 'hrremth.kode' ),
			Field::inst( 'hrccdth.kode' ),
		)
		->leftJoin( 'hrcemtd','hrcemtd.id','=','hrcivth.id_hrcemtd' )
		->leftJoin( 'hcdxxmh','hcdxxmh.id','=','hrcemtd.id_hcdxxmh' )
		->leftJoin( 'hrremth','hrremth.id','=','hrcemtd.id_hrremth' )
		->leftJoin( 'hrccdth','hrccdth.id','=','hrcemtd.id_hrccdth' )
		;
	
	if($_POST['start_date'] != ''){
		$editor->where( 'hrcivth.tanggal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'hrcivth.tanggal', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hrcivth'] == 0){
		$editor
			->where( 'hrcivth.transaction_state', -9, '<>');
	}
	
	include( "hrcivth_extra.php" );

	// BEGIN log
	$nama_table = 'hrcivth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>