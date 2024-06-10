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
	
	if ( ! isset($_POST['id_ndctoth']) || ! is_numeric($_POST['id_ndctoth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'ndctotd' )
			->debug(true)
			->fields(
				Field::inst( 'ndctotd.id' ),
				Field::inst( 'ndctotd.id_ndctoth' ),
				Field::inst( 'ndctotd.id_ndcxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'ndctotd.kode' ),
				Field::inst( 'ndctotd.nama' ),
				Field::inst( 'ndctotd.keterangan' ),
				Field::inst( 'ndctotd.created_by' ),
				Field::inst( 'ndctotd.transaction_state' ),
				Field::inst( 'ndctotd.approval_state' ),
				Field::inst( 'ndctotd.start_at' ),
				Field::inst( 'ndctotd.finish_at' ),
				Field::inst( 'ndctotd.is_defaultprogram' ),

				Field::inst( 'ndcxxmh.dokumen_nomor' ),
				Field::inst( 'ndcrctd.pengirim' ),
				Field::inst( 'ndcrctd.kepada' )
					->set( Field::SET_NONE ),
				Field::inst( 'ndcrctd.tanggal_jam_terima' )
					->getFormatter( 'Format::datetime', array(
						'from' => 'Y-m-d H:i:s',
						'to' =>   'd M Y H:i'
					) )
			)
			->leftJoin( 'ndcxxmh','ndcxxmh.id','=','ndctotd.id_ndcxxmh' )
			->leftJoin( 'ndcrctd','ndcrctd.id_ndcxxmh','=','ndcxxmh.id' )
			->where('ndctotd.id_ndctoth',$_POST['id_ndctoth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_ndctotd'] == 0){
			$editor
				->where( 'ndctotd.transaction_state', -9, '<>');
		}
		
		include( "ndctotd_extra.php" );

		// BEGIN log
		$nama_table = 'ndctotd';
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