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
	
	if ( ! isset($_POST['id_rbmxxth']) || ! is_numeric($_POST['id_rbmxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'rbmwptd' )
			->debug(true)
			->fields(
				Field::inst( 'rbmwptd.id' ),
				Field::inst( 'rbmwptd.id_rbmxxth' ),
				Field::inst( 'rbmwptd.id_rwpxxmh' ),
				Field::inst( 'rbmwptd.kode' ),
				Field::inst( 'rbmwptd.nama' ),
				Field::inst( 'rbmwptd.keterangan' ),
				Field::inst( 'rbmwptd.created_by' ),
				Field::inst( 'rbmwptd.transaction_state' ),
				Field::inst( 'rbmwptd.approval_state' ),
				Field::inst( 'rbmwptd.start_at' ),
				Field::inst( 'rbmwptd.finish_at' ),
				Field::inst( 'rbmwptd.is_defaultprogram' ),
				Field::inst( 'rbmwptd.cycletime' ),

				Field::inst( 'rwpxxmh.kode' ),
				Field::inst( 'rwpxxmh.nama' )
			)
			->leftJoin( 'rwpxxmh','rwpxxmh.id','=','rbmwptd.id_rwpxxmh' )
			->where('rbmwptd.id_rbmxxth',$_POST['id_rbmxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_rbmwptd'] == 0){
			$editor
				->where( 'rbmwptd.transaction_state', -9, '<>');
		}
		
		include( "rbmwptd_extra.php" );

		// BEGIN log
		$nama_table = 'rbmwptd';
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