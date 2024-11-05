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
	
	$editor = Editor::inst( $db, 'hemxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'hemxxmh.id' ),
			Field::inst( 'hemjbmh.id_hovxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hemjbmh.id_hodxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hemjbmh.id_hosxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hemjbmh.id_hevxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hemjbmh.id_hetxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hemjbmh.id_heyxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hemjbmh.id_hesxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hemjbmh.id_heyxxmd' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hemxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hemxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hemxxmh.id_files_foto' )
				->setFormatter( Format::ifEmpty( 0 ) )
				// ->upload( Upload::inst(  $abs_us_root.$us_url_root.'usersc/files/uploads/ktp/__ID__.__EXTN__' )
				->upload( Upload::inst(  $abs_us_root.$us_url_root.'usersc/files/hemxxmh_foto/__ID__.__EXTN__' )
					->db( 'files', 'id', array(
						'filename'		=> Upload::DB_FILE_NAME,
						'filesize'		=> Upload::DB_FILE_SIZE,
						'web_path'		=> Upload::DB_WEB_PATH,
						'system_path'	=> Upload::DB_SYSTEM_PATH,
						'extn'		=> Upload::DB_EXTN
					) )
					->validator( Validate::fileSize( 1000000, 'Ukuran lampiran maksimal 1Mb' ) )
					->validator( Validate::fileExtensions( array( 'png', 'jpg', 'jpeg'), "Hanya boleh format png, jpg, dan jpeg" ) )
				),
			Field::inst( 'hemxxmh.id_files_ktp' )
				->setFormatter( Format::ifEmpty( 0 ) )
				// ->upload( Upload::inst(  $abs_us_root.$us_url_root.'usersc/files/uploads/ktp/__ID__.__EXTN__' )
				->upload( Upload::inst(  $abs_us_root.$us_url_root.'usersc/files/uploads/__ID__.__EXTN__' )
					->db( 'files', 'id', array(
						'filename'		=> Upload::DB_FILE_NAME,
						'filesize'		=> Upload::DB_FILE_SIZE,
						'web_path'		=> Upload::DB_WEB_PATH,
						'system_path'	=> Upload::DB_SYSTEM_PATH,
						'extn'		=> Upload::DB_EXTN
					) )
					->validator( Validate::fileSize( 500000, 'Ukuran lampiran maksimal 500Kb' ) )
					->validator( Validate::fileExtensions( array( 'png', 'jpg', 'jpeg', 'pdf'), "Hanya boleh format png, jpg, jpeg dan pdf" ) )
				),
			Field::inst( 'hemxxmh.id_files_npwp' )
				->setFormatter( Format::ifEmpty( 0 ) )
				// ->upload( Upload::inst(  $abs_us_root.$us_url_root.'usersc/files/uploads/npwp/__ID__.__EXTN__' )
				->upload( Upload::inst(  $abs_us_root.$us_url_root.'usersc/files/uploads/__ID__.__EXTN__' )
					->db( 'files', 'id', array(
						'filename'		=> Upload::DB_FILE_NAME,
						'filesize'		=> Upload::DB_FILE_SIZE,
						'web_path'		=> Upload::DB_WEB_PATH,
						'system_path'	=> Upload::DB_SYSTEM_PATH,
						'extn'		=> Upload::DB_EXTN
					) )
					->validator( Validate::fileSize( 500000, 'Ukuran lampiran maksimal 500Kb' ) )
					->validator( Validate::fileExtensions( array( 'png', 'jpg', 'jpeg', 'pdf'), "Hanya boleh format png, jpg, jpeg dan pdf" ) )
				),
			Field::inst( 'hemxxmh.keterangan' ),
			Field::inst( 'hemxxmh.transaction_state' ),
			Field::inst( 'hemxxmh.approval_state' ),
			Field::inst( 'hemxxmh.created_by' ),
			Field::inst( 'hemxxmh.start_at' ),
			Field::inst( 'hemxxmh.finish_at' ),
			Field::inst( 'hemxxmh.is_pot_makan' ),
			Field::inst( 'hemxxmh.is_defaultprogram' ),
			Field::inst( 'hemxxmh.is_nextprocess' ),
			Field::inst( 'hemxxmh.id_gctxxmh_lahir' )
			->setFormatter( Format::ifEmpty( 0 ) ),

			Field::inst( 'hemxxmh.gender' ),
			Field::inst( 'hemxxmh.agama' ),
			Field::inst( 'hemxxmh.golongan_darah' ),
			
			Field::inst( 'hemjbmh.tanggal_masuk' )
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
			Field::inst( 'hemjbmh.tanggal_keluar' )
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
			Field::inst( 'hemjbmh.tanggal_akhir_pkwt' )
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
			Field::inst( 'hemjbmh.grup_hk' ),
			Field::inst( 'hemjbmh.jumlah_grup' ),
			Field::inst( 'hovxxmh.nama' ),
			Field::inst( 'hodxxmh.nama' ),
			Field::inst( 'hemdcmh.id_gtxpkmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hemdcmh.is_npwp' ),
			Field::inst( 'hemdcmh.npwp_alamat' ),
			Field::inst( 'hemdcmh.npwp_no' ),
			Field::inst( 'hemdcmh.ktp_no' ),
			Field::inst( 'hemdcmh.no_bpjs_tk' ),
			Field::inst( 'hemdcmh.no_bpjs_kes' ),
			Field::inst( 'hemdcmh.ktp_alamat' ),
			Field::inst( 'hosxxmh.nama' ),
			Field::inst( 'hevxxmh.nama' ),
			Field::inst( 'hetxxmh.nama' ),
			Field::inst( 'heyxxmh.nama' ),
			Field::inst( 'heyxxmd.nama' ),
			Field::inst( 'hesxxmh.nama' ),
			
			// contact & sosmed
			Field::inst( 'hemcsmh.id_gctxxmh_tinggal' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hemcsmh.email_personal' ),
			Field::inst( 'hemcsmh.handphone' ),
			Field::inst( 'hemcsmh.whatsapp' ),
			Field::inst( 'hemcsmh.facebook' ),
			Field::inst( 'hemcsmh.twitter' ),
			Field::inst( 'hemcsmh.linkedin' ),
			Field::inst( 'hemcsmh.instagram' ),
			Field::inst( 'hemcsmh.tiktok' ),
			Field::inst( 'hemcsmh.alamat_tinggal' ),
			
			// document
			Field::inst( 'hemdcmh.id_gctxxmh_ktp' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hemdcmh.id_gctxxmh_npwp' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hemdcmh.sim_a' ),
			Field::inst( 'hemdcmh.sim_b' ),
			Field::inst( 'hemdcmh.sim_c' ),
		)
		->leftJoin( 'hemdcmh','hemdcmh.id_hemxxmh','=','hemxxmh.id' )
		->leftJoin( 'hemjbmh','hemjbmh.id_hemxxmh','=','hemxxmh.id' )
		->leftJoin( 'hovxxmh','hovxxmh.id','=','hemjbmh.id_hovxxmh' )
		->leftJoin( 'hodxxmh','hodxxmh.id','=','hemjbmh.id_hodxxmh' )
		->leftJoin( 'hosxxmh','hosxxmh.id','=','hemjbmh.id_hosxxmh' )
		->leftJoin( 'hevxxmh','hevxxmh.id','=','hemjbmh.id_hevxxmh' )
		->leftJoin( 'hetxxmh','hetxxmh.id','=','hemjbmh.id_hetxxmh' )
		->leftJoin( 'heyxxmh','heyxxmh.id','=','hemjbmh.id_heyxxmh' )
		->leftJoin( 'heyxxmd','heyxxmd.id','=','hemjbmh.id_heyxxmd' )
		->leftJoin( 'hesxxmh','hesxxmh.id','=','hemjbmh.id_hesxxmh' )
		
		// contact & Sosmed
		->leftJoin( 'hemcsmh','hemcsmh.id_hemxxmh','=','hemxxmh.id' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hemxxmh'] == 0){
		$editor
			->where( 'hemxxmh.transaction_state', -9, '<>');
	}
	
	include( "hemxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'hemxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>