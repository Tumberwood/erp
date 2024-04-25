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
	
	$editor = Editor::inst( $db, 'hibtkmh' )
		->debug(true)
		->fields(
			Field::inst( 'hibtkmh.id' ),
			Field::inst( 'hibtkmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hibtkmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hibtkmh.keterangan' ),
			Field::inst( 'hibtkmh.created_by' ),
			Field::inst( 'hibtkmh.transaction_state' ),
			Field::inst( 'hibtkmh.approval_state' ),
			Field::inst( 'hibtkmh.start_at' ),
			Field::inst( 'hibtkmh.finish_at' ),
			Field::inst( 'hibtkmh.is_defaultprogram' ),
			Field::inst( 'hibtkmh.is_nextprocess' ),
			Field::inst( 'hibtkmh.tanggal_efektif' )
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
			Field::inst( 'hibtkmh.persen_jht_perusahaan' ),
			Field::inst( 'hibtkmh.persen_jht_karyawan' ),
			Field::inst( 'hibtkmh.persen_jkk' ),
			Field::inst( 'hibtkmh.persen_jkm' ),
			Field::inst( 'hibtkmh.persen_jp_perusahaan' ),
			Field::inst( 'hibtkmh.persen_jp_karyawan' ),
			Field::inst( 'hibtkmh.gaji_max' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hibtkmh'] == 0){
		$editor
			->where( 'hibtkmh.transaction_state', -9, '<>');
	}
	
	include( "hibtkmh_extra.php" );

	// BEGIN log
	$nama_table = 'hibtkmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>