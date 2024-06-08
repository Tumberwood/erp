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
	
	if ( ! isset($_POST['id_iimxxmh']) || ! is_numeric($_POST['id_iimxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'iimummd' )
			->debug(true)
			->fields(
				Field::inst( 'iimummd.id' )
					->set( Field::SET_NONE ),
				Field::inst( 'iimummd.id_iimxxmh' )
					->set( Field::SET_NONE )
			)
			->where('iimummd.id_iimxxmh',$_POST['id_iimxxmh']);
		
		$editor
			->on('preCreate',function( $editor, $values ) {
				$qs_iimummd = $editor->db()
					->raw()
					->bind(':id_iimxxmh_source', $values['id_iimxxmh_source'])
					->exec('
						INSERT INTO
							iimummd (
								id_iimxxmh,
								id_iumxxmh,
								is_default,
								is_terkecil,
								is_iumxxmh_beli,
								is_iumxxmh_jual,
								jumlah_konversi,
								panjang,
								lebar,
								tinggi,
								nw,
								gw
							)
						SELECT
							'. $values['iimummd']['id_iimxxmh'] . ',
							id_iumxxmh,
							is_default,
							is_terkecil,
							is_iumxxmh_beli,
							is_iumxxmh_jual,
							jumlah_konversi,
							panjang,
							lebar,
							tinggi,
							nw,
							gw
						FROM iimummd
						WHERE 
							id_iimxxmh = :id_iimxxmh_source AND
							id_iimxxmh NOT IN (
								SELECT
									id_iimxxmh
								FROM iimummd
								WHERE 
									id_iimxxmh = :id_iimxxmh_source
							)
					');
			});

		// BEGIN log
		// $nama_table = 'iimummd';
		// include( "../../../helpers/edt_log.php" );
		// END log
		
		$json = $editor
			->process( $_POST )
			->data();

		// debugging hak akses
		$json['hakakses'] = $hakakses;

		echo json_encode( $json );

	}
?>