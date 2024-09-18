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
		$editor = Editor::inst( $db, 'hemwrmd' )
			->debug(true)
			->fields(
				Field::inst( 'hemwrmd.id' ),
				Field::inst( 'hemwrmd.id_hemxxmh' ),
				Field::inst( 'hemwrmd.id_gctxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hemwrmd.kode' ),
				Field::inst( 'hemwrmd.nama' ),
				Field::inst( 'hemwrmd.keterangan' ),
				Field::inst( 'hemwrmd.created_by' ),
				Field::inst( 'hemwrmd.transaction_state' ),
				Field::inst( 'hemwrmd.approval_state' ),
				Field::inst( 'hemwrmd.start_at' ),
				Field::inst( 'hemwrmd.finish_at' ),
				Field::inst( 'hemwrmd.is_defaultprogram' ),
				Field::inst( 'hemwrmd.is_default' ),
				Field::inst( 'hemwrmd.tanggal_masuk' )
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
				Field::inst( 'hemwrmd.tanggal_keluar' )
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
				Field::inst( 'hemwrmd.perusahaan' ),
				Field::inst( 'hemwrmd.jenis_usaha' ),
				Field::inst( 'hemwrmd.alamat' ),
				Field::inst( 'hemwrmd.alasan_keluar' ),
				Field::inst( 'hemwrmd.nama_atasan' ),
				Field::inst( 'hemwrmd.jabatan_atasan' ),
				Field::inst( 'hemwrmd.jabatan_awal' ),
				Field::inst( 'hemwrmd.jabatan_akhir' ),
				Field::inst( 'hemwrmd.gaji_terakhir' ),

				Field::inst( 'gctxxmh.nama' )
			)
			->leftJoin( 'gctxxmh','gctxxmh.id','=','hemwrmd.id_gctxxmh' )
			->where('hemwrmd.id_hemxxmh',$_POST['id_hemxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hemwrmd'] == 0){
			$editor
				->where( 'hemwrmd.transaction_state', -9, '<>');
		}
		
		// include( "hemwrmd_extra.php" );

		// BEGIN log
		$nama_table = 'hemwrmd';
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