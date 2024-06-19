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
	
	if ( ! isset($_POST['id_iicxxmh']) || ! is_numeric($_POST['id_iicxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'iicxxmh_aakxxmh' )
			->debug(true)
			->fields(
				Field::inst( 'iicxxmh_aakxxmh.id' ),
				Field::inst( 'iicxxmh_aakxxmh.id_iicxxmh' ),
				Field::inst( 'iicxxmh_aakxxmh.id_aakxxmh_persediaan' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'iicxxmh_aakxxmh.id_aakxxmh_biaya' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'iicxxmh_aakxxmh.kode' ),
				Field::inst( 'iicxxmh_aakxxmh.nama' ),
				Field::inst( 'iicxxmh_aakxxmh.keterangan' ),
				Field::inst( 'iicxxmh_aakxxmh.created_by' ),
				Field::inst( 'iicxxmh_aakxxmh.transaction_state' ),
				Field::inst( 'iicxxmh_aakxxmh.approval_state' ),
				Field::inst( 'iicxxmh_aakxxmh.start_at' ),
				Field::inst( 'iicxxmh_aakxxmh.finish_at' ),
				Field::inst( 'iicxxmh_aakxxmh.is_defaultprogram' ),

				Field::inst( 'concat(aakxxmh_persediaan.kode," - ",aakxxmh_persediaan.nama) as aakxxmh_persediaan' ),
				Field::inst( 'concat(aakxxmh_biaya.kode," - ",aakxxmh_biaya.nama) as aakxxmh_biaya' )
				
			)
			->leftJoin( 'aakxxmh as aakxxmh_persediaan','aakxxmh_persediaan.id','=','iicxxmh_aakxxmh.id_aakxxmh_persediaan' )
			->leftJoin( 'aakxxmh as aakxxmh_biaya','aakxxmh_biaya.id','=','iicxxmh_aakxxmh.id_aakxxmh_biaya' )
			->where('iicxxmh_aakxxmh.id_iicxxmh',$_POST['id_iicxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_iicxxmh_aakxxmh'] == 0){
			$editor
				->where( 'iicxxmh_aakxxmh.transaction_state', -9, '<>');
		}

		// BEGIN log
		$nama_table = 'iicxxmh_aakxxmh';
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