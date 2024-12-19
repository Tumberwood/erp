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
	
	$editor = Editor::inst( $db, 'httgltd' )
		->debug(true)
		->fields(
			Field::inst( 'httgltd.id' ),
			Field::inst( 'httgltd.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'httgltd.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'httgltd.keterangan' ),
			Field::inst( 'httgltd.created_by' ),
			Field::inst( 'httgltd.transaction_state' ),
			Field::inst( 'httgltd.approval_state' ),
			Field::inst( 'httgltd.start_at' ),
			Field::inst( 'httgltd.finish_at' ),
			Field::inst( 'httgltd.is_defaultprogram' ),
			Field::inst( 'httgltd.is_nextprocess' ),

			Field::inst( 'httgltd.tanggal' )
				->getFormatter( function ( $val, $data, $opts ) {
					if ($val === '0000-00-00' || $val === null){
						return '';
					}else{
						return date( 'd M Y', strtotime( $val ) );
					}
				} )
				->setFormatter( 'Format::datetime', array(
					'from' => 'd M Y',
					'to' =>   'Y-m-d'
				) )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_httgltd'] == 0){
		$editor
			->where( 'httgltd.transaction_state', -9, '<>');
	}

	//kalo pake row id, tidak perlu filter tanggal
	if ( isset($_POST['rowId']) && $_POST['rowId'] > 0){
		$editor
			->where( 'httgltd.id', $_POST['rowId']);
	} else {
		if($_POST['start_date'] != ''){
			$editor->where( 'httgltd.tanggal',$_POST['start_date'], '>=' );
		}
		if($_POST['end_date'] != ''){
			$editor->where( 'httgltd.tanggal', $_POST['end_date'], '<=' );
		}
	}
	
	include( "httgltd_extra.php" );

	// BEGIN log
	$nama_table = 'httgltd';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>