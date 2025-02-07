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
	
	if ( ! isset($_POST['id_fprxxth']) || ! is_numeric($_POST['id_fprxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'fprivtd' )
			->debug(true)
			->fields(
				Field::inst( 'fprivtd.id' ),
				Field::inst( 'fprivtd.id_fprxxth' ),
				Field::inst( 'fprivtd.id_pivxxth' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'fprivtd.kode' ),
				Field::inst( 'fprivtd.nama' ),
				Field::inst( 'fprivtd.keterangan' ),
				Field::inst( 'fprivtd.created_by' ),
				Field::inst( 'fprivtd.transaction_state' ),
				Field::inst( 'fprivtd.approval_state' ),
				Field::inst( 'fprivtd.start_at' ),
				Field::inst( 'fprivtd.finish_at' ),
				Field::inst( 'fprivtd.is_nextprocess' ),
				Field::inst( 'fprivtd.is_defaultprogram' ),
				Field::inst( 'fprivtd.ammount' ),
				Field::inst( 'fprivtd.rencana_bayar' ),
				Field::inst( 'fprivtd.sisa' ),
				Field::inst( 'fprivtd.tanggal' )
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
				Field::inst( 'fprivtd.tanggal_jatuh_tempo' )
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
				Field::inst( 'pivxxth.kode' )
			)
			->where('fprivtd.id_fprxxth',$_POST['id_fprxxth'])
			->leftJoin( 'pivxxth','pivxxth.id','=','fprivtd.id_pivxxth' )
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_fprivtd'] == 0){
			$editor
				->where( 'fprivtd.transaction_state', -9, '<>');
		}
		
		include( "fprivtd_extra.php" );

		// BEGIN log
		$nama_table = 'fprivtd';
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