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
		$editor = Editor::inst( $db, 'hcdecmd' )
			->debug(true)
			->fields(
				Field::inst( 'hcdecmd.id' ),
				Field::inst( 'hcdecmd.id_hcdxxmh' ),
				Field::inst( 'hcdecmd.kode' ),
				Field::inst( 'hcdecmd.nama' ),
				Field::inst( 'hcdecmd.keterangan' ),
				Field::inst( 'hcdecmd.created_by' ),
				Field::inst( 'hcdecmd.transaction_state' ),
				Field::inst( 'hcdecmd.approval_state' ),
				Field::inst( 'hcdecmd.start_at' ),
				Field::inst( 'hcdecmd.finish_at' ),
				Field::inst( 'hcdecmd.is_defaultprogram' ),
				Field::inst( 'hcdecmd.alamat' ),
				Field::inst( 'hcdecmd.no_hp' ),
				Field::inst( 'hcdecmd.hubungan' ),
			)
			->where('hcdecmd.id_hcdxxmh',$_POST['id_hcdxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hcdecmd'] == 0){
			$editor
				->where( 'hcdecmd.transaction_state', -9, '<>');
		}
		
		// include( "hcdecmd_extra.php" );

		// BEGIN log
		// $nama_table = 'hcdecmd';
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