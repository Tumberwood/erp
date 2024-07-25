<?php
    $editor
        ->on('postCreate',function( $editor, $id, $values, $row ) {
            // INSERT ke user extend
            $id_users = $id;

            // $user_permission_matches = $editor->db()
			// 	->query('insert', 'user_permission_matches')
			// 	->set('user_id',$id_users)
			// 	->set('permission_id', 1)
			// 	->exec();

            /* INSERT ucudasd sesuai hak akses pages yang sudah di assign ke user terpilih*/
            // select permission apa yang dimiliki oleh user terpilih
            $sql_select_user_permission_matches = $editor->db()
                ->query('select', 'user_permission_matches')
                ->get('permission_id as permission_id')
                ->where( 'user_id', $id_users)
                ->exec();
            $results_select_user_permission_matches = $sql_select_user_permission_matches->fetchAll();
            
            $arr_permission_id = array();
            foreach ($results_select_user_permission_matches as $row) {
                array_push($arr_permission_id,$row['permission_id']);
            }

            $sql_select_permission_page_matches = $editor->db()
                ->query('select', 'permission_page_matches')
                ->get('permission_page_matches.page_id as page_id')
                ->join('pages', 'pages.id=permission_page_matches.page_id','LEFT')
                ->join('pages_extend', 'pages_extend.id=pages.id','LEFT')
                ->where_in( ' permission_page_matches.permission_id', $arr_permission_id)
                ->where( 'pages_extend.is_crud', 1)
                ->where( 'pages_extend.is_setting', 0)
                ->exec();
            $results_select_permission_page_matches = $sql_select_permission_page_matches->fetchAll();

            foreach ($results_select_permission_page_matches as $row) {
                $sql_insert_ucudasd = $editor->db()
                    ->query('insert', 'ucudasd')
                    ->set('id_udpxxsh',$id)
                    ->set('id_users', $id_users)
                    ->set('id_pages', $row['page_id'])
                    ->exec();
            }
            
            $is_setting = $values['udpxxsh']['is_setting'];
            if($is_setting == 1){
                $sql_select_permission_page_matches_setting = $editor->db()
                    ->query('select', 'permission_page_matches')
                    ->get('permission_page_matches.page_id as page_id')
                    ->join('pages', 'pages.id=permission_page_matches.page_id','LEFT')
                    ->join('pages_extend', 'pages_extend.id=pages.id','LEFT')
                    ->where_in( ' permission_page_matches.permission_id', $arr_permission_id)
                    ->where( 'pages_extend.is_crud', 1)
                    ->where( 'pages_extend.is_setting', 1)
                    ->exec();
                $results_select_permission_page_matches_setting = $sql_select_permission_page_matches_setting->fetchAll();

                foreach ($results_select_permission_page_matches_setting as $row) {
                    $sql_insert_ucudasd = $editor->db()
                        ->query('insert', 'ucudasd')
                        ->set('id_udpxxsh',$id)
                        ->set('id_users', $id_users)
                        ->set('id_pages', $row['page_id'])
                        ->exec();
                }
            }

        });
   
?>