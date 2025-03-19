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
	
	if ( ! isset($_POST['id_iigxxmh']) || ! is_numeric($_POST['id_iigxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'iigxxmh_aakxxmh' )
			->debug(true)
			->fields(
				Field::inst( 'iigxxmh_aakxxmh.id' ),
				Field::inst( 'iigxxmh_aakxxmh.id_iigxxmh' ),
				Field::inst( 'iigxxmh_aakxxmh.id_aakxxmh_persediaan' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'iigxxmh_aakxxmh.id_aakxxmh_biaya' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'iigxxmh_aakxxmh.id_aakxxmh_penjualan' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'iigxxmh_aakxxmh.kode' ),
				Field::inst( 'iigxxmh_aakxxmh.nama' ),
				Field::inst( 'iigxxmh_aakxxmh.keterangan' ),
				Field::inst( 'iigxxmh_aakxxmh.created_by' ),
				Field::inst( 'iigxxmh_aakxxmh.transaction_state' ),
				Field::inst( 'iigxxmh_aakxxmh.approval_state' ),
				Field::inst( 'iigxxmh_aakxxmh.start_at' ),
				Field::inst( 'iigxxmh_aakxxmh.finish_at' ),
				Field::inst( 'iigxxmh_aakxxmh.is_defaultprogram' ),

				Field::inst( 'concat(aakxxmh_persediaan.kode," - ",aakxxmh_persediaan.nama) as aakxxmh_persediaan' ),
				Field::inst( 'concat(aakxxmh_biaya.kode," - ",aakxxmh_biaya.nama) as aakxxmh_biaya' ),
				Field::inst( 'concat(aakxxmh_penjualan.kode," - ",aakxxmh_penjualan.nama) as aakxxmh_penjualan' ),
				
			)
			->leftJoin( 'aakxxmh as aakxxmh_persediaan','aakxxmh_persediaan.id','=','iigxxmh_aakxxmh.id_aakxxmh_persediaan' )
			->leftJoin( 'aakxxmh as aakxxmh_biaya','aakxxmh_biaya.id','=','iigxxmh_aakxxmh.id_aakxxmh_biaya' )
			->leftJoin( 'aakxxmh as aakxxmh_penjualan','aakxxmh_penjualan.id','=','iigxxmh_aakxxmh.id_aakxxmh_penjualan' )
			->where('iigxxmh_aakxxmh.id_iigxxmh',$_POST['id_iigxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_iigxxmh_aakxxmh'] == 0){
			$editor
				->where( 'iigxxmh_aakxxmh.transaction_state', -9, '<>');
		}

		// BEGIN log
		$nama_table = 'iigxxmh_aakxxmh';
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