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
	
	if ( ! isset($_POST['id_hpyxxth']) || ! is_numeric($_POST['id_hpyxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'hpyemtd' )
			->debug(true)
			->fields(
				Field::inst( 'hpyemtd.id' ),
				Field::inst( 'hpyemtd.id_hpyxxth' ),
				Field::inst( 'hpyemtd.kode' ),
				Field::inst( 'hpyemtd.nama' ),
				Field::inst( 'hpyemtd.keterangan' ),
				Field::inst( 'hpyemtd.created_by' ),
				Field::inst( 'hpyemtd.transaction_state' ),
				Field::inst( 'hpyemtd.approval_state' ),
				Field::inst( 'hpyemtd.start_at' ),
				Field::inst( 'hpyemtd.finish_at' ),
				Field::inst( 'hpyemtd.is_nextprocess' ),
				Field::inst( 'hpyemtd.is_defaultprogram' ),
				Field::inst( 'hpyemtd.gp' ),
				Field::inst( 'hpyemtd.gpbpjs' ),
				Field::inst( 'hpyemtd.jht_k' ),
				Field::inst( 'hpyemtd.jht_p' ),
				Field::inst( 'hpyemtd.jkk_p' ),
				Field::inst( 'hpyemtd.jkm_p' ),
				Field::inst( 'hpyemtd.jp_k' ),
				Field::inst( 'hpyemtd.jp_p' ),
				Field::inst( 'hpyemtd.bpjss_k' ),
				Field::inst( 'hpyemtd.bpjss_p' ),
				Field::inst( 'hpyemtd.tlev' ),

				Field::inst( 'hemxxmh.kode as kode' ),
				Field::inst( 'hemxxmh.nama as nama' ),
				Field::inst( 'hetxxmh.nama' ),
				Field::inst( 'hodxxmh.nama' ),
				Field::inst( 'hevxxmh.nama' ),
				Field::inst( 'heyxxmh.nama' ),
				Field::inst( 'heyxxmd.nama' ),
				Field::inst( 'hesxxmh.nama' ),
			)
			->leftJoin( 'hemxxmh','hemxxmh.id','=','hpyemtd.id_hemxxmh' )
			->leftJoin( 'hemjbmh','hemjbmh.id_hemxxmh','=','hemxxmh.id' )
			->leftJoin( 'hetxxmh','hetxxmh.id','=','hemjbmh.id_hetxxmh' )
			->leftJoin( 'hevxxmh','hevxxmh.id','=','hemjbmh.id_hevxxmh' )
			->leftJoin( 'hodxxmh','hodxxmh.id','=','hemjbmh.id_hodxxmh' )
			->leftJoin( 'heyxxmh','heyxxmh.id','=','hemjbmh.id_heyxxmh' )
			->leftJoin( 'heyxxmd','heyxxmd.id','=','hemjbmh.id_heyxxmd' )
			->leftJoin( 'hesxxmh','hesxxmh.id','=','hemjbmh.id_hesxxmh' )
			->where('hpyemtd.id_hpyxxth',$_POST['id_hpyxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hpyemtd'] == 0){
			$editor
				->where( 'hpyemtd.transaction_state', -9, '<>');
		}
		
		include( "hpyemtd_extra.php" );

		// BEGIN log
		$nama_table = 'hpyemtd';
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