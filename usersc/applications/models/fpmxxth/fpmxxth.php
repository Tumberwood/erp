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
	
	$editor = Editor::inst( $db, 'fpmxxth' )
		->debug(true)
		->fields(
			Field::inst( 'fpmxxth.id' ),
			Field::inst( 'fpmxxth.id_gcpxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gcpxxmh),
			Field::inst( 'fpmxxth.id_gbrxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gbrxxmh),
			Field::inst( 'fpmxxth.id_grlxxmh_supplier' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'fpmxxth.id_aakxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'fpmxxth.id_fprxxth' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'fpmxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'fpmxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'fpmxxth.keterangan' ),
			Field::inst( 'fpmxxth.created_by' ),
			Field::inst( 'fpmxxth.transaction_state' ),
			Field::inst( 'fpmxxth.approval_state' ),
			Field::inst( 'fpmxxth.start_at' ),
			Field::inst( 'fpmxxth.finish_at' ),
			Field::inst( 'fpmxxth.is_nextprocess' ),
			Field::inst( 'fpmxxth.is_defaultprogram' ),
			
			Field::inst( 'fpmxxth.amount' ),
			Field::inst( 'fpmxxth.rencana_bayar' ),
			Field::inst( 'fpmxxth.sisa' ),
			Field::inst( 'fpmxxth.tanggal' )
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
			Field::inst( 'fprxxth.kode' ),
		)
		->leftJoin( 'grlxxmh','grlxxmh.id','=','fpmxxth.id_grlxxmh_supplier' )
		->leftJoin( 'aakxxmh','aakxxmh.id','=','fpmxxth.id_aakxxmh' )
		->leftJoin( 'fprxxth','fprxxth.id','=','fpmxxth.id_fprxxth' )
		;
	
	if($_POST['start_date'] != ''){
		$editor->where( 'fpmxxth.tanggal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'fpmxxth.tanggal', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_fpmxxth'] == 0){
		$editor
			->where( 'fpmxxth.transaction_state', -9, '<>');
	}
	
	include( "fpmxxth_extra.php" );

	// BEGIN log
	$nama_table = 'fpmxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>