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
	
	if ( ! isset($_POST['id_sivxxth']) || ! is_numeric($_POST['id_sivxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'sivaktd' )
			->debug(true)
			->fields(
				Field::inst( 'sivaktd.id' ),
				Field::inst( 'sivaktd.id_sivxxth' ),
				Field::inst( 'sivaktd.id_aakxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sivaktd.kode' ),
				Field::inst( 'sivaktd.nama' ),
				Field::inst( 'sivaktd.keterangan' ),
				Field::inst( 'sivaktd.created_by' ),
				Field::inst( 'sivaktd.transaction_state' ),
				Field::inst( 'sivaktd.approval_state' ),
				Field::inst( 'sivaktd.start_at' ),
				Field::inst( 'sivaktd.finish_at' ),
				Field::inst( 'sivaktd.is_nextprocess' ),
				Field::inst( 'sivaktd.is_defaultprogram' ),
				Field::inst( 'sivaktd.nominal' ),
				Field::inst( 'aakxxmh.kode' ),
				Field::inst( 'aakxxmh.nama' ),
			)
			->leftJoin( 'aakxxmh','aakxxmh.id','=','sivaktd.id_aakxxmh' )
			->where('sivaktd.id_sivxxth',$_POST['id_sivxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_sivaktd'] == 0){
			$editor
				->where( 'sivaktd.transaction_state', -9, '<>');
		}
		
		include( "sivaktd_extra.php" );

		// BEGIN log
		$nama_table = 'sivaktd';
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