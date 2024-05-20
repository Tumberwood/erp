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
	
	$editor = Editor::inst( $db, 'dbmxxth' )
		->debug(true)
		->fields(
			Field::inst( 'dbmxxth.id' ),
			Field::inst( 'dbmxxth.id_dbmxxth_asal' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'dbmxxth.id_iimxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'dbmxxth.id_iumxxmh_unit' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'dbmxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'dbmxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'dbmxxth.keterangan' ),
			Field::inst( 'dbmxxth.created_by' ),
			Field::inst( 'dbmxxth.transaction_state' ),
			Field::inst( 'dbmxxth.approval_state' ),
			Field::inst( 'dbmxxth.start_at' ),
			Field::inst( 'dbmxxth.finish_at' ),
			Field::inst( 'dbmxxth.is_defaultprogram' ),
			Field::inst( 'dbmxxth.revisi_ke' ),
			Field::inst( 'dbmxxth.tanggal' )
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
			Field::inst( 'iimxxmh.kode' ),
			Field::inst( 'iimxxmh.nama' )
		)
		->leftJoin( 'iimxxmh','iimxxmh.id','=','dbmxxth.id_iimxxmh' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_dbmxxth'] == 0){
		$editor
			->where( 'dbmxxth.transaction_state', -9, '<>');
	}
	
	include( "dbmxxth_extra.php" );

	// BEGIN log
	$nama_table = 'dbmxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>