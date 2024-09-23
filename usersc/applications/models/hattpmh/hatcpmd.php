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
	
	if ( ! isset($_POST['id_hattpmh']) || ! is_numeric($_POST['id_hattpmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'hatcpmd' )
			->debug(true)
			->fields(
				Field::inst( 'hatcpmd.id' ),
				Field::inst( 'hatcpmd.id_hattpmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hatcpmd.id_hpcxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hatcpmd.kode' ),
				Field::inst( 'hatcpmd.nama' ),
				Field::inst( 'hatcpmd.keterangan' ),
				Field::inst( 'hatcpmd.created_by' ),
				Field::inst( 'hatcpmd.transaction_state' ),
				Field::inst( 'hatcpmd.approval_state' ),
				Field::inst( 'hatcpmd.start_at' ),
				Field::inst( 'hatcpmd.finish_at' ),
				Field::inst( 'hatcpmd.is_defaultprogram' ),

				Field::inst( 'hpcxxmh.nama' )
			)
			->leftJoin( 'hpcxxmh','hpcxxmh.id','=','hatcpmd.id_hpcxxmh' )
			->where('hatcpmd.id_hattpmh',$_POST['id_hattpmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hatcpmd'] == 0){
			$editor
				->where( 'hatcpmd.transaction_state', -9, '<>');
		}
		
		include( "hatcpmd_extra.php" );

		// BEGIN log
		$nama_table = 'hatcpmd';
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