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
	
	$editor = Editor::inst( $db, 'scsxxth' )
		->debug(true)
		->fields(
			Field::inst( 'scsxxth.id' ),
			Field::inst( 'scsxxth.id_gcpxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gcpxxmh),
			Field::inst( 'scsxxth.id_gbrxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gbrxxmh),
			Field::inst( 'scsxxth.id_iwhxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'scsxxth.id_grlxxmh_customer' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'scsxxth.id_sodxxth' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'scsxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'scsxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'scsxxth.keterangan' ),
			Field::inst( 'scsxxth.created_by' ),
			Field::inst( 'scsxxth.transaction_state' ),
			Field::inst( 'scsxxth.approval_state' ),
			Field::inst( 'scsxxth.start_at' ),
			Field::inst( 'scsxxth.finish_at' ),
			Field::inst( 'scsxxth.is_nextprocess' ),
			Field::inst( 'scsxxth.is_defaultprogram' ),

			Field::inst( 'scsxxth.tanggal' )
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
			Field::inst( 'scsxxth.mobil_nomor' ),
			Field::inst( 'scsxxth.supir_nama' ),

			Field::inst( 'iwhxxmh.nama' ),
			Field::inst( 'grlxxmh.nama' ),
			Field::inst( 'sodxxth.kode' ),

		)
		->leftJoin( 'iwhxxmh','iwhxxmh.id','=','scsxxth.id_iwhxxmh' )
		->leftJoin( 'grlxxmh','grlxxmh.id','=','scsxxth.id_grlxxmh_customer' )
		->leftJoin( 'sodxxth','sodxxth.id','=','scsxxth.id_sodxxth' )
		;
	
		// BEGIN where single data view
	// if (isset($_POST['rowid']) && $_POST['rowid'] > 0) {
	// 	$rowid = $_POST['rowid'];
	// 	$editor
	// 		->where( 'scsxxth.id', $rowid);
	// }else{
	// 	$editor
	// 		->where( 'scsxxth.tanggal', $_POST['start_date'], '>=' )
	// 		->where( 'scsxxth.tanggal', $_POST['end_date'], '<=' );
	// }
	// END where single data view

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_scsxxth'] == 0){
		$editor
			->where( 'scsxxth.transaction_state', -9, '<>');
	}
	
	include( "scsxxth_extra.php" );

	// BEGIN log
	$nama_table = 'scsxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>