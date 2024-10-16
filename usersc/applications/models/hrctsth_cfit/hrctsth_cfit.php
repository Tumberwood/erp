<?php
	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );
	
	use
		DataTables\Editor,
		DataTables\Editor\Field,
		DataTables\Editor\Format,
		DataTables\Editor\Mjoin,
		DataTables\Editor\Options,
		DataTables\Editor\Upload,
		DataTables\Editor\Validate,
		DataTables\Editor\ValidateOptions,
		DataTables\Editor\Query,
		DataTables\Editor\Result;
	
	// ----------- do not erase
	$show_inactive_status = $_POST['show_inactive_status_hrctsth_cfit'];
	// -----------
	
	$editor = Editor::inst( $db, 'hrctsth_cfit' )
		->debug(true)
		->fields(
			Field::inst( 'hrctsth_cfit.id' ),
			Field::inst( 'hrctsth_cfit.id_hcdxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) )
				->options( Options::inst()
					->table( 'hcdxxmh' )
					->value( 'id' )
					->label( ['kode','nama'] )
					->where( function ($q) {
						$q->where( 'is_active', 1 );
					})
					->render( function ( $row ) {
						return $row['kode'] . ' - ' . $row['nama'];
					} )
					->order( 'nama' )
				),
			Field::inst( 'hrctsth_cfit.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hrctsth_cfit.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hrctsth_cfit.keterangan' ),
			Field::inst( 'hrctsth_cfit.sesi_ke' ),
			Field::inst( 'hrctsth_cfit.is_active' ),
			Field::inst( 'hrctsth_cfit.created_by' )
				->set( Field::SET_CREATE )
				->setValue($_SESSION['user']),
			Field::inst( 'hrctsth_cfit.created_on' )
				->set( Field::SET_CREATE ),
			Field::inst( 'hrctsth_cfit.last_edited_by' )
				->set( Field::SET_EDIT )
				->setValue($_SESSION['user']),
			Field::inst( 'hrctsth_cfit.is_approve' ),
			Field::inst( 'hrctsth_cfit.is_defaultprogram' ),
			Field::inst( 'hcdxxmh.nama' )
		)
		->leftJoin( 'hcdxxmh','hcdxxmh.id','=','hrctsth_cfit.id_hcdxxmh' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ($show_inactive_status == 0){
		$editor
			->where( 'hrctsth_cfit.is_active', 1);
	}
	
	include( "hrctsth_cfit_extra.php" );
	include( "../../../helpers/edt_log.php" );
	
	$editor
		->process( $_POST )
		->json();
?>