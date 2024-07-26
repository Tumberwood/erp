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
	
	$editor = Editor::inst( $db, 'wdnxxth' )
		->debug(true)
		->fields(
			Field::inst( 'wdnxxth.id' ),
			Field::inst( 'wdnxxth.id_gcpxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gcpxxmh),
			Field::inst( 'wdnxxth.id_gbrxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gbrxxmh),
			Field::inst( 'wdnxxth.id_iwhxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wdnxxth.id_grlxxmh_customer' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wdnxxth.id_grlxxmh_expedition' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wdnxxth.id_wdoxxth' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'wdnxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'wdnxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'wdnxxth.keterangan' ),
			Field::inst( 'wdnxxth.created_by' ),
			Field::inst( 'wdnxxth.transaction_state' ),
			Field::inst( 'wdnxxth.approval_state' ),
			Field::inst( 'wdnxxth.start_at' ),
			Field::inst( 'wdnxxth.finish_at' ),
			Field::inst( 'wdnxxth.is_nextprocess' ),
			Field::inst( 'wdnxxth.is_defaultprogram' ),

			Field::inst( 'wdnxxth.tanggal' )
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
			Field::inst( 'wdnxxth.mobil_nomor' ),
			Field::inst( 'wdnxxth.supir_nama' ),

			Field::inst( 'iwhxxmh.nama' ),
			Field::inst( 'grlxxmh.nama' ),
			Field::inst( 'expedisi.nama' ),
			Field::inst( 'wdoxxth.kode' )

		)
		->leftJoin( 'iwhxxmh','iwhxxmh.id','=','wdnxxth.id_iwhxxmh' )
		->leftJoin( 'grlxxmh','grlxxmh.id','=','wdnxxth.id_grlxxmh_customer' )
		->leftJoin( 'grlxxmh expedisi','expedisi.id','=','wdnxxth.id_grlxxmh_expedition' )
		->leftJoin( 'wdoxxth','wdoxxth.id','=','wdnxxth.id_wdoxxth' )
		;
	
		// BEGIN where single data view
	// if (isset($_POST['rowid']) && $_POST['rowid'] > 0) {
	// 	$rowid = $_POST['rowid'];
	// 	$editor
	// 		->where( 'wdnxxth.id', $rowid);
	// }else{
	// 	$editor
	// 		->where( 'wdnxxth.tanggal', $_POST['start_date'], '>=' )
	// 		->where( 'wdnxxth.tanggal', $_POST['end_date'], '<=' );
	// }
	// END where single data view

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_wdnxxth'] == 0){
		$editor
			->where( 'wdnxxth.transaction_state', -9, '<>');
	}
	
	include( "wdnxxth_extra.php" );

	// BEGIN log
	$nama_table = 'wdnxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>