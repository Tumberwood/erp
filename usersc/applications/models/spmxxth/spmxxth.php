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
	
	$editor = Editor::inst( $db, 'spmxxth' )
		->debug(true)
		->fields(
			Field::inst( 'spmxxth.id' ),
			Field::inst( 'spmxxth.id_gcpxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gcpxxmh),
			Field::inst( 'spmxxth.id_gbrxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gbrxxmh),
			Field::inst( 'spmxxth.id_grlxxmh_customer' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'spmxxth.id_aakxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'spmxxth.id_aakxxmh_beban' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'spmxxth.id_sprxxth' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'spmxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'spmxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'spmxxth.keterangan' ),
			Field::inst( 'spmxxth.created_by' ),
			Field::inst( 'spmxxth.transaction_state' ),
			Field::inst( 'spmxxth.approval_state' ),
			Field::inst( 'spmxxth.start_at' ),
			Field::inst( 'spmxxth.finish_at' ),
			Field::inst( 'spmxxth.is_nextprocess' ),
			Field::inst( 'spmxxth.is_defaultprogram' ),
			
			Field::inst( 'spmxxth.amount' ),
			Field::inst( 'spmxxth.rencana_bayar' ),
			Field::inst( 'spmxxth.sisa' ),
			Field::inst( 'spmxxth.tanggal' )
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

			Field::inst( 'grlxxmh.nama' ),
			Field::inst( 'aakxxmh.nama' ),
			Field::inst( 'sprxxth.kode' ),
			Field::inst( 'beban.nama' ),
		)
		->leftJoin( 'grlxxmh','grlxxmh.id','=','spmxxth.id_grlxxmh_customer' )
		->leftJoin( 'aakxxmh','aakxxmh.id','=','spmxxth.id_aakxxmh' )
		->leftJoin( 'sprxxth','sprxxth.id','=','spmxxth.id_sprxxth' )
		->leftJoin( 'aakxxmh beban','beban.id','=','spmxxth.id_aakxxmh_beban' )
		;
	
	if($_POST['start_date'] != ''){
		$editor->where( 'spmxxth.tanggal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'spmxxth.tanggal', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_spmxxth'] == 0){
		$editor
			->where( 'spmxxth.transaction_state', -9, '<>');
	}
	
	include( "spmxxth_extra.php" );

	// BEGIN log
	$nama_table = 'spmxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>