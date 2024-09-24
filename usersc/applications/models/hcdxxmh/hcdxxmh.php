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
	
	$editor = Editor::inst( $db, 'hcdxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'hcdxxmh.id' ),
			Field::inst( 'hcdxxmh.id_files_foto' )
				->setFormatter( Format::ifEmpty( 0 ) )
				->upload( Upload::inst(  $abs_us_root.$us_url_root.'usersc/files/uploads/__ID__.__EXTN__' )
					->db( 'files', 'id', array(
						'filename'    => Upload::DB_FILE_NAME,
						'filesize'    => Upload::DB_FILE_SIZE,
						'web_path'    => Upload::DB_WEB_PATH,
						'system_path' => Upload::DB_SYSTEM_PATH,
						'extn' 		  => Upload::DB_EXTN
					) )
					->validator( Validate::fileSize( 500000, 'Ukuran lampiran maksimal 500Kb' ) )
					->validator( Validate::fileExtensions( array( 'png', 'jpg', 'jpeg'), "Hanya boleh format png, jpg atau jpeg" ) )
				),
			Field::inst( 'hcdxxmh.id_files_cv' )
				->setFormatter( Format::ifEmpty( 0 ) )
				->upload( Upload::inst(  $abs_us_root.$us_url_root.'usersc/files/uploads/__ID__.__EXTN__' )
					->db( 'files', 'id', array(
						'filename'    => Upload::DB_FILE_NAME,
						'filesize'    => Upload::DB_FILE_SIZE,
						'web_path'    => Upload::DB_WEB_PATH,
						'system_path' => Upload::DB_SYSTEM_PATH,
						'extn' 		  => Upload::DB_EXTN
					) )
					->validator( Validate::fileSize( 2000000, 'Ukuran lampiran maksimal 2Mb' ) )
					->validator( Validate::fileExtensions( array( 'png', 'jpg', 'jpeg', 'pdf'), "Hanya boleh format png, jpg, jpeg atau PDF" ) )
				),
			Field::inst( 'hcdxxmh.id_files_vaksin' )
				->setFormatter( Format::ifEmpty( 0 ) )
				->upload( Upload::inst(  $abs_us_root.$us_url_root.'usersc/files/uploads/__ID__.__EXTN__' )
					->db( 'files', 'id', array(
						'filename'    => Upload::DB_FILE_NAME,
						'filesize'    => Upload::DB_FILE_SIZE,
						'web_path'    => Upload::DB_WEB_PATH,
						'system_path' => Upload::DB_SYSTEM_PATH,
						'extn' 		  => Upload::DB_EXTN
					) )
					->validator( Validate::fileSize( 500000, 'Ukuran lampiran maksimal 500Kb' ) )
					->validator( Validate::fileExtensions( array( 'png', 'jpg', 'jpeg'), "Hanya boleh format png, jpg atau jpeg" ) )
				),
			Field::inst( 'hcddcmh.id_files_sim' )
				->setFormatter( Format::ifEmpty( 0 ) )
				->upload( Upload::inst(  $abs_us_root.$us_url_root.'usersc/files/uploads/__ID__.__EXTN__' )
					->db( 'files', 'id', array(
						'filename'    => Upload::DB_FILE_NAME,
						'filesize'    => Upload::DB_FILE_SIZE,
						'web_path'    => Upload::DB_WEB_PATH,
						'system_path' => Upload::DB_SYSTEM_PATH,
						'extn' 		  => Upload::DB_EXTN
					) )
					->validator( Validate::fileSize( 500000, 'Ukuran lampiran maksimal 500Kb' ) )
					->validator( Validate::fileExtensions( array( 'png', 'jpg', 'jpeg'), "Hanya boleh format png, jpg atau jpeg" ) )
				),
			Field::inst( 'hcddcmh.id_files_ktp' )
				->setFormatter( Format::ifEmpty( 0 ) )
				->upload( Upload::inst(  $abs_us_root.$us_url_root.'usersc/files/uploads/__ID__.__EXTN__' )
					->db( 'files', 'id', array(
						'filename'    => Upload::DB_FILE_NAME,
						'filesize'    => Upload::DB_FILE_SIZE,
						'web_path'    => Upload::DB_WEB_PATH,
						'system_path' => Upload::DB_SYSTEM_PATH,
						'extn' 		  => Upload::DB_EXTN
					) )
					->validator( Validate::fileSize( 500000, 'Ukuran lampiran maksimal 500Kb' ) )
					->validator( Validate::fileExtensions( array( 'png', 'jpg', 'jpeg'), "Hanya boleh format png, jpg atau jpeg" ) )
				),
			Field::inst( 'hcdxxmh.id_gctxxmh_lahir' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hcdxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hcdxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hcdxxmh.keterangan' ),
			Field::inst( 'hcdxxmh.created_by' ),
			Field::inst( 'hcdxxmh.transaction_state' ),
			Field::inst( 'hcdxxmh.approval_state' ),
			Field::inst( 'hcdxxmh.start_at' ),
			Field::inst( 'hcdxxmh.finish_at' ),
			Field::inst( 'hcdxxmh.is_defaultprogram' ),
			Field::inst( 'hcdxxmh.is_nextprocess' ),
			Field::inst( 'hcdxxmh.suku' ),
			Field::inst( 'hcdxxmh.tinggi' ),
			Field::inst( 'hcdxxmh.berat' ),
			Field::inst( 'hcdxxmh.no_sepatu' ),
			Field::inst( 'hcdxxmh.ukuran_seragam' ),
			Field::inst( 'hcdxxmh.vaksin' ),
			Field::inst( 'hcdxxmh.tanggal_lahir' )
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
			Field::inst( 'hcdxxmh.gender' ),
			Field::inst( 'hcdxxmh.agama' ),
			Field::inst( 'hcdxxmh.hobby' ),
			Field::inst( 'hcdxxmh.perkawinan' ),

			Field::inst( 'gctxxmh_lahir.nama' ),

			Field::inst( 'hcdmdmh.gol_darah' ),

			// contact & sosmed
			Field::inst( 'hcdcsmh.id_gctxxmh_tinggal' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hcdcsmh.email_personal' ),
			Field::inst( 'hcdcsmh.handphone' ),
			Field::inst( 'hcdcsmh.whatsapp' ),
			Field::inst( 'hcdcsmh.facebook' ),
			Field::inst( 'hcdcsmh.twitter' ),
			Field::inst( 'hcdcsmh.linkedin' ),
			Field::inst( 'hcdcsmh.instagram' ),
			Field::inst( 'hcdcsmh.tiktok' ),
			Field::inst( 'hcdcsmh.alamat_tinggal' ),

			// document
			Field::inst( 'hcddcmh.id_gctxxmh_ktp' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hcddcmh.id_gctxxmh_npwp' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hcddcmh.ktp_no' ),
			Field::inst( 'hcddcmh.ktp_alamat' ),
			Field::inst( 'hcddcmh.sim_a' ),
			Field::inst( 'hcddcmh.sim_b' ),
			Field::inst( 'hcddcmh.sim_c' ),
			Field::inst( 'hcddcmh.rt' ),
			Field::inst( 'hcddcmh.rw' ),
			Field::inst( 'hcddcmh.kelurahan' ),
			Field::inst( 'hcddcmh.kecamatan' ),
			Field::inst( 'hcddcmh.asal_sekolah' ),
			Field::inst( 'hcddcmh.jurusan' ),
			Field::inst( 'hcddcmh.is_npwp' ),
			Field::inst( 'hcddcmh.npwp_no' ),
			Field::inst( 'hcddcmh.npwp_alamat' ),
			Field::inst( 'hcddcmh.id_gtxpkmh' ),

			Field::inst( 'gctxxmh_ktp.nama' ),

			// job
			Field::inst( 'hcdjbmh.id_hetxxmh' )
			->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hcdjbmh.quiz1' ),
			Field::inst( 'hcdjbmh.quiz2' ),
			Field::inst( 'hcdjbmh.quiz3' ),
			Field::inst( 'hcdjbmh.quiz4' ),
			Field::inst( 'hcdjbmh.quiz5' ),
			Field::inst( 'hcdjbmh.bpjskes_no' ),
			Field::inst( 'hcdjbmh.bpjstk_no' ),
			Field::inst( 'hcdjbmh.tempat_tinggal' ),
			Field::inst( 'hcdjbmh.kendaraan' ),
			Field::inst( 'hcdjbmh.kendaraan_milik' ),
			Field::inst( 'hcdjbmh.intrv_self_1' ),
			Field::inst( 'hcdjbmh.intrv_self_2' ),
			Field::inst( 'hcdjbmh.intrv_self_3' ),
			Field::inst( 'hcdjbmh.intrv_self_4' ),
			Field::inst( 'hcdjbmh.intrv_self_5' ),
			Field::inst( 'hcdjbmh.intrv_self_6' ),
			Field::inst( 'hcdjbmh.intrv_self_7' ),
			Field::inst( 'hcdjbmh.intrv_self_8' ),
			Field::inst( 'hcdjbmh.intrv_self_9' ),
			Field::inst( 'hcdjbmh.intrv_self_10' ),
			Field::inst( 'hcdjbmh.intrv_self_11' ),
			Field::inst( 'hcdjbmh.intrv_self_12' ),
			Field::inst( 'hcdjbmh.intrv_self_13' ),
				
			Field::inst( 'hetxxmh.nama' )
			
		)
		// personal data
		->leftJoin( 'gctxxmh as gctxxmh_lahir','gctxxmh_lahir.id','=','hcdxxmh.id_gctxxmh_lahir' )

		// medic
		->leftJoin( 'hcdmdmh','hcdmdmh.id_hcdxxmh','=','hcdxxmh.id' )

		// contact & Sosmed
		->leftJoin( 'hcdcsmh','hcdcsmh.id_hcdxxmh','=','hcdxxmh.id' )
		->leftJoin( 'gctxxmh as gctxxmh_tinggal','gctxxmh_tinggal.id','=','hcdcsmh.id_gctxxmh_tinggal' )
		
		// document
		->leftJoin( 'hcddcmh','hcddcmh.id_hcdxxmh','=','hcdxxmh.id' )
		->leftJoin( 'gctxxmh as gctxxmh_ktp','gctxxmh_ktp.id','=','hcddcmh.id_gctxxmh_ktp' )

		// job
		->leftJoin( 'hcdjbmh','hcdjbmh.id_hcdxxmh','=','hcdxxmh.id' )
		->leftJoin( 'hetxxmh','hetxxmh.id','=','hcdjbmh.id_hetxxmh' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hcdxxmh'] == 0){
		$editor
			->where( 'hcdxxmh.transaction_state', -9, '<>');
	}
	
	include( "hcdxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'hcdxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>