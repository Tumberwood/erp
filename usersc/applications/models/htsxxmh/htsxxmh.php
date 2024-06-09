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
	
	$editor = Editor::inst( $db, 'htsxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'htsxxmh.id' ),
			Field::inst( 'htsxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'htsxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'htsxxmh.keterangan' ),
			Field::inst( 'htsxxmh.created_by' ),
			Field::inst( 'htsxxmh.transaction_state' ),
			Field::inst( 'htsxxmh.approval_state' ),
			Field::inst( 'htsxxmh.start_at' ),
			Field::inst( 'htsxxmh.finish_at' ),
			Field::inst( 'htsxxmh.is_defaultprogram' ),
			Field::inst( 'htsxxmh.is_nextprocess' ),

			Field::inst( 'htsxxmh.jam_awal' )
				->getFormatter( function ( $val, $data, $opts ) {
					if ($val === null){
						return '';
					}else{
						return date( 'H:i', strtotime( $val ) );
					}
				} )
				->setFormatter( function ( $val ) {
					if ($val === ''){
						return null;
					}else{
						return date( 'H:i:s', strtotime( $val ) );
					}
				} ),
			Field::inst( 'htsxxmh.jam_akhir' )
				->getFormatter( function ( $val, $data, $opts ) {
					if ($val === null){
						return '';
					}else{
						return date( 'H:i', strtotime( $val ) );
					}
				} )
				->setFormatter( function ( $val ) {
					if ($val === ''){
						return null;
					}else{
						return date( 'H:i:s', strtotime( $val ) );
					}
				} ),
			Field::inst( 'htsxxmh.jam_awal_istirahat' )
				->getFormatter( function ( $val, $data, $opts ) {
					if ($val === null){
						return '';
					}else{
						return date( 'H:i', strtotime( $val ) );
					}
				} )
				->setFormatter( function ( $val ) {
					if ($val === ''){
						return null;
					}else{
						return date( 'H:i:s', strtotime( $val ) );
					}
				} ),
			Field::inst( 'htsxxmh.jam_akhir_istirahat' )
				->getFormatter( function ( $val, $data, $opts ) {
					if ($val === null){
						return '';
					}else{
						return date( 'H:i', strtotime( $val ) );
					}
				} )
				->setFormatter( function ( $val ) {
					if ($val === ''){
						return null;
					}else{
						return date( 'H:i:s', strtotime( $val ) );
					}
				} ),
			Field::inst( 'htsxxmh.menit_toleransi_awal_in' ),
			Field::inst( 'htsxxmh.menit_toleransi_akhir_in' ),
			Field::inst( 'htsxxmh.menit_toleransi_awal_out' ),
			Field::inst( 'htsxxmh.menit_toleransi_akhir_out' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_htsxxmh'] == 0){
		$editor
			->where( 'htsxxmh.transaction_state', -9, '<>');
	}
	
	include( "htsxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'htsxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>