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
	
	$editor = Editor::inst( $db, 'prcxxth' )
		->debug(true)
		->fields(
			Field::inst( 'prcxxth.id' ),
			Field::inst( 'prcxxth.id_gbrxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'prcxxth.id_iwhxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'prcxxth.id_grlxxmh_supplier' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'prcxxth.id_podxxth' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'prcxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'prcxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'prcxxth.keterangan' ),
			Field::inst( 'prcxxth.created_by' ),
			Field::inst( 'prcxxth.transaction_state' ),
			Field::inst( 'prcxxth.approval_state' ),
			Field::inst( 'prcxxth.start_at' ),
			Field::inst( 'prcxxth.finish_at' ),
			Field::inst( 'prcxxth.is_defaultprogram' ),

			Field::inst( 'prcxxth.tanggal' )
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
			Field::inst( 'prcxxth.referensi_nomor' ),
			Field::inst( 'prcxxth.mobil_nomor' ),
			Field::inst( 'prcxxth.supir_nama' ),

			Field::inst( 'iwhxxmh.nama' ),
			Field::inst( 'grlxxmh.nama' )
		)
		->leftJoin( 'iwhxxmh','iwhxxmh.id','=','prcxxth.id_iwhxxmh' )
		->leftJoin( 'grlxxmh','grlxxmh.id','=','prcxxth.id_grlxxmh_supplier' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_prcxxth'] == 0){
		$editor
			->where( 'prcxxth.transaction_state', -9, '<>');
	}
	
	include( "prcxxth_extra.php" );

	// BEGIN log
	$nama_table = 'prcxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>