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
	
	if ( ! isset($_POST['id_dbmxxth']) || ! is_numeric($_POST['id_dbmxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'dbmwptd' )
			->debug(true)
			->fields(
				Field::inst( 'dbmwptd.id' ),
				Field::inst( 'dbmwptd.id_dbmxxth' ),
				Field::inst( 'dbmwptd.id_rwpxxmh' ),
				Field::inst( 'dbmwptd.kode' ),
				Field::inst( 'dbmwptd.nama' ),
				Field::inst( 'dbmwptd.keterangan' ),
				Field::inst( 'dbmwptd.created_by' ),
				Field::inst( 'dbmwptd.transaction_state' ),
				Field::inst( 'dbmwptd.approval_state' ),
				Field::inst( 'dbmwptd.start_at' ),
				Field::inst( 'dbmwptd.finish_at' ),
				Field::inst( 'dbmwptd.is_defaultprogram' ),
				Field::inst( 'dbmwptd.cycletime' ),

				Field::inst( 'rwpxxmh.kode' ),
				Field::inst( 'rwpxxmh.nama' )
			)
			->leftJoin( 'rwpxxmh','rwpxxmh.id','=','dbmwptd.id_rwpxxmh' )
			->where('dbmwptd.id_dbmxxth',$_POST['id_dbmxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_dbmwptd'] == 0){
			$editor
				->where( 'dbmwptd.transaction_state', -9, '<>');
		}
		
		include( "dbmwptd_extra.php" );

		// BEGIN log
		$nama_table = 'dbmwptd';
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