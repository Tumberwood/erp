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
		$editor = Editor::inst( $db, 'hcdlgmd' )
			->debug(true)
			->fields(
				Field::inst( 'hcdlgmd.id' ),
				Field::inst( 'hcdlgmd.id_hcdxxmh' ),
				Field::inst( 'hcdlgmd.kode' ),
				Field::inst( 'hcdlgmd.nama' ),
				Field::inst( 'hcdlgmd.keterangan' ),
				Field::inst( 'hcdlgmd.created_by' ),
				Field::inst( 'hcdlgmd.transaction_state' ),
				Field::inst( 'hcdlgmd.approval_state' ),
				Field::inst( 'hcdlgmd.start_at' ),
				Field::inst( 'hcdlgmd.finish_at' ),
				Field::inst( 'hcdlgmd.is_defaultprogram' ),
			
				Field::inst( 'hcdlgmd.mendengar' ),
				Field::inst( 'hcdlgmd.membaca' ),
				Field::inst( 'hcdlgmd.menulis' ),
				Field::inst( 'hcdlgmd.percakapan' ),
			)
			->where('hcdlgmd.id_hcdxxmh',$_POST['id_hcdxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hcdlgmd'] == 0){
			$editor
				->where( 'hcdlgmd.transaction_state', -9, '<>');
		}
		
		// include( "hcdlgmd_extra.php" );

		// BEGIN log
		// $nama_table = 'hcdlgmd';
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