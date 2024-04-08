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
	
	if ( ! isset($_POST['id_ndoxxth']) || ! is_numeric($_POST['id_ndoxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'ndodctd' )
			->debug(true)
			->fields(
				Field::inst( 'ndodctd.id' ),
				Field::inst( 'ndodctd.id_ndoxxth' ),
				Field::inst( 'ndodctd.id_ndrxxtd' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'ndodctd.kode' ),
				Field::inst( 'ndodctd.nama' ),
				Field::inst( 'ndodctd.keterangan' ),
				Field::inst( 'ndodctd.created_by' ),
				Field::inst( 'ndodctd.transaction_state' ),
				Field::inst( 'ndodctd.approval_state' ),
				Field::inst( 'ndodctd.start_at' ),
				Field::inst( 'ndodctd.finish_at' ),
				Field::inst( 'ndodctd.is_defaultprogram' ),

				Field::inst( 'ndrxxtd.dokumen_nomor' ),
				Field::inst( 'ndrxxtd.pengirim' ),
				Field::inst( 'ndrxxtd.kepada' ),
				Field::inst( 'ndrxxtd.tanggal_jam_terima' )
					->getFormatter( 'Format::datetime', array(
						'from' => 'Y-m-d H:i:s',
						'to' =>   'd M Y H:i'
					) )
			)
			->leftJoin( 'ndrxxtd','ndrxxtd.id','=','ndodctd.id_ndrxxtd' )
			->where('ndodctd.id_ndoxxth',$_POST['id_ndoxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_ndodctd'] == 0){
			$editor
				->where( 'ndodctd.transaction_state', -9, '<>');
		}
		
		include( "ndodctd_extra.php" );

		// BEGIN log
		$nama_table = 'ndodctd';
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