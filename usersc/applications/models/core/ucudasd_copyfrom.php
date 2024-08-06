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
	
	if ( ! isset($_POST['id_udpxxsh']) || ! is_numeric($_POST['id_udpxxsh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'ucudasd' )
			->debug(true)
			->fields(
				Field::inst( 'ucudasd.id' )
					->set( Field::SET_NONE ),
				Field::inst( 'ucudasd.id_udpxxsh' )
					->set( Field::SET_NONE )
			)
			->where('ucudasd.id_udpxxsh',$_POST['id_udpxxsh']);
		
		$editor
			->on('preCreate',function( $editor, $values ) use ( $s_id_users, $s_username) {
				$start_at           = $values['start_at'];
            	$finish_at          = $values['finish_at'];
				$id_udpxxsh = $values['ucudasd']['id_udpxxsh'];

				//hapus detail lama
				$qd_ucudasd = $editor->db()
					->query('delete', 'ucudasd')
					->where('id_udpxxsh',$id_udpxxsh)
					->exec();
				
				$qs_udpxxsh = $editor->db()
					->query('select', 'udpxxsh' )
					->get(['id_users'] )
					->where('id', $id_udpxxsh )
					->exec();
				$rs_udpxxsh = $qs_udpxxsh->fetch();
				$id_users = $rs_udpxxsh['id_users'];

				$qs_ucudasd = $editor->db()
					->raw()
					->bind(':id_udpxxsh_source', $values['id_udpxxsh_source'])
					->bind(':id_udpxxsh_target', $id_udpxxsh)
					->bind(':id_users', $id_users)
					->exec('
						INSERT INTO
							ucudasd (
								id_udpxxsh,
								id_users,
								id_pages,
								hak_c,
								hak_r,
								hak_u,
								hak_d,
								hak_a,
								hak_e,
								hak_p
							)
						SELECT
							:id_udpxxsh_target,
							:id_users,
							id_pages,
							hak_c,
							hak_r,
							hak_u,
							hak_d,
							hak_a,
							hak_e,
							hak_p
						FROM ucudasd
						WHERE 1
							AND id_udpxxsh = :id_udpxxsh_source 
					');

					General::logChange( $editor->db() , 'ucudasd', $s_id_users, $s_username, 'CREATE', $values['ucudasd']['id_udpxxsh'], 'Insert from generate', $start_at, $finish_at );

			});
		
		$json = $editor
			->process( $_POST )
			->data();

		// debugging hak akses
		$json['hakakses'] = $hakakses;

		echo json_encode( $json );

	}
?>