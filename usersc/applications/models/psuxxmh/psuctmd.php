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
	
	if ( ! isset($_POST['id_grlxxmh']) || ! is_numeric($_POST['id_grlxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'grlctmd' )
			->debug(true)
			->fields(
				Field::inst( 'grlctmd.id' ),
				Field::inst( 'grlctmd.id_grlxxmh' ),
				Field::inst( 'grlctmd.kode' ),
				Field::inst( 'grlctmd.nama' ),
				Field::inst( 'grlctmd.keterangan' ),
				Field::inst( 'grlctmd.created_by' ),
				Field::inst( 'grlctmd.transaction_state' ),
				Field::inst( 'grlctmd.approval_state' ),
				Field::inst( 'grlctmd.start_at' ),
				Field::inst( 'grlctmd.finish_at' ),
				Field::inst( 'grlctmd.is_defaultprogram' ),
				Field::inst( 'grlctmd.email' ),
				Field::inst( 'grlctmd.posisi' ),
				Field::inst( 'grlctmd.handphone' )
			)
			->where('grlctmd.id_grlxxmh',$_POST['id_grlxxmh'])
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_grlctmd'] == 0){
			$editor
				->where( 'grlctmd.transaction_state', -9, '<>');
		}
		
		include( "psuctmd_extra.php" );

		// BEGIN log
		$nama_table = 'grlctmd';
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