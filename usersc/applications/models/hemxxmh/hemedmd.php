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
	
	if ( ! isset($_POST['id_hemxxmh']) || ! is_numeric($_POST['id_hemxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'hemedmd' )
			->debug(true)
			->fields(
				Field::inst( 'hemedmd.id' ),
				Field::inst( 'hemedmd.id_hemxxmh' ),
				Field::inst( 'hemedmd.id_gctxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hemedmd.id_hgnedmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hemedmd.kode' ),
				Field::inst( 'hemedmd.nama' ),
				Field::inst( 'hemedmd.keterangan' ),
				Field::inst( 'hemedmd.created_by' ),
				Field::inst( 'hemedmd.transaction_state' ),
				Field::inst( 'hemedmd.approval_state' ),
				Field::inst( 'hemedmd.start_at' ),
				Field::inst( 'hemedmd.finish_at' ),
				Field::inst( 'hemedmd.is_defaultprogram' ),
				Field::inst( 'hemedmd.is_default' ),
				Field::inst( 'hemedmd.tahun_awal' )
					->getFormatter( function ( $val, $data, $opts ) {
						if ($val === '0000' || $val === null){
							echo '';
						}else{
							return date( 'Y', strtotime( $val ) );
						}
					} )
					->setFormatter( 'Format::datetime', array(
						'from' => 'Y',
						'to' =>   'Y'
					) ),
				Field::inst( 'hemedmd.tahun_akhir' )
					->getFormatter( function ( $val, $data, $opts ) {
						if ($val === '0000' || $val === null){
							echo '';
						}else{
							return date( 'Y', strtotime( $val ) );
						}
					} )
					->setFormatter( 'Format::datetime', array(
						'from' => 'Y',
						'to' =>   'Y'
					) ),
				Field::inst( 'hemedmd.jurusan' ),
				Field::inst( 'hemedmd.nilai_akhir' ),

				Field::inst( 'hgnedmh.nama' ),
				Field::inst( 'gctxxmh.nama' )
			)
			->leftJoin( 'hgnedmh','hgnedmh.id','=','hemedmd.id_hgnedmh' )
			->leftJoin( 'gctxxmh','gctxxmh.id','=','hemedmd.id_gctxxmh' )
			->where('hemedmd.id_hemxxmh',$_POST['id_hemxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hemedmd'] == 0){
			$editor
				->where( 'hemedmd.transaction_state', -9, '<>');
		}
		
		// include( "hemedmd_extra.php" );

		// BEGIN log
		$nama_table = 'hemedmd';
		include( "../../../helpers/edt_log.php" );
		// END log
		
		$json = $editor
			->process( $_POST )
			->data();

		// debugging hak akses
		$json['hakakses'] = $hakakses;

		echo json_encode( $json );

	}
?>