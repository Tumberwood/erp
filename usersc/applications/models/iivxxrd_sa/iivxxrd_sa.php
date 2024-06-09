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
	
	$editor = Editor::inst( $db, 'iivxxrd_sa' )
		->debug(true)
		->fields(
			Field::inst( 'iivxxrd_sa.id' ),
			Field::inst( 'iivxxrd_sa.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'iivxxrd_sa.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'iivxxrd_sa.keterangan' ),
			Field::inst( 'iivxxrd_sa.created_by' ),
			Field::inst( 'iivxxrd_sa.transaction_state' ),
			Field::inst( 'iivxxrd_sa.approval_state' ),
			Field::inst( 'iivxxrd_sa.upload_state' ),
			Field::inst( 'iivxxrd_sa.start_at' ),
			Field::inst( 'iivxxrd_sa.finish_at' ),
			Field::inst( 'iivxxrd_sa.is_defaultprogram' ),

			Field::inst( 'iivxxrd_sa.gbrxxmh_nama' ),
			Field::inst( 'iivxxrd_sa.iwhxxmh_nama' ),
			Field::inst( 'iivxxrd_sa.wloxxmh_nama' ),
			Field::inst( 'iivxxrd_sa.tanggal' )
				->getFormatter( function ( $val, $data, $opts ) {
					if ($val === '0000-00-00' || $val === null){
						return '';
					}else{
						return date( 'd M Y', strtotime( $val ) );
					}
				} )
				->setFormatter( 'Format::datetime', array(
					'from' => 'd M Y',
					'to' =>   'Y-m-d'
				) ),
			Field::inst( 'iivxxrd_sa.iimxxmh_kode' ),
			Field::inst( 'iivxxrd_sa.iimxxmh_nama' ),
			Field::inst( 'iivxxrd_sa.jumlah_terkecil' ),
			Field::inst( 'iivxxrd_sa.iumxxmh_kode_terkecil' ),
			Field::inst( 'iivxxrd_sa.lpn' ),
			Field::inst( 'iivxxrd_sa.expired_date' )
				->getFormatter( function ( $val, $data, $opts ) {
					if ($val === '0000-00-00' || $val === null){
						return '';
					}else{
						return date( 'd M Y', strtotime( $val ) );
					}
				} )
				->setFormatter( 'Format::datetime', array(
					'from' => 'd M Y',
					'to' =>   'Y-m-d'
				) ),
			Field::inst( 'iivxxrd_sa.batch_number' )
		)
		->where( 'iivxxrd_sa.tanggal', $_POST['start_date'], '>=' )
		->where( 'iivxxrd_sa.tanggal', $_POST['end_date'], '<=' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_iivxxrd_sa'] == 0){
		$editor
			->where( 'iivxxrd_sa.transaction_state', -9, '<>');
	}
	
	include( "iivxxrd_sa_extra.php" );

	// BEGIN log
	$nama_table = 'iivxxrd_sa';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>