<?php
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	// include_once( "../../../helpers/hakakses_s_fn.php" );
	
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
	
	if ( ! isset($_POST['id_hcdxxmh']) || ! is_numeric($_POST['id_hcdxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'hcdedmd' )
			->debug(true)
			->fields(
				Field::inst( 'hcdedmd.id' ),
				Field::inst( 'hcdedmd.id_hcdxxmh' ),
				Field::inst( 'hcdedmd.id_gctxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hcdedmd.id_hgnedmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hcdedmd.kode' ),
				Field::inst( 'hcdedmd.nama' ),
				Field::inst( 'hcdedmd.keterangan' ),
				Field::inst( 'hcdedmd.created_by' ),
				Field::inst( 'hcdedmd.transaction_state' ),
				Field::inst( 'hcdedmd.approval_state' ),
				Field::inst( 'hcdedmd.start_at' ),
				Field::inst( 'hcdedmd.finish_at' ),
				Field::inst( 'hcdedmd.is_defaultprogram' ),
				Field::inst( 'hcdedmd.tahun_lulus' ),
				Field::inst( 'hcdedmd.jurusan' ),
				Field::inst( 'hcdedmd.nilai_akhir' ),

				Field::inst( 'gctxxmh.nama' ),
				Field::inst( 'hgnedmh.nama' )
			)
			->leftJoin( 'gctxxmh','gctxxmh.id','=','hcdedmd.id_gctxxmh' )
			->leftJoin( 'hgnedmh','hgnedmh.id','=','hcdedmd.id_hgnedmh' )
			->where('hcdedmd.id_hcdxxmh',$_POST['id_hcdxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hcdedmd'] == 0){
			$editor
				->where( 'hcdedmd.transaction_state', -9, '<>');
		}
		
		// include( "hcdedmd_extra.php" );

		// BEGIN log
		// $nama_table = 'hcdedmd';
		// include( "../../../helpers/edt_log.php" );
		// END log
		
		$json = $editor
			->process( $_POST )
			->data();

		// debugging hak akses
		// // $json['hakakses'] = $hakakses;

		echo json_encode( $json );

	}
?>