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
	
	if ( ! isset($_POST['id_hrctsth']) || ! is_numeric($_POST['id_hrctsth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'hrctstd' )
			->debug(true)
			->fields(
				Field::inst( 'hrctstd.id' ),
				Field::inst( 'hrctstd.id_hrctsth' ),
				Field::inst( 'hrctstd.id_hcdxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hrctstd.id_hrctsmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hrctstd.id_hrcemtd' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hrctstd.kode' ),
				Field::inst( 'hrctstd.nama' ),
				Field::inst( 'hrctstd.keterangan' ),
				Field::inst( 'hrctstd.created_by' ),
				Field::inst( 'hrctstd.transaction_state' ),
				Field::inst( 'hrctstd.approval_state' ),
				Field::inst( 'hrctstd.start_at' ),
				Field::inst( 'hrctstd.finish_at' ),
				Field::inst( 'hrctstd.is_nextprocess' ),
				Field::inst( 'hrctstd.is_defaultprogram' ),

				Field::inst( 'hcdxxmh.nama' ),
				Field::inst( 'hrctsmh.nama' ),
			)
			->leftJoin( 'hcdxxmh','hcdxxmh.id','=','hrctstd.id_hcdxxmh' )
			->leftJoin( 'hrctsmh','hrctsmh.id','=','hrctstd.id_hrctsmh' )
			->where('hrctstd.id_hrctsth',$_POST['id_hrctsth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hrctstd'] == 0){
			$editor
				->where( 'hrctstd.transaction_state', -9, '<>');
		}
		
		include( "hrctstd_extra.php" );

		// BEGIN log
		$nama_table = 'hrctstd';
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