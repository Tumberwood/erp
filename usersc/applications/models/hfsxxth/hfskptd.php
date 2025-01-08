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
	
	if ( ! isset($_POST['id_hfsxxth']) || ! is_numeric($_POST['id_hfsxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'hfskptd' )
			->debug(true)
			->fields(
				Field::inst( 'hfskptd.id' ),
				Field::inst( 'hfskptd.id_hfsxxth' ),
				Field::inst( 'hfskptd.id_hfkobtd' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hfskptd.id_hfoprmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hfskptd.id_hfoxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hfskptd.id_iumxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hfskptd.kode' ),
				Field::inst( 'hfskptd.nama' ),
				Field::inst( 'hfskptd.keterangan' ),
				Field::inst( 'hfskptd.created_by' ),
				Field::inst( 'hfskptd.transaction_state' ),
				Field::inst( 'hfskptd.approval_state' ),
				Field::inst( 'hfskptd.start_at' ),
				Field::inst( 'hfskptd.finish_at' ),
				Field::inst( 'hfskptd.is_nextprocess' ),
				Field::inst( 'hfskptd.is_defaultprogram' ),
				Field::inst( 'hfskptd.realisasi' ),
				Field::inst( 'hfskptd.skor' ),
				
				Field::inst( 'hfskptd.polarisasi' ),
				Field::inst( 'hfskptd.target_atas' ),
				Field::inst( 'hfskptd.target_bawah' ),
				Field::inst( 'hfskptd.bobot_persen' ),
				Field::inst( 'hfskptd.cara_hitung' ),
			
				Field::inst( 'hfoprmh.nama' ),
				Field::inst( 'hfoxxmh.nama' ),
				Field::inst( 'iumxxmh.kode' ),
			)
			->leftJoin( 'hfoprmh','hfoprmh.id','=','hfskptd.id_hfoprmh' )
			->leftJoin( 'hfoxxmh','hfoxxmh.id','=','hfskptd.id_hfoxxmh' )
			->leftJoin( 'iumxxmh','iumxxmh.id','=','hfskptd.id_iumxxmh' )
			->leftJoin( 'hfkobtd','hfkobtd.id','=','hfskptd.id_hfkobtd' )
			->where('hfskptd.id_hfsxxth',$_POST['id_hfsxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hfskptd'] == 0){
			$editor
				->where( 'hfskptd.transaction_state', -9, '<>');
		}
		
		include( "hfskptd_extra.php" );

		// BEGIN log
		$nama_table = 'hfskptd';
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