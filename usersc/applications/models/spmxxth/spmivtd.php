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
	
	if ( ! isset($_POST['id_spmxxth']) || ! is_numeric($_POST['id_spmxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'spmivtd' )
			->debug(true)
			->fields(
				Field::inst( 'spmivtd.id' ),
				Field::inst( 'spmivtd.id_spmxxth' ),
				Field::inst( 'spmivtd.id_sivxxth' )
				->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'spmivtd.id_sprivtd' )
				->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'spmivtd.kode' ),
				Field::inst( 'spmivtd.nama' ),
				Field::inst( 'spmivtd.keterangan' ),
				Field::inst( 'spmivtd.created_by' ),
				Field::inst( 'spmivtd.transaction_state' ),
				Field::inst( 'spmivtd.approval_state' ),
				Field::inst( 'spmivtd.start_at' ),
				Field::inst( 'spmivtd.finish_at' ),
				Field::inst( 'spmivtd.is_nextprocess' ),
				Field::inst( 'spmivtd.is_defaultprogram' ),
				Field::inst( 'spmivtd.amount' ),
				Field::inst( 'spmivtd.rencana_bayar' ),
				Field::inst( 'spmivtd.sisa' ),
				Field::inst( 'spmivtd.tanggal' )
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
				Field::inst( 'spmivtd.tanggal_jatuh_tempo' )
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
				Field::inst( 'sivxxth.kode' )
			)
			->leftJoin( 'sivxxth','sivxxth.id','=','spmivtd.id_sivxxth' )
			->where('spmivtd.id_spmxxth',$_POST['id_spmxxth'])
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_spmivtd'] == 0){
			$editor
				->where( 'spmivtd.transaction_state', -9, '<>');
		}
		
		include( "spmivtd_extra.php" );

		// BEGIN log
		$nama_table = 'spmivtd';
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