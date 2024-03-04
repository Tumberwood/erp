<?php
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../helpers/hakakses_s_fn.php" );
	
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
	
	$editor = Editor::inst( $db, 'prqxxth' )
		->debug(true)
		->fields(
			Field::inst( 'prqxxth.id' ),
			Field::inst( 'prqxxth.id_hodxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'prqxxth.id_gcpxxmh' )
				->set( Field::SET_CREATE )
				->setValue(1),
			Field::inst( 'prqxxth.id_gbrxxmh' )
				->set( Field::SET_CREATE )
				->setValue(1),
			Field::inst( 'prqxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'prqxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'prqxxth.keterangan' ),
			Field::inst( 'prqxxth.created_by' ),
			Field::inst( 'prqxxth.transaction_state' ),
			Field::inst( 'prqxxth.approval_state' ),
			Field::inst( 'prqxxth.start_at' ),
			Field::inst( 'prqxxth.finish_at' ),
			Field::inst( 'prqxxth.is_defaultprogram' ),
			Field::inst( 'prqxxth.is_nextprocess' ),
			Field::inst( 'prqxxth.tanggal' )
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
			
			Field::inst( 'hodxxmh.nama' )
		)
		->leftJoin( 'hodxxmh','hodxxmh.id','=','prqxxth.id_hodxxmh' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_prqxxth'] == 0){
		$editor
			->where( 'prqxxth.transaction_state', -9, '<>');
	}
	
	include( "prqxxth_extra.php" );


	// BEGIN log
	$nama_table = 'prqxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>