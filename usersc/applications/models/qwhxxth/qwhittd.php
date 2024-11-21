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
	
	if ( ! isset($_POST['id_qwhxxth']) || ! is_numeric($_POST['id_qwhxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'qwhittd' )
			->debug(true)
			->fields(
				Field::inst( 'qwhittd.id' ),
				Field::inst( 'qwhittd.id_qwhxxth' ),
				Field::inst( 'qwhittd.kode' ),
				Field::inst( 'qwhittd.nama' ),
				Field::inst( 'qwhittd.keterangan' ),
				Field::inst( 'qwhittd.created_by' ),
				Field::inst( 'qwhittd.transaction_state' ),
				Field::inst( 'qwhittd.approval_state' ),
				Field::inst( 'qwhittd.start_at' ),
				Field::inst( 'qwhittd.finish_at' ),
				Field::inst( 'qwhittd.is_nextprocess' ),
				Field::inst( 'qwhittd.is_defaultprogram' ),
				Field::inst( 'qwhittd.iwhxxmh_nama' ),
				Field::inst( 'qwhittd.wloxxmh_nama' ),
				Field::inst( 'qwhittd.wlpxxmh_kode' ),
				Field::inst( 'qwhittd.iimxxmh_kode' ),
				Field::inst( 'qwhittd.iimxxmh_nama' ),
				Field::inst( 'qwhittd.batch_number' ),
				Field::inst( 'qwhittd.iimxxmh_status' ),
				Field::inst( 'qwhittd.iimxxmh_status_old' ),
				Field::inst( 'qwhittd.alasan_perubahan_status' ),
				Field::inst( 'qwhittd.jumlah_default' ),
				Field::inst( 'qwhittd.iumxxmh_default_kode' ),
				Field::inst( 'qwhittd.jumlah_terkecil' ),
				Field::inst( 'qwhittd.iumxxmh_terkecil_kode' ),
				Field::inst( 'qwhittd.expired_date' )
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
				Field::inst( 'qwhittd.is_defaultprogram' ),
			)
			->where('qwhittd.id_qwhxxth',$_POST['id_qwhxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_qwhittd'] == 0){
			$editor
				->where( 'qwhittd.transaction_state', -9, '<>');
		}
		
		include( "qwhittd_extra.php" );

		// BEGIN log
		$nama_table = 'qwhittd';
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