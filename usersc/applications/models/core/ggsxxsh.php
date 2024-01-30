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
	
	$editor = Editor::inst( $db, 'ggsxxsh' )
		->debug(true)
		->fields(
			Field::inst( 'ggsxxsh.id' ),
			Field::inst( 'ggsxxsh.id_iumxxmh_panjang' )
				->setFormatter( Format::ifEmpty( 0 ) ),

			Field::inst( 'ggsxxsh.id_iumxxmh_berat' )
				->setFormatter( Format::ifEmpty( 0 ) ),

			Field::inst( 'ggsxxsh.keterangan' ),
			Field::inst( 'ggsxxsh.created_by' ),
			Field::inst( 'ggsxxsh.transaction_state' ),
			Field::inst( 'ggsxxsh.approval_state' ),
			Field::inst( 'ggsxxsh.start_at' ),
			Field::inst( 'ggsxxsh.finish_at' ),
			Field::inst( 'ggsxxsh.is_defaultprogram' ),

			Field::inst( 'ggsxxsh.id_files_company_logo' )
                ->upload(
                    Upload::inst($abs_us_root . $us_url_root . 'usersc/files/uploads/__ID__.__EXTN__')
                    ->db('files', 'id', array(
                        'filename'    => Upload::DB_FILE_NAME,
                        'filesize'    => Upload::DB_FILE_SIZE,
                        'web_path'    => Upload::DB_WEB_PATH,
                        'system_path' => Upload::DB_SYSTEM_PATH,
                        'extn'         => Upload::DB_EXTN
                    ))
                    ->validator( Validate::fileSize( 500000, 'Ukuran foto maksimal 500kb' ) )
                    ->validator(Validate::fileExtensions(array('png', 'jpg', 'jpeg'), "Hanya diperbolehkan jenis png, jpg, atau jpeg"))
                ),
			
			Field::inst( 'ggsxxsh.posisi_logo_login' ),
			Field::inst( 'files.web_path' ),
			Field::inst( 'berat.nama' ),
			Field::inst( 'panjang.nama' )
		)
		->leftJoin( 'iumxxmh AS panjang','panjang.id','=','ggsxxsh.id_iumxxmh_panjang' )
		->leftJoin( 'iumxxmh AS berat','berat.id','=','ggsxxsh.id_iumxxmh_berat' )
        ->leftJoin( 'files','files.id','=','ggsxxsh.id_files_company_logo' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_ggsxxsh'] == 0){
		$editor
			->where( 'ggsxxsh.transaction_state', -9, '<>');
	}
	
	// include( "ggsxxsh_extra.php" );

	// BEGIN log
	$nama_table = 'ggsxxsh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );

?>