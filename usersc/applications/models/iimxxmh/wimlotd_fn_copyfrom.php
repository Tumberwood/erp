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
		DataTables\Editor\Result,
		Carbon\Carbon,
		SolusiIndonesia\Utilities\General;
	
	if ( ! isset($_POST['id_iimxxmh']) || ! is_numeric($_POST['id_iimxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'wimlotd' )
			->debug(true)
			->fields(
				Field::inst( 'wimlotd.id' )
					->set( Field::SET_NONE ),
				Field::inst( 'wimlotd.id_iimxxmh' )
					->set( Field::SET_NONE )
			)
			->where('wimlotd.id_iimxxmh',$_POST['id_iimxxmh']);
		
		$editor
			->on('preCreate',function( $editor, $values ) use ( $s_id_users, $s_username) {
				$start_at           = $values['start_at'];
            	$finish_at          = $values['finish_at'];

				$qs_wimlotd = $editor->db()
					->raw()
					->bind(':id_iimxxmh_source', $values['id_iimxxmh_source'])
					->bind(':id_iimxxmh_target', $values['wimlotd']['id_iimxxmh'])
					->exec('
						INSERT INTO
							wimlotd (
								id_iimxxmh,
								id_wloxxmh,
								urutan
							)
						SELECT
							'. $values['wimlotd']['id_iimxxmh'] . ',
							id_wloxxmh,
							urutan
						FROM wimlotd
						WHERE 1
                            AND id_iimxxmh = :id_iimxxmh_source 
							AND id_iimxxmh NOT IN (
								SELECT
									id_iimxxmh
								FROM wimlotd
								WHERE
									id_iimxxmh = :id_iimxxmh_target
							)
					');

					General::logChange( $editor->db() , 'wimlotd', $s_id_users, $s_username, 'CREATE', $values['wimlotd']['id_iimxxmh'], 'Insert from generate', $start_at, $finish_at );
			});
		
		$json = $editor
			->process( $_POST )
			->data();

		// debugging hak akses
		$json['hakakses'] = $hakakses;

		echo json_encode( $json );

	}
?>