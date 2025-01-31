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
	
	if ( ! isset($_POST['id_pivxxth']) || ! is_numeric($_POST['id_pivxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'pivaktd' )
			->debug(true)
			->fields(
				Field::inst( 'pivaktd.id' ),
				Field::inst( 'pivaktd.id_pivxxth' ),
				Field::inst( 'pivaktd.id_aakxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'pivaktd.kode' ),
				Field::inst( 'pivaktd.nama' ),
				Field::inst( 'pivaktd.keterangan' ),
				Field::inst( 'pivaktd.created_by' ),
				Field::inst( 'pivaktd.transaction_state' ),
				Field::inst( 'pivaktd.approval_state' ),
				Field::inst( 'pivaktd.start_at' ),
				Field::inst( 'pivaktd.finish_at' ),
				Field::inst( 'pivaktd.is_nextprocess' ),
				Field::inst( 'pivaktd.is_defaultprogram' ),
				Field::inst( 'pivaktd.nominal' ),
				Field::inst( 'aakxxmh.kode' ),
				Field::inst( 'aakxxmh.nama' ),
			)
			->leftJoin( 'aakxxmh','aakxxmh.id','=','pivaktd.id_aakxxmh' )
			->where('pivaktd.id_pivxxth',$_POST['id_pivxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_pivaktd'] == 0){
			$editor
				->where( 'pivaktd.transaction_state', -9, '<>');
		}
		
		include( "pivaktd_extra.php" );

		// BEGIN log
		$nama_table = 'pivaktd';
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