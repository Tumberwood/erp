<?php
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../helpers/hakakses_s_fn.php" );
	include_once( "../../../helpers/SolusiIndonesiaUtilities.php" );
	include_once( "../../../helpers/fn_is_nextprocess.php" );
	include_once( "../../../helpers/fn_is_default_update_d.php" );
	
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
	
	if ( ! isset($_POST['id_iimxxmh']) || ! is_numeric($_POST['id_iimxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'iimrlmd_supplier' )
			->debug(true)
			->fields(
				Field::inst( 'iimrlmd_supplier.id' ),
				Field::inst( 'iimrlmd_supplier.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'iimrlmd_supplier.id_grlxxmh_supplier' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'iimrlmd_supplier.kode' ),
				Field::inst( 'iimrlmd_supplier.nama' ),
				Field::inst( 'iimrlmd_supplier.keterangan' ),
				Field::inst( 'iimrlmd_supplier.created_by' ),
				Field::inst( 'iimrlmd_supplier.transaction_state' ),
				Field::inst( 'iimrlmd_supplier.approval_state' ),
				Field::inst( 'iimrlmd_supplier.start_at' ),
				Field::inst( 'iimrlmd_supplier.finish_at' ),
				Field::inst( 'iimrlmd_supplier.is_defaultprogram' ),
				Field::inst( 'iimrlmd_supplier.is_nextprocess' ),
				Field::inst( 'iimrlmd_supplier.is_default' ),
				
				Field::inst( 'iimrlmd_supplier.leadtime_hari' ),
				Field::inst( 'iimrlmd_supplier.moq' ),

				Field::inst( 'grlxxmh.nama' )
			)
			->leftJoin( 'grlxxmh','grlxxmh.id','=','iimrlmd_supplier.id_grlxxmh_supplier' )
			->where('iimrlmd_supplier.id_iimxxmh',$_POST['id_iimxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_iimrlmd_supplier'] == 0){
			$editor
				->where( 'iimrlmd_supplier.transaction_state', -9, '<>');
		}
		
		include( "iimrlmd_supplier_extra.php" );

		// BEGIN log
		$nama_table = 'iimrlmd_supplier';
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