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
	
	if ( ! isset($_POST['id_lexxxmh']) || ! is_numeric($_POST['id_lexxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'lexlomd' )
			->debug(true)
			->fields(
				Field::inst( 'lexlomd.id' ),
				Field::inst( 'lexlomd.id_lexxxmh' ),
				Field::inst( 'lexlomd.id_gctxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'lexlomd.kode' ),
				Field::inst( 'lexlomd.nama' ),
				Field::inst( 'lexlomd.keterangan' ),
				Field::inst( 'lexlomd.created_by' ),
				Field::inst( 'lexlomd.transaction_state' ),
				Field::inst( 'lexlomd.approval_state' ),
				Field::inst( 'lexlomd.start_at' ),
				Field::inst( 'lexlomd.finish_at' ),
				Field::inst( 'lexlomd.is_defaultprogram' ),
				Field::inst( 'lexlomd.pic_email' ),
				Field::inst( 'lexlomd.pic_nama' ),
				Field::inst( 'lexlomd.pic_handphone' ),
				Field::inst( 'lexlomd.alamat' ),

				Field::inst( 'gctxxmh.nama' )
			)
			->leftJoin( 'gctxxmh','gctxxmh.id','=','lexlomd.id_gctxxmh' )
			->where('lexlomd.id_lexxxmh',$_POST['id_lexxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_lexlomd'] == 0){
			$editor
				->where( 'lexlomd.transaction_state', -9, '<>');
		}
		
		include( "lexlomd_extra.php" );

		// BEGIN log
		$nama_table = 'lexlomd';
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