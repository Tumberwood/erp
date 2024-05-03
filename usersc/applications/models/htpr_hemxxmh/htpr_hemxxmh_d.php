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
	
	if ( ! isset($_POST['id_hemxxmh']) || ! is_numeric($_POST['id_hemxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'htpr_hemxxmh' )
			->debug(true)
			->fields(
				Field::inst( 'htpr_hemxxmh.id' ),
				Field::inst( 'htpr_hemxxmh.id_hemxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'htpr_hemxxmh.id_hpcxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'htpr_hemxxmh.kode' ),
				Field::inst( 'htpr_hemxxmh.nama' ),
				Field::inst( 'htpr_hemxxmh.keterangan' ),
				Field::inst( 'htpr_hemxxmh.created_by' ),
				Field::inst( 'htpr_hemxxmh.transaction_state' ),
				Field::inst( 'htpr_hemxxmh.approval_state' ),
				Field::inst( 'htpr_hemxxmh.start_at' ),
				Field::inst( 'htpr_hemxxmh.finish_at' ),
				Field::inst( 'htpr_hemxxmh.is_defaultprogram' ),
				Field::inst( 'htpr_hemxxmh.is_nextprocess' ),
				Field::inst( 'htpr_hemxxmh.tanggal_efektif' )
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
				Field::inst( 'htpr_hemxxmh.nominal' ),
				Field::inst( 'hpcxxmh.nama' )
		   )
		   ->leftJoin( 'hpcxxmh','hpcxxmh.id','=','htpr_hemxxmh.id_hpcxxmh' )
			->where('htpr_hemxxmh.id_hemxxmh',$_POST['id_hemxxmh'])
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_htpr_hemxxmh'] == 0){
			$editor
				->where( 'htpr_hemxxmh.transaction_state', -9, '<>');
		}
		
		include( "htpr_hemxxmh_d_extra.php" );

		// BEGIN log
		$nama_table = 'htpr_hemxxmh';
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