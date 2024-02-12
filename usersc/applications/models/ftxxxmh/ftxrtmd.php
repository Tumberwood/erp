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
	
	if ( ! isset($_POST['id_ftxxxmh']) || ! is_numeric($_POST['id_ftxxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'ftxrtmd' )
			->debug(true)
			->fields(
				Field::inst( 'ftxrtmd.id' ),
				Field::inst( 'ftxrtmd.id_ftxxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'ftxrtmd.kode' ),
				Field::inst( 'ftxrtmd.nama' ),
				Field::inst( 'ftxrtmd.keterangan' ),
				Field::inst( 'ftxrtmd.created_by' ),
				Field::inst( 'ftxrtmd.transaction_state' ),
				Field::inst( 'ftxrtmd.approval_state' ),
				Field::inst( 'ftxrtmd.start_at' ),
				Field::inst( 'ftxrtmd.finish_at' ),
				Field::inst( 'ftxrtmd.is_defaultprogram' ),
				Field::inst( 'ftxrtmd.batas_bawah' ),
				Field::inst( 'ftxrtmd.batas_atas' ),
				Field::inst( 'ftxrtmd.tarif' )
			)
			->where('ftxrtmd.id_ftxxxmh',$_POST['id_ftxxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_ftxrtmd'] == 0){
			$editor
				->where( 'ftxrtmd.transaction_state', -9, '<>');
		}
		
		include( "ftxrtmd_extra.php" );

		// BEGIN log
		$nama_table = 'ftxrtmd';
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