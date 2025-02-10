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
	
	$editor = Editor::inst( $db, 'fprxxth' )
		->debug(true)
		->fields(
			Field::inst( 'fprxxth.id' ),
			Field::inst( 'fprxxth.id_grlxxmh_supplier' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'fprxxth.id_aakxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'fprxxth.id_aakxxmh_beban' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'fprxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'fprxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'fprxxth.keterangan' ),
			Field::inst( 'fprxxth.created_by' ),
			Field::inst( 'fprxxth.transaction_state' ),
			Field::inst( 'fprxxth.approval_state' ),
			Field::inst( 'fprxxth.start_at' ),
			Field::inst( 'fprxxth.finish_at' ),
			Field::inst( 'fprxxth.is_nextprocess' ),
			Field::inst( 'fprxxth.is_defaultprogram' ),
			
			Field::inst( 'fprxxth.amount' ),
			Field::inst( 'fprxxth.rencana_bayar' ),
			Field::inst( 'fprxxth.sisa' ),
			Field::inst( 'fprxxth.tanggal' )
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
			Field::inst( 'beban.nama' ),
		)
		->leftJoin( 'grlxxmh','grlxxmh.id','=','fprxxth.id_grlxxmh_supplier' )
		->leftJoin( 'aakxxmh','aakxxmh.id','=','fprxxth.id_aakxxmh' )
		->leftJoin( 'aakxxmh beban','beban.id','=','fprxxth.id_aakxxmh_beban' )
		;
	
	if($_POST['start_date'] != ''){
		$editor->where( 'fprxxth.tanggal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'fprxxth.tanggal', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_fprxxth'] == 0){
		$editor
			->where( 'fprxxth.transaction_state', -9, '<>');
	}
	
	include( "fprxxth_extra.php" );

	// BEGIN log
	$nama_table = 'fprxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>