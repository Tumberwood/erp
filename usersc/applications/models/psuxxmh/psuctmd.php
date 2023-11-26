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
	
	if ( ! isset($_POST['id_psuxxmh']) || ! is_numeric($_POST['id_psuxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'psuctmd' )
			->debug(true)
			->fields(
				Field::inst( 'psuctmd.id' ),
				Field::inst( 'psuctmd.id_psuxxmh' ),
				Field::inst( 'psuctmd.kode' ),
				Field::inst( 'psuctmd.nama' ),
				Field::inst( 'psuctmd.keterangan' ),
				Field::inst( 'psuctmd.created_by' ),
				Field::inst( 'psuctmd.transaction_state' ),
				Field::inst( 'psuctmd.approval_state' ),
				Field::inst( 'psuctmd.start_at' ),
				Field::inst( 'psuctmd.finish_at' ),
				Field::inst( 'psuctmd.is_defaultprogram' ),
				Field::inst( 'psuctmd.email' ),
				Field::inst( 'psuctmd.posisi' ),
				Field::inst( 'psuctmd.handphone' )
			)
			->where('psuctmd.id_psuxxmh',$_POST['id_psuxxmh'])
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_psuctmd'] == 0){
			$editor
				->where( 'psuctmd.transaction_state', -9, '<>');
		}
		
		include( "psuctmd_extra.php" );

		// BEGIN log
		$nama_table = 'psuctmd';
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