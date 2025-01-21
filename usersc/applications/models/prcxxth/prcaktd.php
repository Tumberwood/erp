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
	
	if ( ! isset($_POST['id_prcxxth']) || ! is_numeric($_POST['id_prcxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'prcaktd' )
			->debug(true)
			->fields(
				Field::inst( 'prcaktd.id' ),
				Field::inst( 'prcaktd.id_prcxxth' ),
				Field::inst( 'prcaktd.id_aakxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'prcaktd.kode' ),
				Field::inst( 'prcaktd.nama' ),
				Field::inst( 'prcaktd.keterangan' ),
				Field::inst( 'prcaktd.created_by' ),
				Field::inst( 'prcaktd.transaction_state' ),
				Field::inst( 'prcaktd.approval_state' ),
				Field::inst( 'prcaktd.start_at' ),
				Field::inst( 'prcaktd.finish_at' ),
				Field::inst( 'prcaktd.is_nextprocess' ),
				Field::inst( 'prcaktd.is_defaultprogram' ),
				Field::inst( 'prcaktd.nominal' ),
				Field::inst( 'aakxxmh.kode' ),
				Field::inst( 'aakxxmh.nama' ),
			)
			->leftJoin( 'aakxxmh','aakxxmh.id','=','prcaktd.id_aakxxmh' )
			->where('prcaktd.id_prcxxth',$_POST['id_prcxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_prcaktd'] == 0){
			$editor
				->where( 'prcaktd.transaction_state', -9, '<>');
		}
		
		include( "prcaktd_extra.php" );

		// BEGIN log
		$nama_table = 'prcaktd';
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