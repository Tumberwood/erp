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
	
	$editor = Editor::inst( $db, 'fbtxxth' )
		->debug(true)
		->fields(
			Field::inst( 'fbtxxth.id' ),
			Field::inst( 'fbtxxth.id_gbrxxmh_asal' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'fbtxxth.id_gbrxxmh_tujuan' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'fbtxxth.id_aakxxmh_asal' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'fbtxxth.id_aakxxmh_tujuan' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'fbtxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'fbtxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'fbtxxth.keterangan' ),
			Field::inst( 'fbtxxth.created_by' ),
			Field::inst( 'fbtxxth.transaction_state' ),
			Field::inst( 'fbtxxth.approval_state' ),
			Field::inst( 'fbtxxth.start_at' ),
			Field::inst( 'fbtxxth.finish_at' ),
			Field::inst( 'fbtxxth.is_defaultprogram' ),

			Field::inst( 'fbtxxth.tanggal' )
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
			Field::inst( 'fbtxxth.amount' ),

			Field::inst( 'aakxxmh_asal.nama' ),
			Field::inst( 'aakxxmh_tujuan.nama' )
		)
		->leftJoin( 'aakxxmh as aakxxmh_asal ','aakxxmh_asal.id','=','fbtxxth.id_aakxxmh_asal' )
		->leftJoin( 'aakxxmh as aakxxmh_tujuan','aakxxmh_tujuan.id','=','fbtxxth.id_aakxxmh_tujuan' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_fbtxxth'] == 0){
		$editor
			->where( 'fbtxxth.transaction_state', -9, '<>');
	}
	
	include( "fbtxxth_extra.php" );

	// BEGIN log
	$nama_table = 'fbtxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>