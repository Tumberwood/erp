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
	
	if ( ! isset($_POST['id_grlxxmh']) || ! is_numeric($_POST['id_grlxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'ltrcttd' )
			->debug(true)
			->fields(
				Field::inst( 'ltrcttd.id' ),
				Field::inst( 'ltrcttd.id_grlxxmh' ),
				Field::inst( 'ltrcttd.id_gctxxmh_asal' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'ltrcttd.id_gctxxmh_tujuan' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'ltrcttd.kode' ),
				Field::inst( 'ltrcttd.nama' ),
				Field::inst( 'ltrcttd.keterangan' ),
				Field::inst( 'ltrcttd.created_by' ),
				Field::inst( 'ltrcttd.transaction_state' ),
				Field::inst( 'ltrcttd.approval_state' ),
				Field::inst( 'ltrcttd.start_at' ),
				Field::inst( 'ltrcttd.finish_at' ),
				Field::inst( 'ltrcttd.is_defaultprogram' ),
				Field::inst( 'ltrcttd.tarif_kg' ),

				Field::inst( 'gctxxmh_asal.nama' ),
				Field::inst( 'gctxxmh_tujuan.nama' )
			)
			->leftJoin( 'gctxxmh as gctxxmh_asal','gctxxmh_asal.id','=','ltrcttd.id_gctxxmh_asal' )
			->leftJoin( 'gctxxmh as gctxxmh_tujuan','gctxxmh_tujuan.id','=','ltrcttd.id_gctxxmh_tujuan' )
			->where('ltrcttd.id_grlxxmh',$_POST['id_grlxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_ltrcttd'] == 0){
			$editor
				->where( 'ltrcttd.transaction_state', -9, '<>');
		}
		
		include( "ltrcttd_extra.php" );

		// BEGIN log
		$nama_table = 'ltrcttd';
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