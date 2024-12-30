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
	
	if ( ! isset($_POST['id_hprstmh']) || ! is_numeric($_POST['id_hprstmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'hprstmd' )
			->debug(true)
			->fields(
				Field::inst( 'hprstmd.id' ),
				Field::inst( 'hprstmd.id_hprstmh' ),
				Field::inst( 'hprstmd.kode' ),
				Field::inst( 'hprstmd.nama' ),
				Field::inst( 'hprstmd.keterangan' ),
				Field::inst( 'hprstmd.created_by' ),
				Field::inst( 'hprstmd.transaction_state' ),
				Field::inst( 'hprstmd.approval_state' ),
				Field::inst( 'hprstmd.start_at' ),
				Field::inst( 'hprstmd.finish_at' ),
				Field::inst( 'hprstmd.is_nextprocess' ),
				Field::inst( 'hprstmd.is_defaultprogram' ),
				Field::inst( 'hprstmd.kombinasi1' ),
				Field::inst( 'hprstmd.kombinasi2' ),
				Field::inst( 'hprstmd.condition' ),
			)
			->where('hprstmd.id_hprstmh',$_POST['id_hprstmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hprstmd'] == 0){
			$editor
				->where( 'hprstmd.transaction_state', -9, '<>');
		}
		
		include( "hprstmd_extra.php" );

		// BEGIN log
		$nama_table = 'hprstmd';
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