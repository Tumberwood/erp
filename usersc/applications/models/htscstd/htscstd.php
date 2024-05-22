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
	
	
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	
	$editor = Editor::inst( $db, 'htscstd' )
		->debug(true)
		->fields(
			Field::inst( 'htscstd.id' ),
			Field::inst( 'htscstd.id_hemxxmh_pengaju' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'htscstd.id_hemxxmh_pengganti' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'htscstd.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'htscstd.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'htscstd.keterangan' ),
			Field::inst( 'htscstd.created_by' ),
			Field::inst( 'htscstd.transaction_state' ),
			Field::inst( 'htscstd.approval_state' ),
			Field::inst( 'htscstd.start_at' ),
			Field::inst( 'htscstd.finish_at' ),
			Field::inst( 'htscstd.is_defaultprogram' ),
			Field::inst( 'htscstd.is_nextprocess' ),
			Field::inst( 'htscstd.jenis' ),
			
			Field::inst( 'htscstd.tanggal' )
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
			Field::inst( 'htscstd.jam_awal_pengaju' )
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
			Field::inst( 'htscstd.jam_akhir_pengaju' )
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
			Field::inst( 'htscstd.jam_awal_pengganti' )
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
			Field::inst( 'htscstd.jam_akhir_pengganti' )
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
				Field::inst( 'htscstd.jam_awal_istirahat_pengaju' )
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
				Field::inst( 'htscstd.jam_awal_istirahat_pengganti' )
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
				Field::inst( 'concat(hemxxmh_pengaju.kode, " - ",hemxxmh_pengaju.nama) as hemxxmh_pengaju' ),
				Field::inst( 'concat(hemxxmh_pengganti.kode, " - ",hemxxmh_pengganti.nama) as hemxxmh_pengganti' )
		)
		->leftJoin( 'hemxxmh as hemxxmh_pengaju','hemxxmh_pengaju.id','=','htscstd.id_hemxxmh_pengaju' )
		->leftJoin( 'hemjbmh as hemjbmh_pengaju','hemjbmh_pengaju.id_hemxxmh','=','hemxxmh_pengaju.id' )
		
		->leftJoin( 'hemxxmh as hemxxmh_pengganti','hemxxmh_pengganti.id','=','htscstd.id_hemxxmh_pengganti' )
		->leftJoin( 'hemjbmh as hemjbmh_pengganti','hemjbmh_pengganti.id_hemxxmh','=','hemxxmh_pengganti.id' )
		// ->where( 'htscstd.tanggal', $_POST['start_date'], '>=')
		// ->where( 'htscstd.tanggal', $_POST['end_date'], '<=')
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_htscstd'] == 0){
		$editor
			->where( 'htscstd.transaction_state', -9, '<>');
	}
	
	include( "htscstd_extra.php" );

	// BEGIN log
	$nama_table = 'htscstd';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>