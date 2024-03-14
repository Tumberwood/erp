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
	
	if ( ! isset($_POST['id_gapxxsh']) || ! is_numeric($_POST['id_gapxxsh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'gapdusd' )
			->debug(true)
			->fields(
				Field::inst( 'gapdusd.id' ),
				Field::inst( 'gapdusd.id_gapxxsh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'gapdusd.id_users' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'gapdusd.kode' ),
				Field::inst( 'gapdusd.nama' ),
				Field::inst( 'gapdusd.keterangan' ),
				Field::inst( 'gapdusd.created_by' ),
				Field::inst( 'gapdusd.transaction_state' ),
				Field::inst( 'gapdusd.approval_state' ),
				Field::inst( 'gapdusd.start_at' ),
				Field::inst( 'gapdusd.finish_at' ),
				Field::inst( 'gapdusd.is_defaultprogram' ),
				Field::inst( 'gapdusd.level_ke' ),
				Field::inst( 'gapdusd.gaptpmh_value_fr' ),
				Field::inst( 'gapdusd.gaptpmh_value_to' ),

				Field::inst( 'users.username' )
			)
			->leftJoin( 'users','users.id','=','gapdusd.id_users' )
			->where('gapdusd.id_gapxxsh',$_POST['id_gapxxsh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_gapdusd'] == 0){
			$editor
				->where( 'gapdusd.transaction_state', -9, '<>');
		}
		
		include( "gapdusd_extra.php" );

		// BEGIN log
		$nama_table = 'gapdusd';
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