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
	
	if ( ! isset($_POST['id_wktxxth']) || ! is_numeric($_POST['id_wktxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'wktittd' )
			->debug(true)
			->fields(
				Field::inst( 'wktittd.id' ),
				Field::inst( 'wktittd.id_grlxxmh_customer' ),
				Field::inst( 'wktittd.id_wktxxth' ),
				Field::inst( 'wktittd.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wktittd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wktittd.kode' ),
				Field::inst( 'wktittd.nama' ),
				Field::inst( 'wktittd.keterangan' ),
				Field::inst( 'wktittd.created_by' ),
				Field::inst( 'wktittd.transaction_state' ),
				Field::inst( 'wktittd.approval_state' ),
				Field::inst( 'wktittd.start_at' ),
				Field::inst( 'wktittd.finish_at' ),
				Field::inst( 'wktittd.is_defaultprogram' ),
				Field::inst( 'wktittd.jumlah_unit' ),
				Field::inst( 'wktittd.subtotal_jumlah_unit' ),
				
				Field::inst( 'grlxxmh.nama' ),
				Field::inst( 'iumxxmh.nama' ),
				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
			)
			->leftJoin( 'iumxxmh','iumxxmh.id','=','wktittd.id_iumxxmh_unit' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','wktittd.id_iimxxmh' )
			->leftJoin( 'grlxxmh','grlxxmh.id','=','wktittd.id_grlxxmh_customer' )
			->where('wktittd.id_wktxxth',$_POST['id_wktxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_wktittd'] == 0){
			$editor
				->where( 'wktittd.transaction_state', -9, '<>');
		}
		
		
		// BEGIN log
		$nama_table = 'wktittd';
		include( "wktittd_extra.php" );
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