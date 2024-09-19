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
	
	if ( ! isset($_POST['id_hrremth']) || ! is_numeric($_POST['id_hrremth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'hrrertd' )
			->debug(true)
			->fields(
				Field::inst( 'hrrertd.id' ),
				Field::inst( 'hrrertd.id_hrremth' ),
				Field::inst( 'hrrertd.id_hemxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hrrertd.kode' ),
				Field::inst( 'hrrertd.nama' ),
				Field::inst( 'hrrertd.keterangan' ),
				Field::inst( 'hrrertd.created_by' ),
				Field::inst( 'hrrertd.transaction_state' ),
				Field::inst( 'hrrertd.approval_state' ),
				Field::inst( 'hrrertd.start_at' ),
				Field::inst( 'hrrertd.finish_at' ),
				Field::inst( 'hrrertd.is_nextprocess' ),
				Field::inst( 'hrrertd.is_defaultprogram' ),
				Field::inst( 'hemxxmh.nama' ),
				Field::inst( 'hemxxmh.kode' ),
			)
			->where('hrrertd.id_hrremth',$_POST['id_hrremth'])
			->leftJoin( 'hemxxmh','hemxxmh.id','=','hrrertd.id_hemxxmh' )
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hrrertd'] == 0){
			$editor
				->where( 'hrrertd.transaction_state', -9, '<>');
		}
		
		include( "hrrertd_extra.php" );

		// BEGIN log
		$nama_table = 'hrrertd';
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