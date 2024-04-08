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
	
	$editor = Editor::inst( $db, 'ndixxtd' )
		->debug(true)
		->fields(
			Field::inst( 'ndixxtd.id' ),
			Field::inst( 'ndixxtd.id_grlxxmh_expedisi' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'ndixxtd.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'ndixxtd.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'ndixxtd.keterangan' ),
			Field::inst( 'ndixxtd.created_by' ),
			Field::inst( 'ndixxtd.transaction_state' ),
			Field::inst( 'ndixxtd.approval_state' ),
			Field::inst( 'ndixxtd.start_at' ),
			Field::inst( 'ndixxtd.finish_at' ),
			Field::inst( 'ndixxtd.is_defaultprogram' ),

			Field::inst( 'ndixxtd.dokumen_nomor' ),
			Field::inst( 'ndixxtd.tanggal_jam_kirim' )
				->getFormatter( 'Format::datetime', array(
					'from' => 'Y-m-d H:i:s',
					'to' =>   'd M Y H:i'
				) )
				->setFormatter( 'Format::datetime', array(
					'from' => 'd M Y H:i',
					'to' =>   'Y-m-d H:i:s'
				) ),
			Field::inst( 'ndixxtd.pengirim' ),
			Field::inst( 'ndixxtd.kepada' ),

			Field::inst( 'grlxxmh.nama' )
		)
		->leftJoin( 'grlxxmh','grlxxmh.id','=','ndixxtd.id_grlxxmh_expedisi' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_ndixxtd'] == 0){
		$editor
			->where( 'ndixxtd.transaction_state', -9, '<>');
	}
	
	include( "ndixxtd_extra.php" );

	// BEGIN log
	$nama_table = 'ndixxtd';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>