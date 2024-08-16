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
	
	$editor = Editor::inst( $db, 'sdlxxth_sig1' )
		->debug(true)
		->fields(
			Field::inst( 'sdlxxth_sig1.id' ),
			Field::inst( 'sdlxxth_sig1.id_gcpxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gcpxxmh),
			Field::inst( 'sdlxxth_sig1.id_gbrxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gbrxxmh),
			Field::inst( 'sdlxxth_sig1.id_iwhxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sdlxxth_sig1.id_imtxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sdlxxth_sig1.id_grlxxmh_customer' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'sdlxxth_sig1.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'sdlxxth_sig1.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'sdlxxth_sig1.keterangan' ),
			Field::inst( 'sdlxxth_sig1.created_by' ),
			Field::inst( 'sdlxxth_sig1.transaction_state' ),
			Field::inst( 'sdlxxth_sig1.approval_state' ),
			Field::inst( 'sdlxxth_sig1.start_at' ),
			Field::inst( 'sdlxxth_sig1.finish_at' ),
			Field::inst( 'sdlxxth_sig1.is_nextprocess' ),
			Field::inst( 'sdlxxth_sig1.is_defaultprogram' ),

			Field::inst( 'sdlxxth_sig1.tanggal' )
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
			Field::inst( 'sdlxxth_sig1.mobil_nomor' ),
			Field::inst( 'sdlxxth_sig1.supir_nama' ),
			Field::inst( 'sdlxxth_sig1.referensi' ),
			Field::inst( 'sdlxxth_sig1.plat_nomor' ),

			Field::inst( 'iwhxxmh.nama' ),
			Field::inst( 'imtxxmh.movement_type' ),
			Field::inst( 'grlxxmh.nama' ),

		)
		->leftJoin( 'iwhxxmh','iwhxxmh.id','=','sdlxxth_sig1.id_iwhxxmh' )
		->leftJoin( 'imtxxmh','imtxxmh.id','=','sdlxxth_sig1.id_imtxxmh' )
		->leftJoin( 'grlxxmh','grlxxmh.id','=','sdlxxth_sig1.id_grlxxmh_customer' )
		->where( 'sdlxxth_sig1.tanggal', $_POST['start_date'], '>=' )
		->where( 'sdlxxth_sig1.tanggal', $_POST['end_date'], '<=' )
		;

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_sdlxxth_sig1'] == 0){
		$editor
			->where( 'sdlxxth_sig1.transaction_state', -9, '<>');
	}
	
	include( "sdlxxth_sig1_extra.php" );

	// BEGIN log
	$nama_table = 'sdlxxth_sig1';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>