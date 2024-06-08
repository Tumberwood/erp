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
	
	if ( ! isset($_POST['id_grlxxmh']) || ! is_numeric($_POST['id_grlxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'ltrvttd' )
			->debug(true)
			->fields(
				Field::inst( 'ltrvttd.id' ),
				Field::inst( 'ltrvttd.id_grlxxmh' ),
				Field::inst( 'ltrvttd.id_lvtxxmh' ),
				Field::inst( 'ltrvttd.id_gctxxmh_asal' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'ltrvttd.id_gctxxmh_tujuan' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'ltrvttd.kode' ),
				Field::inst( 'ltrvttd.nama' ),
				Field::inst( 'ltrvttd.keterangan' ),
				Field::inst( 'ltrvttd.created_by' ),
				Field::inst( 'ltrvttd.transaction_state' ),
				Field::inst( 'ltrvttd.approval_state' ),
				Field::inst( 'ltrvttd.start_at' ),
				Field::inst( 'ltrvttd.finish_at' ),
				Field::inst( 'ltrvttd.is_defaultprogram' ),
				Field::inst( 'ltrvttd.tarif_lvtxxmh' ),

				Field::inst( 'lvtxxmh.nama' ),

				Field::inst( 'gctxxmh_asal.nama' ),
				Field::inst( 'gctxxmh_tujuan.nama' )
			)
			->leftJoin( 'lvtxxmh','lvtxxmh.id','=','ltrvttd.id_lvtxxmh' )
			->leftJoin( 'gctxxmh as gctxxmh_asal','gctxxmh_asal.id','=','ltrvttd.id_gctxxmh_asal' )
			->leftJoin( 'gctxxmh as gctxxmh_tujuan','gctxxmh_tujuan.id','=','ltrvttd.id_gctxxmh_tujuan' )
			->where('ltrvttd.id_grlxxmh',$_POST['id_grlxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_ltrvttd'] == 0){
			$editor
				->where( 'ltrvttd.transaction_state', -9, '<>');
		}
		
		include( "ltrvttd_extra.php" );

		// BEGIN log
		$nama_table = 'ltrvttd';
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