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
	
	$editor = Editor::inst( $db, 'hrremth' )
		->debug(true)
		->fields(
			Field::inst( 'hrremth.id' ),
			Field::inst( 'hrremth.id_heyxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hrremth.id_hetxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hrremth.id_hevxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hrremth.id_hovxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hrremth.id_hodxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hrremth.id_hosxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hrremth.id_hgnedmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hrremth.id_hemxxmh_pengaju' )
				->set( Field::SET_CREATE )
				->setValue($s_id_hemxxmh),
			Field::inst( 'hrremth.id_hgnlgmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hrremth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hrremth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hrremth.keterangan' ),
			Field::inst( 'hrremth.created_by' ),
			Field::inst( 'hrremth.transaction_state' ),
			Field::inst( 'hrremth.approval_state' ),
			Field::inst( 'hrremth.start_at' ),
			Field::inst( 'hrremth.finish_at' ),
			Field::inst( 'hrremth.is_nextprocess' ),
			Field::inst( 'hrremth.is_defaultprogram' ),
			Field::inst( 'hrremth.addition' ),
			Field::inst( 'hrremth.replacement' ),
			Field::inst( 'hrremth.jumlah' ),
			Field::inst( 'hrremth.tugas_umum' ),
			Field::inst( 'hrremth.jenis_kelamin' ),
			Field::inst( 'hrremth.is_batasan_usia' ),
			Field::inst( 'hrremth.usia_min' ),
			Field::inst( 'hrremth.usia_max' ),
			Field::inst( 'hrremth.pengalaman' ),
			Field::inst( 'hrremth.tahun_pengalaman' ),
			Field::inst( 'hrremth.jurusan' ),
			Field::inst( 'hrremth.kemampuan_wajib' ),
			Field::inst( 'hrremth.kemampuan_tambahan' ),
			Field::inst( 'hrremth.tanggal' )
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
			Field::inst( 'hrremth.tanggal_dibutuhkan' )
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
		)
		->join(
			Mjoin::inst( 'hgnlgmh' )
				->link( 'hrremth.id', 'hrremth_hgnlgmh.id_hrremth' )
				->link( 'hgnlgmh.id', 'hrremth_hgnlgmh.id_hgnlgmh' )
				->fields(
					Field::inst( 'id' )
						->setFormatter( Format::ifEmpty( 0 ) )
						->options( Options::inst()
							->table( 'hgnlgmh' )
							->value( 'id' )
							->label( ['nama'] )
							->render( function ( $row ) {
								return $row['nama'];
							} )
							->order( 'nama' )
						),
					Field::inst( 'nama' )
				)
		)
		;
	
	if($_POST['start_date'] != ''){
		$editor->where( 'hrremth.tanggal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'hrremth.tanggal', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hrremth'] == 0){
		$editor
			->where( 'hrremth.transaction_state', -9, '<>');
	}
	
	include( "hrremth_extra.php" );

	// BEGIN log
	$nama_table = 'hrremth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>