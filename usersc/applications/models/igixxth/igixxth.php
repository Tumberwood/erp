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
	
	$editor = Editor::inst( $db, 'igixxth' )
		->debug(true)
		->fields(
			Field::inst( 'igixxth.id' ),
			Field::inst( 'igixxth.id_gcpxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gcpxxmh),
			Field::inst( 'igixxth.id_gbrxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gbrxxmh),
			Field::inst( 'igixxth.id_aakxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'igixxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'igixxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'igixxth.keterangan' ),
			Field::inst( 'igixxth.created_by' ),
			Field::inst( 'igixxth.transaction_state' ),
			Field::inst( 'igixxth.approval_state' ),
			Field::inst( 'igixxth.start_at' ),
			Field::inst( 'igixxth.finish_at' ),
			Field::inst( 'igixxth.is_defaultprogram' ),
			Field::inst( 'igixxth.is_nextprocess' ),
			Field::inst( 'igixxth.tanggal' )
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
				) ),
			Field::inst( 'aakxxmh.kode' ),
			Field::inst( 'aakxxmh.nama' )
		)
		->leftJoin( 'aakxxmh','aakxxmh.id','=','igixxth.id_aakxxmh' );
	
	if($_POST['start_date'] != ''){
		$editor->where( 'igixxth.tanggal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'igixxth.tanggal', $_POST['end_date'], '<=' );
	}
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_igixxth'] == 0){
		$editor
			->where( 'igixxth.transaction_state', -9, '<>');
	}
	
	include( "igixxth_extra.php" );

	// BEGIN log
	$nama_table = 'igixxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>