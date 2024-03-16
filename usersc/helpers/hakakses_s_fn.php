<?php
	/**
     * hemxxmh dan hemjbmh merupakan table core tambahan terkait hak akses
     * menghubungkan user dengan employee
     * data-data terkait hak akses, misal cabang, department jabatan, semua ada di hemjbmh
     */
	
    // gbrxxmh
    // $s_id_gbrxxmh
	// $s_arr_ha_gbrxxmh
	// $s_str_arr_ha_gbrxxmh

    // $s_where_data_permission

	// use
	// 	DataTables\Editor,
	// 	DataTables\Editor\Query,
	// 	DataTables\Editor\Result;

    $s_arr_ha_gbrxxmh = [0];
    $s_str_arr_ha_gbrxxmh = (0);
    $s_id_gcpxxmh = 0;
    $s_id_gbrxxmh = 0;

    try{
        $s_id_users = $user->data()->id;

        $qs_users = $db
            ->raw()
            ->bind(':s_id_users', $s_id_users)
            ->bind(':active', 1)
            ->exec('
                SELECT 
                    username
                FROM users
                WHERE 
                    id = :s_id_users AND
                    active = :active
            ');
        $rs_users = $qs_users->fetch();
        $s_username = $rs_users['username'];
        
        if($s_id_users < 101){

            // BEGIN gcpxxmh
            $qs_gcpxxmh = $db
                ->raw()
                ->bind(':transaction_state',1)
                ->bind(':is_default', 1)
                ->exec('
                    SELECT
                        id as id_gcpxxmh
                    FROM gcpxxmh
                    WHERE 
                        transaction_state = :transaction_state AND
                        is_default = :is_default
                ');

            $rs_gcpxxmh = $qs_gcpxxmh->fetch();

            if(!empty($rs_gcpxxmh)){
                if(!is_null($rs_gcpxxmh['id_gcpxxmh'])){
                    $s_id_gcpxxmh = $rs_gcpxxmh['id_gcpxxmh'];
                }
            }
            // END gcpxxmh

            // BEGIN gbrxxmh
            $qs_gbrxxmh = $db
                ->raw()
                ->bind(':transaction_state',1)
                ->bind(':is_default', 1)
                ->exec('
                    SELECT
                        id as id_gbrxxmh
                    FROM gbrxxmh
                    WHERE 
                        transaction_state = :transaction_state AND
                        is_default = :is_default
                ');

            $rs_gbrxxmh = $qs_gbrxxmh->fetch();

            if(!empty($rs_gbrxxmh)){
                if(!is_null($rs_gbrxxmh['id_gbrxxmh'])){
                    $s_id_gbrxxmh = $rs_gbrxxmh['id_gbrxxmh'];
                }
            }
            // END gbrxxmh

        }else{
            $qs_udpxxsh = $db
                ->raw()
                ->bind(':s_id_users', $s_id_users)
                ->exec('
                    SELECT 
                        a.id as id,
                        a.data_permission as data_permission,
                        b.username as username
                    FROM udpxxsh a
                    LEFT JOIN users b ON b.id = a.id_users
                    WHERE 
                        a.id_users = :s_id_users
                ');
            $rs_udpxxsh     = $qs_udpxxsh->fetch();

            $s_username = $rs_udpxxsh['username'];
        
            if ( empty($rs_udpxxsh) ) {
                // belum dibuatkan hak akses
            }else{
                // sudah dibuatkan hak akses
                $s_where_data_permission = $rs_udpxxsh['data_permission'];

                // cek hak akses data sesuai kebutuhan, misal:
                // ambil id_gbrxxmh dari users yang login
                $qs_hemjbmh = $db
                    ->raw()
                    ->bind(':s_id_users', $s_id_users)
                    ->bind(':transaction_state', -9)
                    ->exec('
                    	SELECT 
                    		a.id_gbrxxmh as id_gbrxxmh
                    	FROM hemjbmh a
                        LEFT JOIN hemxxmh b ON b.id = a.id_hemxxmh
                    	WHERE 
                    		b.transaction_state <> :transaction_state AND 
                    		a.id_users = :s_id_users
                    ');
                $rs_hemjbmh     = $qs_hemjbmh->fetch();
                $s_id_gbrxxmh   = $rs_hemjbmh['id_gbrxxmh'];

                // cek hak akses gbrxxmh
                $qs_gbrxxmh = $db
                    ->raw()
                    ->bind(':s_id_users', $s_id_users)
                    ->bind(':transaction_state', -9)
                    ->exec('
                    	SELECT 
                    		a.id_gbrxxmh as id_gbrxxmh
                    	FROM udpbrsd a
                        LEFT JOIN udpxxsh b ON b.id = a.id_udpxxsh
                    	WHERE 
                    		b.transaction_state <> :transaction_state AND 
                    		b.id_users = :s_id_users AND 
                            a.transaction_state <> :transaction_state
                    ');
                $rs_gbrxxmh     = $qs_gbrxxmh->fetchAll();
                
                if ( empty($rs_gbrxxmh) ){
                    // jika belum ada hak akses gbrxxmh
                    $s_arr_ha_gbrxxmh 		= [0];
                    $s_str_arr_ha_gbrxxmh 	= (0);

                }else{
                    // jika sudah ada hak akses gbrxxmh
                    $arr_ha_gbrxxmh=array();

                    foreach ($rs_gbrxxmh as $value) {	
                        array_push($arr_ha_gbrxxmh, $value['id_gbrxxmh']);
                    }

                    $s_arr_ha_gbrxxmh 		= $arr_ha_gbrxxmh;
                    $s_str_arr_ha_gbrxxmh 	= implode(",",$s_arr_ha_gbrxxmh);

                }
            }
        }
        
    }catch(PDOException $e){
		// rollback on error

	}

    $hakakses = array(
        's_id_users' => $s_id_users,
        's_username' => $s_username,

        // BEGIN optional
        's_id_gcpxxmh'         => $s_id_gcpxxmh,
        's_id_gbrxxmh'         => $s_id_gbrxxmh,
        's_arr_ha_gbrxxmh'     => $s_arr_ha_gbrxxmh,
        's_str_arr_ha_gbrxxmh' => $s_str_arr_ha_gbrxxmh
        // END optional
    );
	
?>