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
		$editor = Editor::inst( $db, 'hcdrfmd' )
			->debug(true)
			->fields(
				Field::inst( 'hcdrfmd.id' ),
				Field::inst( 'hcdrfmd.id_hcdxxmh' ),
				Field::inst( 'hcdrfmd.alamat' ),
				Field::inst( 'hcdrfmd.no_hp' ),
				Field::inst( 'hcdrfmd.pekerjaan' ),
				Field::inst( 'hcdrfmd.hubungan' ),
				Field::inst( 'hcdrfmd.kode' ),
				Field::inst( 'hcdrfmd.nama' ),
				Field::inst( 'hcdrfmd.keterangan' ),
				Field::inst( 'hcdrfmd.created_by' ),
				Field::inst( 'hcdrfmd.transaction_state' ),
				Field::inst( 'hcdrfmd.approval_state' ),
				Field::inst( 'hcdrfmd.start_at' ),
				Field::inst( 'hcdrfmd.finish_at' ),
				Field::inst( 'hcdrfmd.is_defaultprogram' ),
			)
			->where('hcdrfmd.id_hcdxxmh',$_POST['id_hcdxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hcdrfmd'] == 0){
			$editor
				->where( 'hcdrfmd.transaction_state', -9, '<>');
		}
		
		// include( "hcdrfmd_extra.php" );

		// BEGIN log
		// $nama_table = 'hcdrfmd';
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