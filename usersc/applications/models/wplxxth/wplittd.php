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
	
	if ( ! isset($_POST['id_wplxxth']) || ! is_numeric($_POST['id_wplxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'wplittd' )
			->debug(true)
			->fields(
				Field::inst( 'wplittd.id' ),
				Field::inst( 'wplittd.id_wplxxth' ),
				Field::inst( 'wplittd.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wplittd.id_wdoittd' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wplittd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wplittd.kode' ),
				Field::inst( 'wplittd.nama' ),
				Field::inst( 'wplittd.keterangan' ),
				Field::inst( 'wplittd.created_by' ),
				Field::inst( 'wplittd.transaction_state' ),
				Field::inst( 'wplittd.approval_state' ),
				Field::inst( 'wplittd.start_at' ),
				Field::inst( 'wplittd.finish_at' ),
				Field::inst( 'wplittd.is_defaultprogram' ),
				Field::inst( 'wplittd.jumlah_unit' ),
				
				Field::inst( 'iumxxmh.nama' ),
				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
			)
			->leftJoin( 'iumxxmh','iumxxmh.id','=','wplittd.id_iumxxmh_unit' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','wplittd.id_iimxxmh' )
			->where('wplittd.id_wplxxth',$_POST['id_wplxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_wplittd'] == 0){
			$editor
				->where( 'wplittd.transaction_state', -9, '<>');
		}
		
		
		// BEGIN log
		$nama_table = 'wplittd';
		$nama_table_before = 'wdoittd';
		include( "wplittd_extra.php" );
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