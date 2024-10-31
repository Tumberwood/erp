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
	
	if ( ! isset($_POST['id_hetxxmh']) || ! is_numeric($_POST['id_hetxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'htpr_hetxxmh' )
			->debug(true)
			->fields(
				Field::inst( 'htpr_hetxxmh.id' ),
				Field::inst( 'htpr_hetxxmh.id_hetxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'htpr_hetxxmh.id_hpcxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'htpr_hetxxmh.kode' ),
				Field::inst( 'htpr_hetxxmh.nama' ),
				Field::inst( 'htpr_hetxxmh.keterangan' ),
				Field::inst( 'htpr_hetxxmh.created_by' ),
				Field::inst( 'htpr_hetxxmh.transaction_state' ),
				Field::inst( 'htpr_hetxxmh.approval_state' ),
				Field::inst( 'htpr_hetxxmh.start_at' ),
				Field::inst( 'htpr_hetxxmh.finish_at' ),
				Field::inst( 'htpr_hetxxmh.is_defaultprogram' ),
				Field::inst( 'htpr_hetxxmh.is_nextprocess' ),
				Field::inst( 'htpr_hetxxmh.tanggal_efektif' )
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
				Field::inst( 'htpr_hetxxmh.nominal' ),
				Field::inst( 'hpcxxmh.nama' )
		   )
		   ->leftJoin( 'hpcxxmh','hpcxxmh.id','=','htpr_hetxxmh.id_hpcxxmh' )
			->where('htpr_hetxxmh.id_hetxxmh',$_POST['id_hetxxmh'])
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_htpr_hetxxmh'] == 0){
			$editor
				->where( 'htpr_hetxxmh.transaction_state', -9, '<>');
		}
		
		include( "htpr_hetxxmh_d_extra.php" );

		// BEGIN log
		$nama_table = 'htpr_hetxxmh';
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