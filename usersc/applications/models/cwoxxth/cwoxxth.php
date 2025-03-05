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
	
	$editor = Editor::inst( $db, 'cwoxxth' )
		->debug(true)
		->fields(
			Field::inst( 'cwoxxth.id' ),
			Field::inst( 'cwoxxth.id_iimxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'cwoxxth.id_crfpxth' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'cwoxxth.id_crfittd' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'cwoxxth.id_dbmxxth' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'cwoxxth.id_iumxxmh_unit' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'cwoxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'cwoxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'cwoxxth.keterangan' ),
			Field::inst( 'cwoxxth.created_by' ),
			Field::inst( 'cwoxxth.transaction_state' ),
			Field::inst( 'cwoxxth.approval_state' ),
			Field::inst( 'cwoxxth.start_at' ),
			Field::inst( 'cwoxxth.finish_at' ),
			Field::inst( 'cwoxxth.is_nextprocess' ),
			Field::inst( 'cwoxxth.is_defaultprogram' ),
			Field::inst( 'cwoxxth.jumlah_unit' ),
			Field::inst( 'cwoxxth.tanggal' )
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
			Field::inst( 'iimxxmh.nama' ),
			Field::inst( 'iumxxmh.kode' ),
			Field::inst( 'crfpxth.kode' ),
		)
		->leftJoin( 'iimxxmh','iimxxmh.id','=','cwoxxth.id_iimxxmh' )
		->leftJoin( 'iumxxmh','iumxxmh.id','=','cwoxxth.id_iumxxmh_unit' )
		->leftJoin( 'crfpxth','crfpxth.id','=','cwoxxth.id_crfpxth' )
		;
	
	if($_POST['start_date'] != ''){
		$editor->where( 'cwoxxth.tanggal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'cwoxxth.tanggal', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_cwoxxth'] == 0){
		$editor
			->where( 'cwoxxth.transaction_state', -9, '<>');
	}
	
	include( "cwoxxth_extra.php" );

	// BEGIN log
	$nama_table = 'cwoxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>