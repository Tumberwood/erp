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
	
	$editor = Editor::inst( $db, 'itoxxth' )
		->debug(true)
		->fields(
			Field::inst( 'itoxxth.id' ),
			Field::inst( 'itoxxth.id_gbrxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gbrxxmh),
			Field::inst( 'itoxxth.id_iwhxxmh_asal' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'itoxxth.id_iwhxxmh_tujuan' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'itoxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'itoxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'itoxxth.keterangan' ),
			Field::inst( 'itoxxth.created_by' ),
			Field::inst( 'itoxxth.transaction_state' ),
			Field::inst( 'itoxxth.approval_state' ),
			Field::inst( 'itoxxth.start_at' ),
			Field::inst( 'itoxxth.finish_at' ),
			Field::inst( 'itoxxth.tanggal' )
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
			Field::inst( 'itoxxth.is_defaultprogram' ),
			Field::inst( 'iwhxxmh_asal.nama' ),
			Field::inst( 'iwhxxmh_tujuan.nama' )
		)
		->leftJoin( 'iwhxxmh as iwhxxmh_asal','iwhxxmh_asal.id','=','itoxxth.id_iwhxxmh_asal' )
		->leftJoin( 'iwhxxmh as iwhxxmh_tujuan','iwhxxmh_tujuan.id','=','itoxxth.id_iwhxxmh_tujuan' )
		->where( 'itoxxth.tanggal', $_POST['start_date'], '>=' )
		->where( 'itoxxth.tanggal', $_POST['end_date'], '<=' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_itoxxth'] == 0){
		$editor
			->where( 'itoxxth.transaction_state', -9, '<>');
	}
	
	include( "itoxxth_extra.php" );

	// BEGIN log
	$nama_table = 'itoxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>