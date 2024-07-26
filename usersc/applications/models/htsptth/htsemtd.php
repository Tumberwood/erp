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
	if ( ! isset($_POST['id_htsptth']) || ! is_numeric($_POST['id_htsptth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'htsemtd' )
			->debug(true)
			->fields(
				Field::inst( 'htsemtd.id' ),
				Field::inst( 'htsemtd.id_htsptth' ),
				Field::inst( 'htsemtd.id_hemxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'htsemtd.kode' ),
				Field::inst( 'htsemtd.nama' ),
				Field::inst( 'htsemtd.keterangan' ),
				Field::inst( 'htsemtd.is_nextprocess' ),
				Field::inst( 'htsemtd.transaction_state' ),
				Field::inst( 'htsemtd.approval_state' ),
				Field::inst( 'htsemtd.start_at' ),
				Field::inst( 'htsemtd.finish_at' ),
				Field::inst( 'htsemtd.grup_ke' ),

				Field::inst( 'concat(hemxxmh.kode," - ",hemxxmh.nama) as hemxxmh_data' ),

				Field::inst( 'hodxxmh.nama' ),
				Field::inst( 'hetxxmh.nama' )
			)
			->leftJoin( 'hemxxmh','hemxxmh.id','=','htsemtd.id_hemxxmh' )
			->leftJoin( 'hemjbmh','hemjbmh.id_hemxxmh','=','hemxxmh.id' )
			->leftJoin( 'hodxxmh','hodxxmh.id','=','hemjbmh.id_hodxxmh' )
			->leftJoin( 'hetxxmh','hetxxmh.id','=','hemjbmh.id_hetxxmh' )
			->where('htsemtd.id_htsptth',$_POST['id_htsptth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_htsemtd'] == 0){
			$editor
				->where( 'htsemtd.transaction_state', -9, '<>');
		}
		
		include( "htsemtd_extra.php" );

		// BEGIN log
		$nama_table = 'htsemtd';
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