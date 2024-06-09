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
	
	$editor = Editor::inst( $db, 'htoxxth' )
		->debug(true)
		->fields(
			Field::inst( 'htoxxth.id' ),
			Field::inst( 'htoxxth.id_gcpxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gcpxxmh),
			Field::inst( 'htoxxth.id_gbrxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gbrxxmh),
			Field::inst( 'htoxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'htoxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'htoxxth.keterangan' ),
			Field::inst( 'htoxxth.created_by' ),
			Field::inst( 'htoxxth.transaction_state' ),
			Field::inst( 'htoxxth.approval_state' ),
			Field::inst( 'htoxxth.start_at' ),
			Field::inst( 'htoxxth.finish_at' ),
			Field::inst( 'htoxxth.is_defaultprogram' ),
			Field::inst( 'htoxxth.is_nextprocess' ),
			Field::inst( 'htoxxth.tanggal' )
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
		$editor->where( 'htoxxth.tanggal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'htoxxth.tanggal', $_POST['end_date'], '<=' );
	}
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_htoxxth'] == 0){
		$editor
			->where( 'htoxxth.transaction_state', -9, '<>');
	}
	
	include( "htoxxth_extra.php" );

	// BEGIN log
	$nama_table = 'htoxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>