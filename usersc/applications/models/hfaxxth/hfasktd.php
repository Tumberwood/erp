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
	
	if ( ! isset($_POST['id_hfskptd']) || ! is_numeric($_POST['id_hfskptd']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'hfasktd' )
			->debug(true)
			->fields(
				Field::inst( 'hfasktd.id' ),
				Field::inst( 'hfasktd.id_hfskptd' ),
				Field::inst( 'hfasktd.id_hfaxxth' ),
				Field::inst( 'hfasktd.id_hemxxmh_pic' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hfasktd.id_hemxxmh_verificator' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hfasktd.kode' ),
				Field::inst( 'hfasktd.nama' ),
				Field::inst( 'hfasktd.keterangan' ),
				Field::inst( 'hfasktd.created_by' ),
				Field::inst( 'hfasktd.transaction_state' ),
				Field::inst( 'hfasktd.approval_state' ),
				Field::inst( 'hfasktd.start_at' ),
				Field::inst( 'hfasktd.finish_at' ),
				Field::inst( 'hfasktd.is_nextprocess' ),
				Field::inst( 'hfasktd.is_defaultprogram' ),
				Field::inst( 'hfasktd.problem' ),
				Field::inst( 'hfasktd.corrective' ),
				Field::inst( 'hfasktd.preventive' ),
				Field::inst( 'hfasktd.status' ),
				Field::inst( 'hfasktd.tanggal' )
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

				Field::inst( 'verificator.nama' ),
				Field::inst( 'pic.nama' ),

			)
			->leftJoin( 'hemxxmh AS verificator','verificator.id','=','hfasktd.id_hemxxmh_verificator' )
			->leftJoin( 'hemxxmh AS pic','pic.id','=','hfasktd.id_hemxxmh_pic' )
			->where('hfasktd.id_hfaxxth',$_POST['id_hfaxxth'])
			->where('hfasktd.id_hfskptd',$_POST['id_hfskptd'])
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hfasktd'] == 0){
			$editor
				->where( 'hfasktd.transaction_state', -9, '<>');
		}
		
		include( "hfasktd_extra.php" );

		// BEGIN log
		$nama_table = 'hfasktd';
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