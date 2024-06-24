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
	
	if ( ! isset($_POST['id_gapxxsh']) || ! is_numeric($_POST['id_gapxxsh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'gaptbtd' )
			->debug(true)
			->fields(
				Field::inst( 'gaptbtd.id' ),
				Field::inst( 'gaptbtd.id_gapxxsh' ),
				Field::inst( 'gaptbtd.id_gtbrlsh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'gaptbtd.kode' ),
				Field::inst( 'gaptbtd.nama' ),
				Field::inst( 'gaptbtd.keterangan' ),
				Field::inst( 'gaptbtd.created_by' ),
				Field::inst( 'gaptbtd.transaction_state' ),
				Field::inst( 'gaptbtd.approval_state' ),
				Field::inst( 'gaptbtd.start_at' ),
				Field::inst( 'gaptbtd.finish_at' ),
				Field::inst( 'gaptbtd.is_defaultprogram' ),

				Field::inst( 'gtbrlsh.nama' )
			)
			->leftJoin( 'gtbrlsh','gtbrlsh.id','=','gaptbtd.id_gtbrlsh' )
			->where('gaptbtd.id_gapxxsh',$_POST['id_gapxxsh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_gaptbtd'] == 0){
			$editor
				->where( 'gaptbtd.transaction_state', -9, '<>');
		}
		
		include( "gaptbtd_extra.php" );

		// BEGIN log
		$nama_table = 'gaptbtd';
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