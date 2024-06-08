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
        SolusiIndonesia\Utilities\Converter,
        SolusiIndonesia\Utilities\General;
	
    $editor = Editor::inst( $db, 'wloxxmh' )
        ->debug(true)
        ->fields(
            Field::inst( 'wloxxmh.id' )
                ->set( Field::SET_NONE )
        );
    
    $editor
        ->on('preCreate',function( $editor, $values ) use ( $s_id_users, $s_username) {

            $start_at           = $values['start_at'];
            $finish_at          = $values['finish_at'];
            $id_iwhxxmh           = $values['id_iwhxxmh'];
            $id_wloctmh           = $values['id_wloctmh'];
            $id_wlotpmh           = $values['id_wlotpmh'];
            
            if($values['id_wlotpmh'] > 0){
                $id_wloznmh = $values['id_wlotpmh'];
            }else{
                $id_wloznmh = 0;
            }

            $kapasitas            = $values['kapasitas'];
            $id_iumxxmh_kapasitas = $values['id_iumxxmh_kapasitas'];
            
            $rack_names     = Converter::extractText($values['rack_name']);
            $bay_names      = Converter::extractText($values['bay_name']);
            $level_names    = Converter::extractText($values['level_name']);
            $position_names = Converter::extractText($values['position_name']);

            $qs_iwhxxmh = $editor->db()
                ->query('select', 'iwhxxmh' )
                ->get([
                    'iwhxxmh.kode as iwhxxmh_kode'
                ] )
                ->where('iwhxxmh.id', $id_iwhxxmh )
                ->exec();
            $rs_iwhxxmh = $qs_iwhxxmh->fetch();
            $iwhxxmh_kode = $rs_iwhxxmh['iwhxxmh_kode'];

            $result = [];

            foreach ($rack_names as $rack_name) {
                foreach ($bay_names as $bay_name) {
                    foreach ($level_names as $level_name) {
                        foreach ($position_names as $position_name) {

                            $nama = $iwhxxmh_kode . '-' . $rack_name . '-' . $bay_name . '-' . $level_name . '-' . $position_name;

                            $rack     = Converter::convertAllToNumber($rack_name);
                            $bay      = Converter::convertAllToNumber($bay_name);
                            $level    = Converter::convertAllToNumber($level_name);
                            $position = Converter::convertAllToNumber($position_name);
                            
                            $qs_wloxxmh = $editor->db()
                                ->query('select', 'wloxxmh' )
                                ->get([
                                    'wloxxmh.id as id_wloxxmh'
                                ] )
                                ->where('wloxxmh.nama', $nama )
                                ->exec();
                            $rs_wloxxmh = $qs_wloxxmh->fetch();

                            if(empty($rs_wloxxmh)){
                                $qi_wloxxmh = $editor->db()
                                    ->query('insert', 'wloxxmh')
                                    ->set('id_iwhxxmh',$id_iwhxxmh)
                                    ->set('id_wloctmh',$id_wloctmh)
                                    ->set('id_wlotpmh',$id_wlotpmh)
                                    ->set('id_wloznmh',$id_wloznmh)
                                    ->set('id_iumxxmh_kapasitas',$id_iumxxmh_kapasitas)
                                    ->set('nama',$nama)
                                    ->set('transaction_state',1)
                                    ->set('kapasitas',$kapasitas)
                                    ->set('rack',$rack)
                                    ->set('rack_name',$rack_name)
                                    ->set('bay',$bay)
                                    ->set('bay_name',$bay_name)
                                    ->set('level',$level)
                                    ->set('level_name',$level_name)
                                    ->set('position',$position)
                                    ->set('position_name',$position_name)
                                    ->exec();
                                $id_wloxxmh = $qi_wloxxmh->insertId();
            
                                General::logChange( $editor->db() , 'wloxxmh', $s_id_users, $s_username, 'CREATE', $id_wloxxmh, 'Insert from generate', $start_at, $finish_at );

                            }
                            
                        }
                    }
                }
            }

        });
    
    $json = $editor
        ->process( $_POST )
        ->data();

    // debugging hak akses
    $json['hakakses'] = $hakakses;

    echo json_encode( $json );


?>