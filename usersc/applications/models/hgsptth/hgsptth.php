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
	
	$editor = Editor::inst( $db, 'hgsptth' )
		->debug(true)
		->fields(
			Field::inst( 'hgsptth.id' ),
			Field::inst( 'hgsptth.id_htsptth' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hgsptth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hgsptth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hgsptth.keterangan' ),
			Field::inst( 'hgsptth.created_by' ),
			Field::inst( 'hgsptth.transaction_state' ),
			Field::inst( 'hgsptth.approval_state' ),
			Field::inst( 'hgsptth.start_at' ),
			Field::inst( 'hgsptth.finish_at' ),
			Field::inst( 'hgsptth.is_defaultprogram' ),
			Field::inst( 'hgsptth.is_nextprocess' ),
			Field::inst( 'hgsptth.tanggal_awal' )
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
			Field::inst( 'hgsptth.tanggal_akhir' )
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
			Field::inst( 'hgsptth.jumlah_siklus' ),
			Field::inst( 'htsptth.nama' ),
		)
		->leftJoin( 'htsptth','htsptth.id','=','hgsptth.id_htsptth' );
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hgsptth'] == 0){
		$editor
			->where( 'hgsptth.transaction_state', -9, '<>');
	}
	
	include( "hgsptth_extra.php" );

	// BEGIN log
	$nama_table = 'hgsptth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>