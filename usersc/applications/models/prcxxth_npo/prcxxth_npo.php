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
	
	$editor = Editor::inst( $db, 'prcxxth_npo' )
		->debug(true)
		->fields(
			Field::inst( 'prcxxth_npo.id' ),
			Field::inst( 'prcxxth_npo.id_gcpxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gcpxxmh),
			Field::inst( 'prcxxth_npo.id_gbrxxmh' )
				->set( Field::SET_CREATE )
				->setValue($s_id_gbrxxmh),
			Field::inst( 'prcxxth_npo.id_iitxxmh' ),
			Field::inst( 'prcxxth_npo.id_iwhxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'prcxxth_npo.id_imtxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'prcxxth_npo.id_grlxxmh_supplier' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'prcxxth_npo.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'prcxxth_npo.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'prcxxth_npo.keterangan' ),
			Field::inst( 'prcxxth_npo.created_by' ),
			Field::inst( 'prcxxth_npo.transaction_state' ),
			Field::inst( 'prcxxth_npo.approval_state' ),
			Field::inst( 'prcxxth_npo.start_at' ),
			Field::inst( 'prcxxth_npo.finish_at' ),
			Field::inst( 'prcxxth_npo.is_nextprocess' ),
			Field::inst( 'prcxxth_npo.is_defaultprogram' ),

			Field::inst( 'prcxxth_npo.tanggal' )
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
			Field::inst( 'prcxxth_npo.referensi_nomor' ),
			Field::inst( 'prcxxth_npo.mobil_nomor' ),
			Field::inst( 'prcxxth_npo.supir_nama' ),
			Field::inst( 'prcxxth_npo.referensi' ),
			Field::inst( 'prcxxth_npo.plat_nomor' ),

			Field::inst( 'iwhxxmh.nama' ),
			Field::inst( 'imtxxmh.nama' ),
			Field::inst( 'grlxxmh.nama' ),

		)
		->leftJoin( 'iwhxxmh','iwhxxmh.id','=','prcxxth_npo.id_iwhxxmh' )
		->leftJoin( 'imtxxmh','imtxxmh.id','=','prcxxth_npo.id_imtxxmh' )
		->leftJoin( 'grlxxmh','grlxxmh.id','=','prcxxth_npo.id_grlxxmh_supplier' )
		->where( 'prcxxth_npo.tanggal', $_POST['start_date'], '>=' )
		->where( 'prcxxth_npo.tanggal', $_POST['end_date'], '<=' )
		;
	
		// BEGIN where single data view
	// if (isset($_POST['rowid']) && $_POST['rowid'] > 0) {
	// 	$rowid = $_POST['rowid'];
	// 	$editor
	// 		->where( 'prcxxth_npo.id', $rowid);
	// }else{
	// 	$editor
	// 		->where( 'prcxxth_npo.tanggal', $_POST['start_date'], '>=' )
	// 		->where( 'prcxxth_npo.tanggal', $_POST['end_date'], '<=' );
	// }
	// END where single data view

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_prcxxth_npo'] == 0){
		$editor
			->where( 'prcxxth_npo.transaction_state', -9, '<>');
	}
	
	include( "prcxxth_npo_extra.php" );

	// BEGIN log
	$nama_table = 'prcxxth_npo';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>