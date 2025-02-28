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
	
	$editor = Editor::inst( $db, 'sprxxth' )
		->debug(true)
		->fields(
			Field::inst( 'sprxxth.id' ),
			Field::inst( 'sprxxth.id_grlxxmh_customer' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sprxxth.id_aakxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sprxxth.id_aakxxmh_beban' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sprxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'sprxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'sprxxth.keterangan' ),
			Field::inst( 'sprxxth.created_by' ),
			Field::inst( 'sprxxth.transaction_state' ),
			Field::inst( 'sprxxth.approval_state' ),
			Field::inst( 'sprxxth.start_at' ),
			Field::inst( 'sprxxth.finish_at' ),
			Field::inst( 'sprxxth.is_nextprocess' ),
			Field::inst( 'sprxxth.is_defaultprogram' ),
			
			Field::inst( 'sprxxth.amount' ),
			Field::inst( 'sprxxth.rencana_bayar' ),
			Field::inst( 'sprxxth.sisa' ),
			Field::inst( 'sprxxth.tanggal' )
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
		->leftJoin( 'grlxxmh','grlxxmh.id','=','sprxxth.id_grlxxmh_customer' )
		->leftJoin( 'aakxxmh','aakxxmh.id','=','sprxxth.id_aakxxmh' )
		->leftJoin( 'aakxxmh beban','beban.id','=','sprxxth.id_aakxxmh_beban' )
		;
	
	if($_POST['start_date'] != ''){
		$editor->where( 'sprxxth.tanggal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'sprxxth.tanggal', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_sprxxth'] == 0){
		$editor
			->where( 'sprxxth.transaction_state', -9, '<>');
	}
	
	include( "sprxxth_extra.php" );

	// BEGIN log
	$nama_table = 'sprxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>