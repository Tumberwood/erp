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
	
	$editor = Editor::inst( $db, 'wplxxth' )
		->debug(true)
		->fields(
			Field::inst( 'wplxxth.id' ),
			Field::inst( 'wplxxth.id_wpmxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wplxxth.id_wdoxxth' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wplxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'wplxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'wplxxth.keterangan' ),
			Field::inst( 'wplxxth.created_by' ),
			Field::inst( 'wplxxth.transaction_state' ),
			Field::inst( 'wplxxth.approval_state' ),
			Field::inst( 'wplxxth.start_at' ),
			Field::inst( 'wplxxth.finish_at' ),
			Field::inst( 'wplxxth.is_defaultprogram' ),
			Field::inst( 'wplxxth.tanggal' )
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
			Field::inst( 'wpmxxmh.nama' ),
			Field::inst( 'wdoxxth.kode' ),
		)
		->leftJoin( 'wdoxxth','wdoxxth.id','=','wplxxth.id_wdoxxth' )
		->leftJoin( 'wpmxxmh','wpmxxmh.id','=','wplxxth.id_wpmxxmh' )
		;
	
	if($_POST['start_date'] != ''){
		$editor->where( 'wplxxth.tanggal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'wplxxth.tanggal', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_wplxxth'] == 0){
		$editor
			->where( 'wplxxth.transaction_state', -9, '<>');
	}
	
	include( "wplxxth_extra.php" );

	// BEGIN log
	$nama_table = 'wplxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>