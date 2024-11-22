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
	
	$editor = Editor::inst( $db, 'wpkxxth' )
		->debug(true)
		->fields(
			Field::inst( 'wpkxxth.id' ),
			Field::inst( 'wpkxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'wpkxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'wpkxxth.keterangan' ),
			Field::inst( 'wpkxxth.created_by' ),
			Field::inst( 'wpkxxth.transaction_state' ),
			Field::inst( 'wpkxxth.approval_state' ),
			Field::inst( 'wpkxxth.start_at' ),
			Field::inst( 'wpkxxth.finish_at' ),
			Field::inst( 'wpkxxth.is_nextprocess' ),
			Field::inst( 'wpkxxth.is_defaultprogram' ),
			Field::inst( 'wpkxxth.tanggal' )
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
		$editor->where( 'wpkxxth.tanggal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'wpkxxth.tanggal', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_wpkxxth'] == 0){
		$editor
			->where( 'wpkxxth.transaction_state', -9, '<>');
	}
	
	include( "wpkxxth_extra.php" );

	// BEGIN log
	$nama_table = 'wpkxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>