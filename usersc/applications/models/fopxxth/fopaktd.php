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
	
	if ( ! isset($_POST['id_fopxxth']) || ! is_numeric($_POST['id_fopxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'fopaktd' )
			->debug(true)
			->fields(
				Field::inst( 'fopaktd.id' ),
				Field::inst( 'fopaktd.id_fopxxth' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'fopaktd.id_aakxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'fopaktd.kode' ),
				Field::inst( 'fopaktd.nama' ),
				Field::inst( 'fopaktd.keterangan' ),
				Field::inst( 'fopaktd.created_by' ),
				Field::inst( 'fopaktd.transaction_state' ),
				Field::inst( 'fopaktd.approval_state' ),
				Field::inst( 'fopaktd.start_at' ),
				Field::inst( 'fopaktd.finish_at' ),
				Field::inst( 'fopaktd.is_defaultprogram' ),

				Field::inst( 'fopaktd.amount' ),

				Field::inst( 'concat(aakxxmh.kode," - ",aakxxmh.nama) as fopaktd.aakxxmh' )
			)
			->leftJoin( 'aakxxmh','aakxxmh.id','=','fopaktd.id_aakxxmh' )
			->where('fopaktd.id_fopxxth',$_POST['id_fopxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_fopaktd'] == 0){
			$editor
				->where( 'fopaktd.transaction_state', -9, '<>');
		}
		
		include( "fopaktd_extra.php" );

		// BEGIN log
		$nama_table = 'fopaktd';
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