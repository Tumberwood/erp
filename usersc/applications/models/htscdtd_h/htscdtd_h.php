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
	
	$editor = Editor::inst( $db, 'htscdtd_h' )
		->debug(true)
		->fields(
			Field::inst( 'htscdtd_h.id' ),
			Field::inst( 'htscdtd_h.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'htscdtd_h.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'htscdtd_h.keterangan' ),
			Field::inst( 'htscdtd_h.created_by' ),
			Field::inst( 'htscdtd_h.transaction_state' ),
			Field::inst( 'htscdtd_h.approval_state' ),
			Field::inst( 'htscdtd_h.start_at' ),
			Field::inst( 'htscdtd_h.finish_at' ),
			Field::inst( 'htscdtd_h.is_defaultprogram' ),
			Field::inst( 'htscdtd_h.is_nextprocess' ),
			Field::inst( 'htscdtd_h.tanggal_terpilih' )
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
			Field::inst( 'htscdtd_h.tanggal_pengganti' )
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
				) )
		)
		->join(
			Mjoin::inst( 'hodxxmh' )
				->link( 'htscdtd_h.id', 'hodxxmh_htscdtd_h.id_htscdtd_h' )
				->link( 'hodxxmh.id', 'hodxxmh_task_report.id_hodxxmh' )
				->order( 'hodxxmh.nama asc' )
				->fields(
					Field::inst( 'id' )
                    	->validator( 'Validate::required' )
						->options( Options::inst()
							->table( 'hodxxmh' )
							->value( 'id' )
							->label( 'nama' )
						),
					Field::inst( 'id' ),
					Field::inst( 'nama' )
				)
		);
	
	if($_POST['start_date'] != ''){
		$editor->where( 'htscdtd_h.tanggal_terpilih',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'htscdtd_h.tanggal_terpilih', $_POST['end_date'], '<=' );
	}
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_htscdtd_h'] == 0){
		$editor
			->where( 'htscdtd_h.transaction_state', -9, '<>');
	}
	
	include( "htscdtd_h_extra.php" );

	// BEGIN log
	$nama_table = 'htscdtd_h';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>