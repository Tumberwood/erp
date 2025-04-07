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
	
	if ( ! isset($_POST['id_udpxxsh']) || ! is_numeric($_POST['id_udpxxsh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'udpovsd' )
			->debug(true)
			->fields(
				Field::inst( 'udpovsd.id' ),
				Field::inst( 'udpovsd.id_udpxxsh' ),
				Field::inst( 'udpovsd.id_hovxxmh' ),
				Field::inst( 'udpovsd.kode' ),
				Field::inst( 'udpovsd.nama' ),
				Field::inst( 'udpovsd.keterangan' ),
				Field::inst( 'udpovsd.transaction_state' ),
				Field::inst( 'udpovsd.approval_state' ),
				Field::inst( 'udpovsd.start_at' ),
				Field::inst( 'udpovsd.finish_at' ),
				Field::inst( 'udpovsd.is_defaultprogram' ),

				Field::inst( 'hovxxmh.nama' )
			)
			->leftJoin( 'hovxxmh','hovxxmh.id','=','udpovsd.id_hovxxmh' )
			->where('udpovsd.id_udpxxsh',$_POST['id_udpxxsh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_udpovsd'] == 0){
			$editor
				->where( 'udpovsd.transaction_state', -9, '<>');
		}
		
		// include( "udpovsd_extra.php" );
		
		// BEGIN log
		$nama_table = 'udpovsd';
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