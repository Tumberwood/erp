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
	
	$editor = Editor::inst( $db, 'itixxth' )
		->debug(true)
		->fields(
			Field::inst( 'itixxth.id' ),
			Field::inst( 'itixxth.id_gbrxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gbrxxmh),
			Field::inst( 'itixxth.id_itoxxth' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'itixxth.id_iwhxxmh_asal' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'itixxth.id_iwhxxmh_tujuan' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'itixxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'itixxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'itixxth.keterangan' ),
			Field::inst( 'itixxth.created_by' ),
			Field::inst( 'itixxth.transaction_state' ),
			Field::inst( 'itixxth.approval_state' ),
			Field::inst( 'itixxth.start_at' ),
			Field::inst( 'itixxth.finish_at' ),
			Field::inst( 'itixxth.tanggal' )
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
			Field::inst( 'itixxth.is_defaultprogram' ),
			Field::inst( 'iwhxxmh_asal.nama' ),
			Field::inst( 'iwhxxmh_tujuan.nama' )
		)
		->leftJoin( 'iwhxxmh as iwhxxmh_asal','iwhxxmh_asal.id','=','itixxth.id_iwhxxmh_asal' )
		->leftJoin( 'iwhxxmh as iwhxxmh_tujuan','iwhxxmh_tujuan.id','=','itixxth.id_iwhxxmh_tujuan' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_itixxth'] == 0){
		$editor
			->where( 'itixxth.transaction_state', -9, '<>');
	}
	
	include( "itixxth_extra.php" );

	// BEGIN log
	$nama_table = 'itixxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>