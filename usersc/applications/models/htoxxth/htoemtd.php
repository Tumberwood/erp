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
	
	if ( ! isset($_POST['id_htoxxth']) || ! is_numeric($_POST['id_htoxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'htoemtd' )
			->debug(true)
			->fields(
				Field::inst( 'htoemtd.id' ),
				Field::inst( 'htoemtd.id_htoxxth' ),
				Field::inst( 'htoemtd.id_hemxxmh' ),
				Field::inst( 'htoemtd.id_htotpmh' ),
				Field::inst( 'htoemtd.kode' ),
				Field::inst( 'htoemtd.nama' ),
				Field::inst( 'htoemtd.keterangan' ),
				Field::inst( 'htoemtd.created_by' ),
				Field::inst( 'htoemtd.transaction_state' ),
				Field::inst( 'htoemtd.approval_state' ),
				Field::inst( 'htoemtd.start_at' ),
				Field::inst( 'htoemtd.finish_at' ),
				Field::inst( 'htoemtd.is_nextprocess' ),
				Field::inst( 'htoemtd.is_defaultprogram' ),
				Field::inst( 'htoemtd.jam_awal' )
					->getFormatter( function ( $val, $data, $opts ) {
						if ($val === null){
							echo '';
						}else{
							return date( 'H:i', strtotime( $val ) );
						}
					} )
					->setFormatter( 'Format::datetime', array(
						'from' => 'H:i',
						'to' =>   'H:i:s'
					) ),
				Field::inst( 'htoemtd.jam_akhir' )
					->getFormatter( function ( $val, $data, $opts ) {
						if ($val === null){
							echo '';
						}else{
							return date( 'H:i', strtotime( $val ) );
						}
					} )
					->setFormatter( 'Format::datetime', array(
						'from' => 'H:i',
						'to' =>   'H:i:s'
					) ),
				Field::inst( 'htoemtd.durasi_lembur_jam' ),
				Field::inst( 'htoemtd.durasi_lembur_menit' ),
				Field::inst( 'htoemtd.jam_awal_istirahat' )
					->getFormatter( function ( $val, $data, $opts ) {
						if ($val === null){
							echo '';
						}else{
							return date( 'H:i', strtotime( $val ) );
						}
					} )
					->setFormatter( 'Format::datetime', array(
						'from' => 'H:i',
						'to' =>   'H:i:s'
					) ),
				Field::inst( 'htoemtd.jam_akhir_istirahat' )
					->getFormatter( function ( $val, $data, $opts ) {
						if ($val === null){
							echo '';
						}else{
							return date( 'H:i', strtotime( $val ) );
						}
					} )
					->setFormatter( 'Format::datetime', array(
						'from' => 'H:i',
						'to' =>   'H:i:s'
					) ),
				Field::inst( 'htoemtd.durasi_istirahat_menit' ),
				Field::inst( 'htoemtd.is_istirahat' ),
				Field::inst( 'htoemtd.is_valid_checkclock' ),
				
				Field::inst( 'htotpmh.nama' ),
				Field::inst( 'concat(hemxxmh.kode," - ",hemxxmh.nama) as hemxxmh_data' )
			)
			->leftJoin( 'htotpmh','htotpmh.id','=','htoemtd.id_htotpmh' )
			->leftJoin( 'hemxxmh','hemxxmh.id','=','htoemtd.id_hemxxmh' )
			->where('htoemtd.id_htoxxth',$_POST['id_htoxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_htoemtd'] == 0){
			$editor
				->where( 'htoemtd.transaction_state', -9, '<>');
		}
		
		include( "htoemtd_extra.php" );

		// BEGIN log
		$nama_table = 'htoemtd';
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