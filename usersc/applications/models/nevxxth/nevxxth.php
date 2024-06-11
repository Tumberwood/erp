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
	
	$editor = Editor::inst( $db, 'nevxxth' )
		->debug(true)
		->fields(
			Field::inst( 'nevxxth.id' ),
			Field::inst( 'nevxxth.id_nirxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'nevxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'nevxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'nevxxth.keterangan' ),
			Field::inst( 'nevxxth.created_by' ),
			Field::inst( 'nevxxth.transaction_state' ),
			Field::inst( 'nevxxth.approval_state' ),
			Field::inst( 'nevxxth.start_at' ),
			Field::inst( 'nevxxth.finish_at' ),
			Field::inst( 'nevxxth.is_defaultprogram' ),
			Field::inst( 'nevxxth.is_nextprocess' ),

			Field::inst( 'nevxxth.tanggaljam_awal' )
				->getFormatter( 'Format::datetime', array(
					'from' => 'Y-m-d H:i:s',
					'to' =>   'd M Y H:i'
				) )
				->setFormatter( 'Format::datetime', array(
					'from' => 'd M Y H:i',
					'to' =>   'Y-m-d H:i:s'
				) ),
			Field::inst( 'nevxxth.tanggaljam_akhir' )
				->getFormatter( 'Format::datetime', array(
					'from' => 'Y-m-d H:i:s',
					'to' =>   'd M Y H:i'
				) )
				->setFormatter( 'Format::datetime', array(
					'from' => 'd M Y H:i',
					'to' =>   'Y-m-d H:i:s'
				) ),
			Field::inst( 'nevxxth.is_repeat' ),
			Field::inst( 'nevxxth.repeat_every' ),
			Field::inst( 'nevxxth.repeat_periode' ),
			Field::inst( 'nevxxth.repeat_cycle' ),

			Field::inst( 'nirxxmh.nama' )
		)
		->leftJoin( 'nirxxmh','nirxxmh.id','=','nevxxth.id_nirxxmh' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_nevxxth'] == 0){
		$editor
			->where( 'nevxxth.transaction_state', -9, '<>');
	}
	
	include( "nevxxth_extra.php" );

	// BEGIN log
	$nama_table = 'nevxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>