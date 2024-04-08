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
	
	if ( ! isset($_POST['id_ndixxth']) || ! is_numeric($_POST['id_ndixxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'ndidctd' )
			->debug(true)
			->fields(
				Field::inst( 'ndidctd.id' ),
				Field::inst( 'ndidctd.id_ndixxth' ),
				Field::inst( 'ndidctd.id_ndrxxtd' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'ndidctd.kode' ),
				Field::inst( 'ndidctd.nama' ),
				Field::inst( 'ndidctd.keterangan' ),
				Field::inst( 'ndidctd.created_by' ),
				Field::inst( 'ndidctd.transaction_state' ),
				Field::inst( 'ndidctd.approval_state' ),
				Field::inst( 'ndidctd.start_at' ),
				Field::inst( 'ndidctd.finish_at' ),
				Field::inst( 'ndidctd.is_defaultprogram' ),

				Field::inst( 'ndrxxtd.dokumen_nomor' ),
				Field::inst( 'ndrxxtd.pengirim' ),
				Field::inst( 'ndrxxtd.kepada' ),
				Field::inst( 'ndrxxtd.tanggal_jam_terima' )
					->getFormatter( 'Format::datetime', array(
						'from' => 'Y-m-d H:i:s',
						'to' =>   'd M Y H:i'
					) )
			)
			->leftJoin( 'ndrxxtd','ndrxxtd.id','=','ndidctd.id_ndrxxtd' )
			->where('ndidctd.id_ndixxth',$_POST['id_ndixxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_ndidctd'] == 0){
			$editor
				->where( 'ndidctd.transaction_state', -9, '<>');
		}
		
		include( "ndidctd_extra.php" );

		// BEGIN log
		$nama_table = 'ndidctd';
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