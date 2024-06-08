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
		$editor = Editor::inst( $db, 'wimlotd' )
			->debug(true)
			->fields(
				Field::inst( 'wimlotd.id' )
					->set( Field::SET_NONE )
			)
			->where('wimlotd.id_iimxxmh',$_POST['id_iimxxmh']);
		
		$editor
			->on('preCreate',function( $editor, $values ) {
				$id_iimxxmh    = $values['id_iimxxmh'];

                $w_rack_name = '';
                $w_bay_name = '';
                $w_level_name = '';
                $w_position_name = '';
                $params = [];

                if (!empty($values['rack_name'])) {
                    $rack_name_values = array_map(function($value) {
                        return "'" . $value . "'";
                    }, $values['rack_name']);
                    $rack_name_placeholders = implode(',', $rack_name_values);
                    $w_rack_name = 'AND rack_name IN (' . $rack_name_placeholders . ') ';

                }else{
                    $w_rack_name = '';
                }

                if (!empty($values['bay_name'])) {
                    $bay_name_values = array_map(function($value) {
                        return "'" . $value . "'";
                    }, $values['bay_name']);
                    $bay_name_placeholders = implode(',', $bay_name_values);
                    $w_bay_name = 'AND bay_name IN (' . $bay_name_placeholders . ') ';

                }else{
                    $w_bay_name = '';
                }

                if (!empty($values['level_name'])) {
                    $level_name_values = array_map(function($value) {
                        return "'" . $value . "'";
                    }, $values['level_name']);
                    $level_name_placeholders = implode(',', $level_name_values);
                    $w_level_name = 'AND level_name IN (' . $level_name_placeholders . ') ';

                }else{
                    $w_level_name = '';
                }

                if (!empty($values['position_name'])) {
                    $position_name_values = array_map(function($value) {
                        return "'" . $value . "'";
                    }, $values['position_name']);
                    $position_name_placeholders = implode(',', $position_name_values);
                    $w_position_name = 'AND position_name IN (' . $position_name_placeholders . ') ';

                }else{
                    $w_position_name = '';
                }

                // NON IN
                $qs_wimlotd = $editor->db()
                    ->query('select', 'wimlotd' )
                    ->get([
                        'wimlotd.id_wloxxmh as id_wloxxmh'
                    ] )
                    ->where('wimlotd.id_iimxxmh', $id_iimxxmh )
                    ->exec();
                $rs_wimlotd = $qs_wimlotd->fetchAll();
                
                if (!empty($rs_wimlotd)) {
                    $qs_wimlotd_max_urutan = $editor->db()
                        ->query('select', 'wimlotd' )
                        ->get([
                            'MAX(wimlotd.urutan) as max_urutan'
                        ] )
                        ->where('wimlotd.id_iimxxmh', $id_iimxxmh )
                        ->exec();
                    $rs_wimlotd_max_urutan = $qs_wimlotd_max_urutan->fetch();
                    $max_urutan = $rs_wimlotd_max_urutan['max_urutan'];

                    $wimlotd_ids = array_column($rs_wimlotd, 'id_wloxxmh');
                    $wimlotd_placeholders = implode(',', $wimlotd_ids);
                    $w_wimlotd = 'AND id NOT IN (' . $wimlotd_placeholders . ') ';
                }else{
                    $w_wimlotd = '';
                }

                $editor->db()->raw()->exec('SET @rownr='.$max_urutan);

                $qs_wloxxmh = $editor->db()
                    ->raw()
                    ->exec('
                        INSERT INTO 
                            wimlotd(
                                id_iimxxmh,
                                id_wloxxmh,
                                urutan
                            )
                        SELECT
                            '.$id_iimxxmh.',
                            id as id_wloxxmh,
                            @rownr:=@rownr+1 AS rowNumber
                        FROM wloxxmh
                        WHERE 1 ' 
                            . $w_rack_name 
                            . $w_bay_name 
                            . $w_level_name 
                            . $w_position_name 
                            . $w_wimlotd . ';'
                    );

			});

		// BEGIN log
		// $nama_table = 'wimlotd';
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