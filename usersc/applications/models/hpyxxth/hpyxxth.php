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
	
	$editor = Editor::inst( $db, 'hpyxxth' )
		->debug(true)
		->fields(
			Field::inst( 'hpyxxth.id' ),
			Field::inst( 'hpyxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hpyxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hpyxxth.keterangan' ),
			Field::inst( 'hpyxxth.created_by' ),
			Field::inst( 'hpyxxth.transaction_state' ),
			Field::inst( 'hpyxxth.approval_state' ),
			Field::inst( 'hpyxxth.start_at' ),
			Field::inst( 'hpyxxth.finish_at' ),
			Field::inst( 'hpyxxth.is_nextprocess' ),
			Field::inst( 'hpyxxth.is_defaultprogram' ),
			Field::inst( 'hpyxxth.tanggal_awal' )
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
			
			Field::inst( 'hpyxxth.generated_on' )
				->getFormatter( function ( $val, $data, $opts ) {
					if ($val === '0000-00-00 00:00:00' || $val === null){
						echo '';
					}else{
						return date( 'd M Y H:i:s', strtotime( $val ) );
					}
				} ),
			Field::inst( 'hpyxxth.tanggal_akhir' )
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
	
	// if($_POST['start_date'] != ''){
	// 	$editor->where( 'hpyxxth.tanggal_awal',$_POST['start_date'], '>=' );
	// }
	// if($_POST['end_date'] != ''){
	// 	$editor->where( 'hpyxxth.tanggal_awal', $_POST['end_date'], '<=' );
	// }

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hpyxxth'] == 0){
		$editor
			->where( 'hpyxxth.transaction_state', -9, '<>');
	}
	
	include( "hpyxxth_extra.php" );

	// BEGIN log
	$nama_table = 'hpyxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>