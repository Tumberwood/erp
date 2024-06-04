<?php
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	// include_once( "../../../helpers/hakakses_s_fn.php" );
	
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
	
	if ( ! isset($_POST['id_hcdxxmh']) || ! is_numeric($_POST['id_hcdxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'hcdjbmd' )
			->debug(true)
			->fields(
				Field::inst( 'hcdjbmd.id' ),
				Field::inst( 'hcdjbmd.id_hcdxxmh' ),Field::inst( 'hcdjbmd.id_gctxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hcdjbmd.tanggal_awal' )
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
				Field::inst( 'hcdjbmd.tanggal_akhir' )
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
				Field::inst( 'hcdjbmd.kode' ),
				Field::inst( 'hcdjbmd.nama' ),
				Field::inst( 'hcdjbmd.keterangan' ),
				Field::inst( 'hcdjbmd.created_by' ),
				Field::inst( 'hcdjbmd.transaction_state' ),
				Field::inst( 'hcdjbmd.approval_state' ),
				Field::inst( 'hcdjbmd.start_at' ),
				Field::inst( 'hcdjbmd.finish_at' ),
				Field::inst( 'hcdjbmd.is_defaultprogram' ),
				Field::inst( 'hcdjbmd.alamat' ),
				Field::inst( 'hcdjbmd.jenis' ),
				Field::inst( 'hcdjbmd.gaji' ),
				Field::inst( 'hcdjbmd.jabatan_awal' ),
				Field::inst( 'hcdjbmd.jabatan_akhir' ),
				Field::inst( 'hcdjbmd.nama_atasan' ),

				Field::inst( 'gctxxmh.nama' )
			)
			->leftJoin( 'gctxxmh','gctxxmh.id','=','hcdjbmd.id_gctxxmh' )
			->where('hcdjbmd.id_hcdxxmh',$_POST['id_hcdxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hcdjbmd'] == 0){
			$editor
				->where( 'hcdjbmd.transaction_state', -9, '<>');
		}
		
		// include( "hcdjbmd_extra.php" );

		// BEGIN log
		// $nama_table = 'hcdjbmd';
		// include( "../../../helpers/edt_log.php" );
		// END log
		
		$json = $editor
			->process( $_POST )
			->data();

		// debugging hak akses
		// // $json['hakakses'] = $hakakses;

		echo json_encode( $json );

	}
?>