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
	
	$editor = Editor::inst( $db, 'aabxxth' )
		->debug(true)
		->fields(
			Field::inst( 'aabxxth.id' ),
			Field::inst( 'aabxxth.id_hodxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'aabxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'aabxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'aabxxth.keterangan' ),
			Field::inst( 'aabxxth.created_by' ),
			Field::inst( 'aabxxth.transaction_state' ),
			Field::inst( 'aabxxth.approval_state' ),
			Field::inst( 'aabxxth.start_at' ),
			Field::inst( 'aabxxth.finish_at' ),
			Field::inst( 'aabxxth.is_nextprocess' ),
			Field::inst( 'aabxxth.is_defaultprogram' ),
			Field::inst( 'aabxxth.tanggal' )
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
			Field::inst( 'aabxxth.tahun' ),
			Field::inst( 'aabxxth.bulan' ),
			Field::inst( 'aabxxth.subtotal' ),

			Field::inst( 'hodxxmh.nama' ),
		)
		->leftJoin( 'hodxxmh','hodxxmh.id','=','aabxxth.id_hodxxmh' );
	
	if($_POST['start_date'] != ''){
		$editor->where( 'aabxxth.tanggal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'aabxxth.tanggal', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_aabxxth'] == 0){
		$editor
			->where( 'aabxxth.transaction_state', -9, '<>');
	}
	
	include( "aabxxth_extra.php" );

	// BEGIN log
	$nama_table = 'aabxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>