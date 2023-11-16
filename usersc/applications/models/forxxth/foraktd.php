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
	
	if ( ! isset($_POST['id_forxxth']) || ! is_numeric($_POST['id_forxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'foraktd' )
			->debug(true)
			->fields(
				Field::inst( 'foraktd.id' ),
				Field::inst( 'foraktd.id_forxxth' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'foraktd.id_aakxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'foraktd.kode' ),
				Field::inst( 'foraktd.nama' ),
				Field::inst( 'foraktd.keterangan' ),
				Field::inst( 'foraktd.created_by' ),
				Field::inst( 'foraktd.transaction_state' ),
				Field::inst( 'foraktd.approval_state' ),
				Field::inst( 'foraktd.start_at' ),
				Field::inst( 'foraktd.finish_at' ),
				Field::inst( 'foraktd.is_defaultprogram' ),

				Field::inst( 'foraktd.amount' ),

				Field::inst( 'concat(aakxxmh.kode," - ",aakxxmh.nama) as foraktd.aakxxmh' )
			)
			->leftJoin( 'aakxxmh','aakxxmh.id','=','foraktd.id_aakxxmh' )
			->where('foraktd.id_forxxth',$_POST['id_forxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_foraktd'] == 0){
			$editor
				->where( 'foraktd.transaction_state', -9, '<>');
		}
		
		include( "foraktd_extra.php" );

		// BEGIN log
		$nama_table = 'foraktd';
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