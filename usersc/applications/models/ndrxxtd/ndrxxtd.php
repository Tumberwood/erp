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
	
	$editor = Editor::inst( $db, 'ndrxxtd' )
		->debug(true)
		->fields(
			Field::inst( 'ndrxxtd.id' ),
			Field::inst( 'ndrxxtd.id_grlxxmh_expedisi' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'ndrxxtd.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'ndrxxtd.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'ndrxxtd.keterangan' ),
			Field::inst( 'ndrxxtd.created_by' ),
			Field::inst( 'ndrxxtd.transaction_state' ),
			Field::inst( 'ndrxxtd.approval_state' ),
			Field::inst( 'ndrxxtd.start_at' ),
			Field::inst( 'ndrxxtd.finish_at' ),
			Field::inst( 'ndrxxtd.is_defaultprogram' ),

			Field::inst( 'ndrxxtd.dokumen_nomor' ),
			Field::inst( 'ndrxxtd.tanggal_jam_terima' )
				->getFormatter( 'Format::datetime', array(
					'from' => 'Y-m-d H:i:s',
					'to' =>   'd M Y H:i'
				) )
				->setFormatter( 'Format::datetime', array(
					'from' => 'd M Y H:i',
					'to' =>   'Y-m-d H:i:s'
				) ),
			Field::inst( 'ndrxxtd.pengirim' ),
			Field::inst( 'ndrxxtd.kepada' ),

			Field::inst( 'grlxxmh.nama' )
		)
		->leftJoin( 'grlxxmh','grlxxmh.id','=','ndrxxtd.id_grlxxmh_expedisi' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_ndrxxtd'] == 0){
		$editor
			->where( 'ndrxxtd.transaction_state', -9, '<>');
	}
	
	include( "ndrxxtd_extra.php" );

	// BEGIN log
	$nama_table = 'ndrxxtd';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>