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
	
	if ( ! isset($_POST['id_hfkxxth']) || ! is_numeric($_POST['id_hfkxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'hfkobtd' )
			->debug(true)
			->fields(
				Field::inst( 'hfkobtd.id' ),
				Field::inst( 'hfkobtd.id_hfkxxth' ),
				Field::inst( 'hfkobtd.id_hfoprmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hfkobtd.id_hfoxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hfkobtd.id_hfogrmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hfkobtd.id_iumxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hfkobtd.id_hfmxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hfkobtd.kode' ),
				Field::inst( 'hfkobtd.nama' ),
				Field::inst( 'hfkobtd.keterangan' ),
				Field::inst( 'hfkobtd.created_by' ),
				Field::inst( 'hfkobtd.transaction_state' ),
				Field::inst( 'hfkobtd.approval_state' ),
				Field::inst( 'hfkobtd.start_at' ),
				Field::inst( 'hfkobtd.finish_at' ),
				Field::inst( 'hfkobtd.is_nextprocess' ),
				Field::inst( 'hfkobtd.is_defaultprogram' ),
				Field::inst( 'hfkobtd.polarisasi' ),
				Field::inst( 'hfkobtd.target_atas' ),
				Field::inst( 'hfkobtd.target_bawah' ),
				Field::inst( 'hfkobtd.bobot_persen' ),
				Field::inst( 'hfkobtd.cara_hitung' ),

				Field::inst( 'hfoprmh.nama' ),
				Field::inst( 'hfoxxmh.kode' ),
				Field::inst( 'hfoxxmh.nama' ),
				Field::inst( 'iumxxmh.kode' ),
				Field::inst( 'hfogrmh.color' ),
			)
			->leftJoin( 'hfoprmh','hfoprmh.id','=','hfkobtd.id_hfoprmh' )
			->leftJoin( 'hfoxxmh','hfoxxmh.id','=','hfkobtd.id_hfoxxmh' )
			->leftJoin( 'iumxxmh','iumxxmh.id','=','hfkobtd.id_iumxxmh' )
			->leftJoin( 'hfogrmh','hfogrmh.id','=','hfkobtd.id_hfogrmh' )
			->where('hfkobtd.id_hfkxxth',$_POST['id_hfkxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hfkobtd'] == 0){
			$editor
				->where( 'hfkobtd.transaction_state', -9, '<>');
		}
		
		include( "hfkobtd_extra.php" );

		// BEGIN log
		$nama_table = 'hfkobtd';
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