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
	
	if ( ! isset($_POST['id_ndctith']) || ! is_numeric($_POST['id_ndctith']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'ndctitd' )
			->debug(true)
			->fields(
				Field::inst( 'ndctitd.id' ),
				Field::inst( 'ndctitd.id_ndctith' ),
				Field::inst( 'ndctitd.id_ndcxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'ndctitd.kode' ),
				Field::inst( 'ndctitd.nama' ),
				Field::inst( 'ndctitd.keterangan' ),
				Field::inst( 'ndctitd.created_by' ),
				Field::inst( 'ndctitd.transaction_state' ),
				Field::inst( 'ndctitd.approval_state' ),
				Field::inst( 'ndctitd.start_at' ),
				Field::inst( 'ndctitd.finish_at' ),
				Field::inst( 'ndctitd.is_nextprocess' ),
				Field::inst( 'ndctitd.is_defaultprogram' ),

				Field::inst( 'ndcxxmh.dokumen_nomor' ),
				Field::inst( 'ndcrctd.pengirim' ),
				Field::inst( 'ndcrctd.kepada' ),
				Field::inst( 'ndcrctd.tanggal_jam_terima' )
					->getFormatter( 'Format::datetime', array(
						'from' => 'Y-m-d H:i:s',
						'to' =>   'd M Y H:i'
					) )
			)
			->leftJoin( 'ndcxxmh','ndcxxmh.id','=','ndctitd.id_ndcxxmh' )
			->leftJoin( 'ndcrctd','ndcrctd.id_ndcxxmh','=','ndcxxmh.id' )
			->where('ndctitd.id_ndctith',$_POST['id_ndctith']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_ndctitd'] == 0){
			$editor
				->where( 'ndctitd.transaction_state', -9, '<>');
		}
		
		include( "ndctitd_extra.php" );

		// BEGIN log
		$nama_table = 'ndctitd';
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