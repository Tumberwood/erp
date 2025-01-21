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
	
	if ( ! isset($_POST['id_aabxxth']) || ! is_numeric($_POST['id_aabxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'aabaktd' )
			->debug(true)
			->fields(
				Field::inst( 'aabaktd.id' ),
				Field::inst( 'aabaktd.id_aabxxth' ),
				Field::inst( 'aabaktd.id_aakxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'aabaktd.kode' ),
				Field::inst( 'aabaktd.nama' ),
				Field::inst( 'aabaktd.keterangan' ),
				Field::inst( 'aabaktd.created_by' ),
				Field::inst( 'aabaktd.transaction_state' ),
				Field::inst( 'aabaktd.approval_state' ),
				Field::inst( 'aabaktd.start_at' ),
				Field::inst( 'aabaktd.finish_at' ),
				Field::inst( 'aabaktd.is_nextprocess' ),
				Field::inst( 'aabaktd.is_defaultprogram' ),
				Field::inst( 'aabaktd.nominal' ),
				Field::inst( 'aakxxmh.kode' ),
				Field::inst( 'aakxxmh.nama' ),
			)
			->leftJoin( 'aakxxmh','aakxxmh.id','=','aabaktd.id_aakxxmh' )
			->where('aabaktd.id_aabxxth',$_POST['id_aabxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_aabaktd'] == 0){
			$editor
				->where( 'aabaktd.transaction_state', -9, '<>');
		}
		
		include( "aabaktd_extra.php" );

		// BEGIN log
		$nama_table = 'aabaktd';
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