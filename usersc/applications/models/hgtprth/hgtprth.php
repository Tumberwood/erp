<?php
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../helpers/hakakses_s_fn.php" );
	
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
	
	$editor = Editor::inst( $db, 'hgtprth' )
		->debug(true)
		->fields(
			Field::inst( 'hgtprth.id' ),
			Field::inst( 'hgtprth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hgtprth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hgtprth.keterangan' ),
			Field::inst( 'hgtprth.created_by' ),
			Field::inst( 'hgtprth.transaction_state' ),
			Field::inst( 'hgtprth.approval_state' ),
			Field::inst( 'hgtprth.start_at' ),
			Field::inst( 'hgtprth.finish_at' ),
			Field::inst( 'hgtprth.is_defaultprogram' ),
			Field::inst( 'hgtprth.is_nextprocess' ),
			Field::inst( 'hgtprth.generated_on' )
				->getFormatter( 'Format::datetime', array(
					'from' => 'Y-m-d H:i:s',
					'to' =>   'd M Y / H:i'
				) )
				->setFormatter( 'Format::datetime', array(
					'from' => 'd M Y / H:i',
					'to' =>   'Y-m-d H:i:s'
				) ),
			Field::inst( 'hgtprth.tanggal' )
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
		)
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hgtprth'] == 0){
		$editor
			->where( 'hgtprth.transaction_state', -9,'<>');
	}
	
	if ($_POST['status_approve'] == 0) {
		$editor
			->where( function ( $q ) {
				$q->where( 'hgtprth.approval_state', '(0, -1)', 'IN', false);
			} );
	} else if($_POST['status_approve'] == 99) {
		$editor
			->where( function ( $q ) {
				$q->where( 'hgtprth.approval_state', '(0, -1, -9, 1)', 'IN', false);
			} );
	} else {
		$editor
			->where( 'hgtprth.approval_state', $_POST['status_approve']);
	}

	if ( $_POST['start_date'] != null){
		$editor
			->where( 'hgtprth.tanggal', $_POST['start_date'], '>=');
	}

	if ( $_POST['end_date'] != null){
		$editor
			->where( 'hgtprth.tanggal', $_POST['end_date'], '<=');
	}

	include( "hgtprth_extra.php" );

	// BEGIN log
	$nama_table = 'hgtprth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>