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
		$editor = Editor::inst( $db, 'hcddhmd' )
			->debug(true)
			->fields(
				Field::inst( 'hcddhmd.id' ),
				Field::inst( 'hcddhmd.id_hcdxxmh' ),
				Field::inst( 'hcddhmd.kode' ),
				Field::inst( 'hcddhmd.nama' ),
				Field::inst( 'hcddhmd.keterangan' ),
				Field::inst( 'hcddhmd.created_by' ),
				Field::inst( 'hcddhmd.transaction_state' ),
				Field::inst( 'hcddhmd.approval_state' ),
				Field::inst( 'hcddhmd.start_at' ),
				Field::inst( 'hcddhmd.finish_at' ),
				Field::inst( 'hcddhmd.is_defaultprogram' ),
				Field::inst( 'hcddhmd.lama' ),
				Field::inst( 'hcddhmd.tahun' ),
				Field::inst( 'hcddhmd.dirawat_di' ),
			)
			->where('hcddhmd.id_hcdxxmh',$_POST['id_hcdxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hcddhmd'] == 0){
			$editor
				->where( 'hcddhmd.transaction_state', -9, '<>');
		}
		
		// include( "hcddhmd_extra.php" );

		// BEGIN log
		// $nama_table = 'hcddhmd';
		// include( "../../../helpers/edt_log.php" );
		// END log
		
		$json = $editor
			->process( $_POST )
			->data();

		// debugging hak akses
		// $json['hakakses'] = $hakakses;

		echo json_encode( $json );

	}
?>