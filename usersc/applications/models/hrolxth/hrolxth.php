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
	
	$editor = Editor::inst( $db, 'hrolxth' )
		->debug(true)
		->fields(
			Field::inst( 'hrolxth.id' ),
			Field::inst( 'hrolxth.id_hcdxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hrolxth.id_hetxxmh_dilamar' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hrolxth.id_hetxxmh_ditawarkan' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hrolxth.id_heyxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hrolxth.id_hevxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hrolxth.id_hovxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hrolxth.id_hodxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hrolxth.id_hosxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hrolxth.id_holxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hrolxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hrolxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hrolxth.keterangan' ),
			Field::inst( 'hrolxth.created_by' ),
			Field::inst( 'hrolxth.transaction_state' ),
			Field::inst( 'hrolxth.approval_state' ),
			Field::inst( 'hrolxth.start_at' ),
			Field::inst( 'hrolxth.finish_at' ),
			Field::inst( 'hrolxth.is_nextprocess' ),
			Field::inst( 'hrolxth.is_defaultprogram' ),
			Field::inst( 'hrolxth.tanggal' )
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
			Field::inst( 'hcdxxmh.nama' ),
			Field::inst( 'dilamar.nama' ),
			Field::inst( 'ditawarkan.nama' ),
		)
		->leftJoin( 'hcdxxmh','hcdxxmh.id','=','hrolxth.id_hcdxxmh' )
		->leftJoin( 'hetxxmh dilamar','dilamar.id','=','hrolxth.id_hetxxmh_dilamar' )
		->leftJoin( 'hetxxmh ditawarkan','ditawarkan.id','=','hrolxth.id_hetxxmh_ditawarkan' )
		;
	
	if($_POST['start_date'] != ''){
		$editor->where( 'hrolxth.tanggal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'hrolxth.tanggal', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hrolxth'] == 0){
		$editor
			->where( 'hrolxth.transaction_state', -9, '<>');
	}
	
	include( "hrolxth_extra.php" );

	// BEGIN log
	$nama_table = 'hrolxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>