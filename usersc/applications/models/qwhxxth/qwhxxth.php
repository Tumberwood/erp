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
	
	$editor = Editor::inst( $db, 'qwhxxth' )
		->debug(true)
		->fields(
			Field::inst( 'qwhxxth.id' ),
			Field::inst( 'qwhxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'qwhxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'qwhxxth.keterangan' ),
			Field::inst( 'qwhxxth.created_by' ),
			Field::inst( 'qwhxxth.transaction_state' ),
			Field::inst( 'qwhxxth.approval_state' ),
			Field::inst( 'qwhxxth.start_at' ),
			Field::inst( 'qwhxxth.finish_at' ),
			Field::inst( 'qwhxxth.is_nextprocess' ),
			Field::inst( 'qwhxxth.is_defaultprogram' ),
			Field::inst( 'qwhxxth.tanggal' )
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
		);
	
	if($_POST['start_date'] != ''){
		$editor->where( 'qwhxxth.tanggal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'qwhxxth.tanggal', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_qwhxxth'] == 0){
		$editor
			->where( 'qwhxxth.transaction_state', -9, '<>');
	}
	
	include( "qwhxxth_extra.php" );

	// BEGIN log
	$nama_table = 'qwhxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>