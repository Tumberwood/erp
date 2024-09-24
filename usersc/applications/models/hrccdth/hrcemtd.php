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
	
	if ( ! isset($_POST['id_hrccdth']) || ! is_numeric($_POST['id_hrccdth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'hrcemtd' )
			->debug(true)
			->fields(
				Field::inst( 'hrcemtd.id' ),
				Field::inst( 'hrcemtd.id_hrccdth' ),
				Field::inst( 'hrcemtd.id_hcdxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hrcemtd.id_hrremth' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hrcemtd.kode' ),
				Field::inst( 'hrcemtd.nama' ),
				Field::inst( 'hrcemtd.keterangan' ),
				Field::inst( 'hrcemtd.created_by' ),
				Field::inst( 'hrcemtd.transaction_state' ),
				Field::inst( 'hrcemtd.approval_state' ),
				Field::inst( 'hrcemtd.start_at' ),
				Field::inst( 'hrcemtd.finish_at' ),
				Field::inst( 'hrcemtd.is_nextprocess' ),
				Field::inst( 'hrcemtd.is_defaultprogram' ),
				Field::inst( 'hrcemtd.tempat' ),
				Field::inst( 'hrcemtd.agenda' ),
				Field::inst( 'hrcemtd.hetxxmh_nama' ),
				Field::inst( 'hrcemtd.email' ),
				Field::inst( 'hrcemtd.handphone' ),

				Field::inst( 'hcdxxmh.nama' ),
				Field::inst( 'hcdcsmh.email_personal' ),
				Field::inst( 'hcdcsmh.handphone' ),
				Field::inst( 'hrremth.kode' ),
				Field::inst( 'hetxxmh.nama' ),
			)
			->leftJoin( 'hcdxxmh','hcdxxmh.id','=','hrcemtd.id_hcdxxmh' )
			->leftJoin( 'hcdcsmh','hcdcsmh.id_hcdxxmh','=','hcdxxmh.id' )
			->leftJoin( 'hrremth','hrremth.id','=','hrcemtd.id_hrremth' )
			->leftJoin( 'hetxxmh','hetxxmh.id','=','hrremth.id_hetxxmh' )
			->where('hrcemtd.id_hrccdth',$_POST['id_hrccdth'])
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hrcemtd'] == 0){
			$editor
				->where( 'hrcemtd.transaction_state', -9, '<>');
		}
		
		include( "hrcemtd_extra.php" );

		// BEGIN log
		$nama_table = 'hrcemtd';
		include( "../../../helpers/edt_log.php" );
		// END log
		
		$json = $editor
			->process( $_POST )
			->data();

		// debugging hak akses
		$json['hakakses'] = $hakakses;

		echo json_encode( $json );

	}
?>