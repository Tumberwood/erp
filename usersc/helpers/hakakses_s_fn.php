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

    $s_id_gcpxxmh = 0;  // Company
    $s_id_hemxxmh = 0;  // Company

    $s_id_gbrxxmh         = 0;    // Branch
    $s_arr_ha_gbrxxmh     = [0];
    $s_str_arr_ha_gbrxxmh = (0);

    $s_id_iwhxxmh         = 0;    // Branch
    $s_arr_ha_iwhxxmh     = [0];
    $s_str_arr_ha_iwhxxmh = (0);
    
    $s_id_hodxxmh         = 0;    // Department
    $s_arr_ha_hodxxmh     = [0];
    $s_str_arr_ha_hodxxmh = (0);

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
            // Jika Tim Ferry Ibnu
            $s_where_data_permission = 0;

            $hak_c = 1;
            $hak_u = 1;
            $hak_d = 1;
            $hak_a = 1;
            $hak_l = 1;
            $hak_e = 1;
            $hak_p = 1;

            // BEGIN gcpxxmh default
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
            // END gcpxxmh default

            // BEGIN gbrxxmh default
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
            // END gbrxxmh default

        }else{
            // Jika selain Tim Ferry Ibnu
            
            //Untuk mendapatkan id_hemxxmh, ditempatkan disini agar Semua akun bisa tahu id_hemxxmh nya berapa
            //Untuk keperluan testing admin juga.
            // BEGIN hemxxmh default
            $qs_hemxxmh = $db
            ->raw()
            ->bind(':transaction_state',1)
            ->bind(':s_id_users', $s_id_users)
            ->exec('
                SELECT
                    id as id_hemxxmh
                FROM hemxxmh
                WHERE 
                    transaction_state = :transaction_state AND
                    id_users = :s_id_users
            ');

        $rs_hemxxmh = $qs_hemxxmh->fetch();

        if(!empty($rs_hemxxmh)){
            if(!is_null($rs_hemxxmh['id_hemxxmh'])){
                $s_id_hemxxmh = $rs_hemxxmh['id_hemxxmh'];
            }
        } else {
            $s_id_hemxxmh = 0;
        }
        // END hemxxmh default
        
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
        
            if ( empty($rs_udpxxsh) ) {
                // belum dibuatkan hak akses
            }else{
                // sudah dibuatkan hak akses
                $s_where_data_permission = $rs_udpxxsh['data_permission'];

                // BEGIN data terkait  user
                $qs_hemjbmh = $db
                    ->raw()
                    ->bind(':s_id_users', $s_id_users)
                    ->bind(':transaction_state', -9)
                    ->exec('
                    	SELECT 
                    		a.id_gbrxxmh as id_gbrxxmh,
                    		a.id_hodxxmh as id_hodxxmh
                    	FROM hemjbmh a
                        LEFT JOIN hemxxmh b ON b.id = a.id_hemxxmh
                    	WHERE 
                    		b.transaction_state <> :transaction_state AND 
                    		b.id_users = :s_id_users
                    ');
                $rs_hemjbmh     = $qs_hemjbmh->fetch();
                if (!empty($rs_hemjbmh)) {
                    $s_id_gbrxxmh   = $rs_hemjbmh['id_gbrxxmh'];
                    $s_id_hodxxmh   = $rs_hemjbmh['id_hodxxmh'];
                }
                // END data terkait  user

                // BEGIN hak akses ucudasd
                $qs_ucudasd = $db
                    ->raw()
                    ->bind(':s_id_users', $s_id_users)
                    ->bind(':transaction_state', -9)
                    ->exec('
                    	SELECT 
                    		a.hak_c as hak_c,
                    		a.hak_u as hak_u,
                    		a.hak_d as hak_d,
                    		a.hak_a as hak_a,
                    		a.hak_l as hak_l,
                    		a.hak_e as hak_e,
                    		a.hak_p as hak_p
                    	FROM ucudasd a
                        LEFT JOIN udpxxsh b ON b.id = a.id_udpxxsh
                    	WHERE 
                    		b.transaction_state <> :transaction_state AND 
                    		b.id_users = :s_id_users AND 
                            a.transaction_state <> :transaction_state
                    ');
                $rs_ucudasd     = $qs_ucudasd->fetch();
                
                if ( empty($rs_ucudasd) ){
                    // jika belum ada hak akses ucudasd
                    // ikut default 0

                }else{
                    // jika sudah ada hak akses ucudasd
                    $hak_c = $rs_ucudasd['hak_c'];
                    $hak_u = $rs_ucudasd['hak_u'];
                    $hak_d = $rs_ucudasd['hak_d'];
                    $hak_a = $rs_ucudasd['hak_a'];
                    $hak_l = $rs_ucudasd['hak_l'];
                    $hak_e = $rs_ucudasd['hak_e'];
                    $hak_p = $rs_ucudasd['hak_p'];

                }
                // END hak akses ucudasd

                // BEGIN hak akses gbrxxmh
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
                // END hak akses gbrxxmh

                // BEGIN hak akses hodxxmh
                $qs_hodxxmh = $db
                    ->raw()
                    ->bind(':s_id_users', $s_id_users)
                    ->bind(':transaction_state', -9)
                    ->exec('
                    	SELECT 
                    		a.id_hodxxmh as id_hodxxmh
                    	FROM udpodsd a
                        LEFT JOIN udpxxsh b ON b.id = a.id_udpxxsh
                    	WHERE 
                    		b.transaction_state <> :transaction_state AND 
                    		b.id_users = :s_id_users AND 
                            a.transaction_state <> :transaction_state
                    ');
                $rs_hodxxmh     = $qs_hodxxmh->fetchAll();
                
                if ( empty($rs_hodxxmh) ){
                    // jika belum ada hak akses hodxxmh
                    $s_arr_ha_hodxxmh 		= [0];
                    $s_str_arr_ha_hodxxmh 	= (0);

                }else{
                    // jika sudah ada hak akses hodxxmh
                    $arr_ha_hodxxmh=array();

                    foreach ($rs_hodxxmh as $value) {	
                        array_push($arr_ha_hodxxmh, $value['id_hodxxmh']);
                    }

                    $s_arr_ha_hodxxmh 		= $arr_ha_hodxxmh;
                    $s_str_arr_ha_hodxxmh 	= implode(",",$s_arr_ha_hodxxmh);

                }
                // END hak akses hodxxmh

                // BEGIN hak akses iwhxxmh
                $qs_iwhxxmh = $db
                    ->raw()
                    ->bind(':s_id_users', $s_id_users)
                    ->bind(':transaction_state', -9)
                    ->exec('
                    	SELECT 
                    		a.id_iwhxxmh as id_iwhxxmh
                    	FROM udpwhsd a
                        LEFT JOIN udpxxsh b ON b.id = a.id_udpxxsh
                    	WHERE 
                    		b.transaction_state <> :transaction_state AND 
                    		b.id_users = :s_id_users AND 
                            a.transaction_state <> :transaction_state
                    ');
                $rs_iwhxxmh     = $qs_iwhxxmh->fetchAll();
                
                if ( empty($rs_iwhxxmh) ){
                    // jika belum ada hak akses iwhxxmh
                    $s_arr_ha_iwhxxmh 		= [0];
                    $s_str_arr_ha_iwhxxmh 	= (0);

                }else{
                    // jika sudah ada hak akses iwhxxmh
                    $arr_ha_iwhxxmh=array();

                    foreach ($rs_iwhxxmh as $value) {	
                        array_push($arr_ha_iwhxxmh, $value['id_iwhxxmh']);
                    }

                    $s_arr_ha_iwhxxmh 		= $arr_ha_iwhxxmh;
                    $s_str_arr_ha_iwhxxmh 	= implode(",",$s_arr_ha_iwhxxmh);

                }
                // END hak akses iwhxxmh
            }
        }
        
    }catch(PDOException $e){
		// rollback on error

	}

    $hakakses = array(
        's_id_users' => $s_id_users,
        's_username' => $s_username,
        
        's_where_data_permission' => $s_where_data_permission,
        
        'hak_c' => $hak_c,
        'hak_u' => $hak_u,
        'hak_d' => $hak_d,
        'hak_a' => $hak_a,
        'hak_l' => $hak_l,
        'hak_e' => $hak_e,
        'hak_p' => $hak_p,

        // BEGIN optional
        's_id_gcpxxmh'         => $s_id_gcpxxmh,
        's_id_hemxxmh'         => $s_id_hemxxmh,

        's_id_gbrxxmh'         => $s_id_gbrxxmh,
        's_arr_ha_gbrxxmh'     => $s_arr_ha_gbrxxmh,
        's_str_arr_ha_gbrxxmh' => $s_str_arr_ha_gbrxxmh,

        's_id_hodxxmh'         => $s_id_hodxxmh,
        's_arr_ha_hodxxmh'     => $s_arr_ha_hodxxmh,
        's_str_arr_ha_hodxxmh' => $s_str_arr_ha_hodxxmh,
        's_str_arr_ha_iwhxxmh' => $s_str_arr_ha_iwhxxmh,
        // END optional
    );
	
?>