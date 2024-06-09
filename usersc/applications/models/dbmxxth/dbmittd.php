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
	
	if ( ! isset($_POST['id_dbmxxth']) || ! is_numeric($_POST['id_dbmxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'dbmittd' )
			->debug(true)
			->fields(
				Field::inst( 'dbmittd.id' ),
				Field::inst( 'dbmittd.id_dbmxxth' ),
				Field::inst( 'dbmittd.id_iimxxmh' ),
				Field::inst( 'dbmittd.id_iumxxmh_unit' ),
				Field::inst( 'dbmittd.id_iumxxmh_terkecil' ),
				Field::inst( 'dbmittd.kode' ),
				Field::inst( 'dbmittd.nama' ),
				Field::inst( 'dbmittd.keterangan' ),
				Field::inst( 'dbmittd.created_by' ),
				Field::inst( 'dbmittd.transaction_state' ),
				Field::inst( 'dbmittd.approval_state' ),
				Field::inst( 'dbmittd.start_at' ),
				Field::inst( 'dbmittd.finish_at' ),
				Field::inst( 'dbmittd.is_defaultprogram' ),
				Field::inst( 'dbmittd.jumlah_unit' ),
				Field::inst( 'dbmittd.jumlah_terkecil' ),

				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'iumxxmh.kode' )
			)
			->leftJoin( 'iimxxmh','iimxxmh.id','=','dbmittd.id_iimxxmh' )
			->leftJoin( 'iumxxmh','iumxxmh.id','=','dbmittd.id_iumxxmh_unit' )
			->where('dbmittd.id_dbmxxth',$_POST['id_dbmxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_dbmittd'] == 0){
			$editor
				->where( 'dbmittd.transaction_state', -9, '<>');
		}
		
		include( "dbmittd_extra.php" );

		// BEGIN log
		$nama_table = 'dbmittd';
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