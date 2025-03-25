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
	
	$editor = Editor::inst( $db, 'hrctsth' )
		->debug(true)
		->fields(
			Field::inst( 'hrctsth.id' ),
			Field::inst( 'hrctsth.id_hrccdth' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hrctsth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hrctsth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hrctsth.keterangan' ),
			Field::inst( 'hrctsth.created_by' ),
			Field::inst( 'hrctsth.transaction_state' ),
			Field::inst( 'hrctsth.approval_state' ),
			Field::inst( 'hrctsth.start_at' ),
			Field::inst( 'hrctsth.finish_at' ),
			Field::inst( 'hrctsth.is_nextprocess' ),
			Field::inst( 'hrctsth.is_defaultprogram' ),
			Field::inst( 'hrctsth.is_email' ),
			Field::inst( 'hrctsth.tanggal' )
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
			Field::inst( 'hrccdth.kode' ),
		)
		->leftJoin( 'hrccdth','hrccdth.id','=','hrctsth.id_hrccdth' )
		;
	
	if($_POST['start_date'] != ''){
		$editor->where( 'hrctsth.tanggal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'hrctsth.tanggal', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hrctsth'] == 0){
		$editor
			->where( 'hrctsth.transaction_state', -9, '<>');
	}
	
	include( "hrctsth_extra.php" );

	// BEGIN log
	$nama_table = 'hrctsth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>