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
	
	if ( ! isset($_POST['id_rmsxxmh']) || ! is_numeric($_POST['id_rmsxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'rmsxxmh_rwpxxmh' )
			->debug(true)
			->fields(
				Field::inst( 'rmsxxmh_rwpxxmh.id' ),
				Field::inst( 'rmsxxmh_rwpxxmh.id_rmsxxmh' ),
				Field::inst( 'rmsxxmh_rwpxxmh.id_rwpxxmh' ),
				Field::inst( 'rmsxxmh_rwpxxmh.kode' ),
				Field::inst( 'rmsxxmh_rwpxxmh.nama' ),
				Field::inst( 'rmsxxmh_rwpxxmh.keterangan' ),
				Field::inst( 'rmsxxmh_rwpxxmh.created_by' ),
				Field::inst( 'rmsxxmh_rwpxxmh.transaction_state' ),
				Field::inst( 'rmsxxmh_rwpxxmh.approval_state' ),
				Field::inst( 'rmsxxmh_rwpxxmh.start_at' ),
				Field::inst( 'rmsxxmh_rwpxxmh.finish_at' ),
				Field::inst( 'rmsxxmh_rwpxxmh.is_defaultprogram' ),

				Field::inst( 'rwpxxmh.kode' ),
				Field::inst( 'rwpxxmh.nama' )
			)
			->leftJoin( 'rwpxxmh','rwpxxmh.id','=','rmsxxmh_rwpxxmh.id_rwpxxmh' )
			->where('rmsxxmh_rwpxxmh.id_rmsxxmh',$_POST['id_rmsxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_rmsxxmh_rwpxxmh'] == 0){
			$editor
				->where( 'rmsxxmh_rwpxxmh.transaction_state', -9, '<>');
		}
		
		include( "rmsxxmh_rwpxxmh_extra.php" );

		// BEGIN log
		$nama_table = 'rmsxxmh_rwpxxmh';
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