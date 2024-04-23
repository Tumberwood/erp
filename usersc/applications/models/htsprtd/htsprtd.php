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
		
	$editor = Editor::inst( $db, 'htsprtd' )
		->debug(true)
		->fields(
			Field::inst( 'htsprtd.id' ),
			Field::inst( 'htsprtd.id_users' ),
			Field::inst( 'htsprtd.id_hemxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'htsprtd.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'htsprtd.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'htsprtd.keterangan' ),
			Field::inst( 'htsprtd.created_by' ),
			Field::inst( 'htsprtd.transaction_state' ),
			Field::inst( 'htsprtd.approval_state' ),
			Field::inst( 'htsprtd.start_at' ),
			Field::inst( 'htsprtd.finish_at' ),
			Field::inst( 'htsprtd.is_defaultprogram' ),
			Field::inst( 'htsprtd.username' ),
			Field::inst( 'htsprtd.tanggal' )
				->getFormatter( function ( $val, $data, $opts ) {
					if ($val === '0000-00-00' || $val === null){
						return '';
					}else{
						return date( 'd M Y', strtotime( $val ) );
					}
				} )
				->setFormatter( 'Format::datetime', array(
					'from' => 'd M Y',
					'to' =>   'Y-m-d'
				) ),
			Field::inst( 'htsprtd.jam' )
				->getFormatter( function ( $val, $data, $opts ) {
					if ($val === null){
						return '';
					}else{
						return date( 'H:i', strtotime( $val ) );
					}
				} )
				->setFormatter( function ( $val ) {
					if ($val === ''){
						return null;
					}else{
						return date( 'H:i:s', strtotime( $val ) );
					}
				} ),
			Field::inst( 'htsprtd.lat' ),
			Field::inst( 'htsprtd.lng' ),
			Field::inst( 'htsprtd.lokasi' ),
			Field::inst( 'htsprtd.checkinout' ),

			Field::inst( 'users.fname' ),
			
			Field::inst( 'concat(hemxxmh.kode, " - ", hemxxmh.nama) as peg' ),
			// Field::inst( 'hemxxmh.nama' )
		)
		// ->leftJoin( 
		// 	'hemxxmh', 
		// 	'hemxxmh.id = htsprtd.id_hemxxmh OR hemxxmh.id_users = htsprtd.id_users', '', '' )
		->leftJoin( 'hemxxmh','hemxxmh.id','=','htsprtd.id_hemxxmh ' )
		->leftJoin( 'users','users.id','=','htsprtd.id_users ' )
		;
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_htsprtd'] == 0){
		$editor
			->where( 'htsprtd.transaction_state', -9, '<>');
	}
	
	include( "htsprtd_extra.php" );

	// BEGIN log
	$nama_table = 'htsprtd';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>