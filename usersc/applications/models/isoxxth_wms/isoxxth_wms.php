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
	
	$editor = Editor::inst( $db, 'isoxxth_wms' )
		->debug(true)
		->fields(
			Field::inst( 'isoxxth_wms.id' ),
			Field::inst( 'isoxxth_wms.id_iwhxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'isoxxth_wms.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'isoxxth_wms.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'isoxxth_wms.keterangan' ),
			Field::inst( 'isoxxth_wms.created_by' ),
			Field::inst( 'isoxxth_wms.transaction_state' ),
			Field::inst( 'isoxxth_wms.approval_state' ),
			Field::inst( 'isoxxth_wms.start_at' ),
			Field::inst( 'isoxxth_wms.finish_at' ),
			Field::inst( 'isoxxth_wms.is_nextprocess' ),
			Field::inst( 'isoxxth_wms.is_defaultprogram' ),
			Field::inst( 'isoxxth_wms.tanggal' )
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

			Field::inst( 'iwhxxmh.nama' ),
		)
		->leftJoin( 'iwhxxmh','iwhxxmh.id','=','isoxxth_wms.id_iwhxxmh' )
		;
	
	if($_POST['start_date'] != ''){
		$editor->where( 'isoxxth_wms.tanggal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'isoxxth_wms.tanggal', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_isoxxth_wms'] == 0){
		$editor
			->where( 'isoxxth_wms.transaction_state', -9, '<>');
	}
	
	include( "isoxxth_wms_extra.php" );

	// BEGIN log
	$nama_table = 'isoxxth_wms';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>