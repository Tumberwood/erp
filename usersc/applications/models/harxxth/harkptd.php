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
	
	if ( ! isset($_POST['id_harxxth']) || ! is_numeric($_POST['id_harxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'harkptd' )
			->debug(true)
			->fields(
				Field::inst( 'harkptd.id' ),
				Field::inst( 'harkptd.id_harxxth' ),
				Field::inst( 'harkptd.id_hpcxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'harkptd.kode' ),
				Field::inst( 'harkptd.nama' ),
				Field::inst( 'harkptd.keterangan' ),
				Field::inst( 'harkptd.created_by' ),
				Field::inst( 'harkptd.transaction_state' ),
				Field::inst( 'harkptd.approval_state' ),
				Field::inst( 'harkptd.start_at' ),
				Field::inst( 'harkptd.finish_at' ),
				Field::inst( 'harkptd.is_nextprocess' ),
				Field::inst( 'harkptd.is_defaultprogram' ),
				Field::inst( 'harkptd.nominal' ),
				Field::inst( 'hpcxxmh.nama' ),
			)
			->leftJoin( 'hpcxxmh','hpcxxmh.id','=','harkptd.id_hpcxxmh' )
			->where('harkptd.id_harxxth',$_POST['id_harxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_harkptd'] == 0){
			$editor
				->where( 'harkptd.transaction_state', -9, '<>');
		}
		
		include( "harkptd_extra.php" );

		// BEGIN log
		$nama_table = 'harkptd';
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