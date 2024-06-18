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
	
	$editor = Editor::inst( $db, 'sdlxxth' )
		->debug(true)
		->fields(
			Field::inst( 'sdlxxth.id' ),
			Field::inst( 'sdlxxth.id_gcpxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gcpxxmh),
			Field::inst( 'sdlxxth.id_gbrxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gbrxxmh),
			Field::inst( 'sdlxxth.id_iwhxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sdlxxth.id_grlxxmh_customer' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sdlxxth.id_sodxxth' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sdlxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'sdlxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'sdlxxth.keterangan' ),
			Field::inst( 'sdlxxth.created_by' ),
			Field::inst( 'sdlxxth.transaction_state' ),
			Field::inst( 'sdlxxth.approval_state' ),
			Field::inst( 'sdlxxth.start_at' ),
			Field::inst( 'sdlxxth.finish_at' ),
			Field::inst( 'sdlxxth.is_defaultprogram' ),

			Field::inst( 'sdlxxth.tanggal' )
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
			Field::inst( 'sdlxxth.mobil_nomor' ),
			Field::inst( 'sdlxxth.supir_nama' ),

			Field::inst( 'iwhxxmh.nama' ),
			Field::inst( 'grlxxmh.nama' ),
			Field::inst( 'sodxxth.kode' )

		)
		->leftJoin( 'iwhxxmh','iwhxxmh.id','=','sdlxxth.id_iwhxxmh' )
		->leftJoin( 'grlxxmh','grlxxmh.id','=','sdlxxth.id_grlxxmh_customer' )
		->leftJoin( 'sodxxth','sodxxth.id','=','sdlxxth.id_sodxxth' )
		;
	
		// BEGIN where single data view
	// if (isset($_POST['rowid']) && $_POST['rowid'] > 0) {
	// 	$rowid = $_POST['rowid'];
	// 	$editor
	// 		->where( 'sdlxxth.id', $rowid);
	// }else{
	// 	$editor
	// 		->where( 'sdlxxth.tanggal', $_POST['start_date'], '>=' )
	// 		->where( 'sdlxxth.tanggal', $_POST['end_date'], '<=' );
	// }
	// END where single data view

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_sdlxxth'] == 0){
		$editor
			->where( 'sdlxxth.transaction_state', -9, '<>');
	}
	
	include( "sdlxxth_extra.php" );

	// BEGIN log
	$nama_table = 'sdlxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>