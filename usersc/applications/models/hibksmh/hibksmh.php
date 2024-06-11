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
	
	$editor = Editor::inst( $db, 'hibksmh' )
		->debug(true)
		->fields(
			Field::inst( 'hibksmh.id' ),
			Field::inst( 'hibksmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hibksmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hibksmh.keterangan' ),
			Field::inst( 'hibksmh.created_by' ),
			Field::inst( 'hibksmh.transaction_state' ),
			Field::inst( 'hibksmh.approval_state' ),
			Field::inst( 'hibksmh.start_at' ),
			Field::inst( 'hibksmh.finish_at' ),
			Field::inst( 'hibksmh.is_defaultprogram' ),
			Field::inst( 'hibksmh.is_nextprocess' ),
			Field::inst( 'hibksmh.tanggal_efektif' )
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
			Field::inst( 'hibksmh.is_defaultprogram' ),
			Field::inst( 'hibksmh.persen_perusahaan' ),
			Field::inst( 'hibksmh.persen_karyawan' ),
			Field::inst( 'hibksmh.gaji_max' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hibksmh'] == 0){
		$editor
			->where( 'hibksmh.transaction_state', -9, '<>');
	}
	
	include( "hibksmh_extra.php" );

	// BEGIN log
	$nama_table = 'hibksmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>