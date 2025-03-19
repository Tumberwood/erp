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
	
	$editor = Editor::inst( $db, 'kisemtd' )
		->debug(true)
		->fields(
			Field::inst( 'kisemtd.id' ),
			Field::inst( 'kisemtd.id_kisctmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'kisemtd.id_hemxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'kisemtd.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'kisemtd.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'kisemtd.keterangan' ),
			Field::inst( 'kisemtd.created_by' ),
			Field::inst( 'kisemtd.transaction_state' ),
			Field::inst( 'kisemtd.approval_state' ),
			Field::inst( 'kisemtd.start_at' ),
			Field::inst( 'kisemtd.finish_at' ),
			Field::inst( 'kisemtd.is_defaultprogram' ),
			Field::inst( 'kisemtd.is_nextprocess' ),
			Field::inst( 'kisemtd.pihak_terlibat' ),
			Field::inst( 'kisemtd.deskripsi_insiden' ),
			Field::inst( 'kisemtd.penyebab' ),
			Field::inst( 'kisemtd.tindakan' ),
			
			Field::inst( 'kisemtd.tanggal' )
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
			Field::inst( 'kisctmh.nama' ),
			Field::inst( 'CONCAT(hemxxmh.fname," ",hemxxmh.lname) as hemxxmh_fullname' ),
		)
		->leftJoin( 'hemxxmh','hemxxmh.id','=','kisemtd.id_hemxxmh' )
		->leftJoin( 'kisctmh','kisctmh.id','=','kisemtd.id_kisctmh' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_kisemtd'] == 0){
		$editor
			->where( 'kisemtd.transaction_state', -9, '<>');
	}
	
	include( "kisemtd_extra.php" );

	// BEGIN log
	$nama_table = 'kisemtd';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>