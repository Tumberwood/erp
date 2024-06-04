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
		$editor = Editor::inst( $db, 'hcdogmd' )
			->debug(true)
			->fields(
				Field::inst( 'hcdogmd.id' ),
				Field::inst( 'hcdogmd.id_hcdxxmh' ),
				Field::inst( 'hcdogmd.jenis' ),
				Field::inst( 'hcdogmd.tahun' ),
				Field::inst( 'hcdogmd.jabatan' ),
				Field::inst( 'hcdogmd.kode' ),
				Field::inst( 'hcdogmd.nama' ),
				Field::inst( 'hcdogmd.keterangan' ),
				Field::inst( 'hcdogmd.created_by' ),
				Field::inst( 'hcdogmd.transaction_state' ),
				Field::inst( 'hcdogmd.approval_state' ),
				Field::inst( 'hcdogmd.start_at' ),
				Field::inst( 'hcdogmd.finish_at' ),
				Field::inst( 'hcdogmd.is_defaultprogram' ),
			)
			->where('hcdogmd.id_hcdxxmh',$_POST['id_hcdxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hcdogmd'] == 0){
			$editor
				->where( 'hcdogmd.transaction_state', -9, '<>');
		}
		
		// include( "hcdogmd_extra.php" );

		// BEGIN log
		// $nama_table = 'hcdogmd';
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