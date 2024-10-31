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
	
	if ( ! isset($_POST['id_hevxxmh']) || ! is_numeric($_POST['id_hevxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'htpr_hevxxmh' )
			->debug(true)
			->fields(
				Field::inst( 'htpr_hevxxmh.id' ),
				Field::inst( 'htpr_hevxxmh.id_hevxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'htpr_hevxxmh.id_hpcxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'htpr_hevxxmh.kode' ),
				Field::inst( 'htpr_hevxxmh.nama' ),
				Field::inst( 'htpr_hevxxmh.keterangan' ),
				Field::inst( 'htpr_hevxxmh.created_by' ),
				Field::inst( 'htpr_hevxxmh.transaction_state' ),
				Field::inst( 'htpr_hevxxmh.approval_state' ),
				Field::inst( 'htpr_hevxxmh.start_at' ),
				Field::inst( 'htpr_hevxxmh.finish_at' ),
				Field::inst( 'htpr_hevxxmh.is_defaultprogram' ),
				Field::inst( 'htpr_hevxxmh.is_nextprocess' ),
				Field::inst( 'htpr_hevxxmh.tanggal_efektif' )
				   ->getFormatter( function ( $val, $data, $opts ) {
					   if ($val === '0000-00-00' || $val === null){
						   echo '';
					   }else{
						   return date( 'd M Y', strtotime( $val ) );
					   }
				   } )
				   ->setFormatter( 'Format::datetime', array(
					   'from' => 'd M Y',
					   'to' =>   'Y-m-d'
				   ) ),
				Field::inst( 'htpr_hevxxmh.nominal' ),
				Field::inst( 'hpcxxmh.nama' )
		   )
		   ->leftJoin( 'hpcxxmh','hpcxxmh.id','=','htpr_hevxxmh.id_hpcxxmh' )
			->where('htpr_hevxxmh.id_hevxxmh',$_POST['id_hevxxmh'])
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_htpr_hevxxmh'] == 0){
			$editor
				->where( 'htpr_hevxxmh.transaction_state', -9, '<>');
		}
		
		include( "htpr_hevxxmh_d_extra.php" );

		// BEGIN log
		$nama_table = 'htpr_hevxxmh';
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