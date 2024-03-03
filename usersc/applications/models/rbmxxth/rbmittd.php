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
		$editor = Editor::inst( $db, 'rbmittd' )
			->debug(true)
			->fields(
				Field::inst( 'rbmittd.id' ),
				Field::inst( 'rbmittd.id_rbmxxth' ),
				Field::inst( 'rbmittd.id_iimxxmh' ),
				Field::inst( 'rbmittd.id_iumxxmh_unit' ),
				Field::inst( 'rbmittd.id_iumxxmh_terkecil' ),
				Field::inst( 'rbmittd.kode' ),
				Field::inst( 'rbmittd.nama' ),
				Field::inst( 'rbmittd.keterangan' ),
				Field::inst( 'rbmittd.created_by' ),
				Field::inst( 'rbmittd.transaction_state' ),
				Field::inst( 'rbmittd.approval_state' ),
				Field::inst( 'rbmittd.start_at' ),
				Field::inst( 'rbmittd.finish_at' ),
				Field::inst( 'rbmittd.is_defaultprogram' ),
				Field::inst( 'rbmittd.jumlah_unit' ),
				Field::inst( 'rbmittd.jumlah_terkecil' ),

				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'iumxxmh.kode' )
			)
			->leftJoin( 'iimxxmh','iimxxmh.id','=','rbmittd.id_iimxxmh' )
			->leftJoin( 'iumxxmh','iumxxmh.id','=','rbmittd.id_iumxxmh_unit' )
			->where('rbmittd.id_rbmxxth',$_POST['id_rbmxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_rbmittd'] == 0){
			$editor
				->where( 'rbmittd.transaction_state', -9, '<>');
		}
		
		include( "rbmittd_extra.php" );

		// BEGIN log
		$nama_table = 'rbmittd';
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