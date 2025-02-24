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
	
	$editor = Editor::inst( $db, 'ggsaksh' )
		->debug(true)
		->fields(
			Field::inst( 'ggsaksh.id' ),
			Field::inst( 'ggsaksh.id_aakxxmh_hutang_sementara' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'ggsaksh.id_aakxxmh_persediaan_perjalanan' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'ggsaksh.id_aakxxmh_ekuitas' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'ggsaksh.id_aakxxmh_hpp' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'ggsaksh.id_aakxxmh_pajak_masukan' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'ggsaksh.id_aakxxmh_pajak_keluaran' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'ggsaksh.id_aakxxmh_hutang_usaha' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'ggsaksh.id_aakxxmh_piutang_usaha' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'ggsaksh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'ggsaksh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'ggsaksh.keterangan' ),
			Field::inst( 'ggsaksh.created_by' ),
			Field::inst( 'ggsaksh.transaction_state' ),
			Field::inst( 'ggsaksh.approval_state' ),
			Field::inst( 'ggsaksh.start_at' ),
			Field::inst( 'ggsaksh.finish_at' ),
			Field::inst( 'ggsaksh.is_defaultprogram' ),
			Field::inst( 'ggsaksh.is_nextprocess' ),

			Field::inst( 'hutang_sementara.nama' ),
			Field::inst( 'persediaan_perjalanan.nama' ),
			Field::inst( 'ekuitas.nama' ),
			Field::inst( 'hpp.nama' ),
			Field::inst( 'pajak_masukan.nama' ),
			Field::inst( 'pajak_keluaran.nama' ),
			Field::inst( 'hutang_usaha.nama' ),
			Field::inst( 'piutang_usaha.nama' ),
		)
		->leftJoin( 'aakxxmh hutang_sementara','hutang_sementara.id','=','ggsaksh.id_aakxxmh_hutang_sementara' )
		->leftJoin( 'aakxxmh persediaan_perjalanan','persediaan_perjalanan.id','=','ggsaksh.id_aakxxmh_persediaan_perjalanan' )
		->leftJoin( 'aakxxmh ekuitas','ekuitas.id','=','ggsaksh.id_aakxxmh_ekuitas' )
		->leftJoin( 'aakxxmh hpp','hpp.id','=','ggsaksh.id_aakxxmh_hpp' )
		->leftJoin( 'aakxxmh pajak_masukan','pajak_masukan.id','=','ggsaksh.id_aakxxmh_pajak_masukan' )
		->leftJoin( 'aakxxmh pajak_keluaran','pajak_keluaran.id','=','ggsaksh.id_aakxxmh_pajak_keluaran' )
		->leftJoin( 'aakxxmh hutang_usaha','hutang_usaha.id','=','ggsaksh.id_aakxxmh_hutang_usaha' )
		->leftJoin( 'aakxxmh piutang_usaha','piutang_usaha.id','=','ggsaksh.id_aakxxmh_piutang_usaha' )
		
		->join(
			Mjoin::inst( 'aatxxmh' )
				->name( 'aatxxmh_persediaan' )
				->link( 'ggsaksh.id', 'ggsaksh_aatxxmh_persediaan.id_ggsaksh' )
				->link( 'aatxxmh.id', 'ggsaksh_aatxxmh_persediaan.id_aatxxmh_persediaan' )
				->order( 'aatxxmh.nama asc' )
				->fields(
					Field::inst( 'id' ),
					Field::inst( 'nama' )
				)
		)
		
		->join(
			Mjoin::inst( 'aatxxmh' )
				->name( 'aatxxmh_biaya' )
				->link( 'ggsaksh.id', 'ggsaksh_aatxxmh_biaya.id_ggsaksh' )
				->link( 'aatxxmh.id', 'ggsaksh_aatxxmh_biaya.id_aatxxmh_biaya' )
				->order( 'aatxxmh.nama asc' )
				->fields(
					Field::inst( 'id' ),
					Field::inst( 'nama' )
				)
		)
		
		->join(
			Mjoin::inst( 'aatxxmh' )
				->name( 'aatxxmh_selisih' )
				->link( 'ggsaksh.id', 'ggsaksh_aatxxmh_selisih.id_ggsaksh' )
				->link( 'aatxxmh.id', 'ggsaksh_aatxxmh_selisih.id_aatxxmh_selisih' )
				->order( 'aatxxmh.nama asc' )
				->fields(
					Field::inst( 'id' ),
					Field::inst( 'nama' )
				)
		)
		
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_ggsaksh'] == 0){
		$editor
			->where( 'ggsaksh.transaction_state', -9, '<>');
	}
	
	include( "ggsaksh_extra.php" );

	// BEGIN log
	$nama_table = 'ggsaksh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>