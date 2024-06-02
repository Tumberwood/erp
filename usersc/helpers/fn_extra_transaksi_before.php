<?php
	/**
	 * Digunakan untuk update data transaksi before
	 * Dipanggil dari models dengan cara
	 * include( "../../../helpers/fn_extra_transaksi_before.php" )
	 * 
	 * Terms:
	 * old		: data sebelum di create atau di edit 
	 * before	: transaksi sebelumnya
	 * 
	 * Parameter:
	 * 	$nama_table 		: nama table transaksi 				'prcittd';
	 * 	$nama_table_before	: nama table transaksi sebelumnya 	'podittd';
	 */

	function kalkulasi_jumlah_transaksi_before( $db, $id_table, &$values, $action, $nama_table, $nama_table_before ){
		// ambil nilai jumlah konversi berdasarkan id_iimxxmh dan id_iumxxmh
		$qs_iimummd = $db
			->query('select', 'iimummd' )
			->get([
				'iimummd.jumlah_konversi as jumlah_konversi'
			] )
			->where('iimummd.id_iimxxmh', $values[$nama_table]['id_iimxxmh'] )
			->where('iimummd.id_iumxxmh', $values[$nama_table]['id_iumxxmh_unit'] )
			->exec();
		$rs_iimummd = $qs_iimummd->fetch();
		$jumlah_konversi = $rs_iimummd['jumlah_konversi'];
		
		$qs_table_before_old = $db
			->query('select', $nama_table_before )
			->get([
				$nama_table_before.'.jumlah_unit as jumlah_unit_old',
				$nama_table_before.'.jumlah_unit_next as jumlah_unit_next_old',
				$nama_table_before.'.jumlah_unit_os as jumlah_unit_os_old',
				$nama_table_before.'.jumlah_terkecil as jumlah_terkecil_old',
				$nama_table_before.'.jumlah_terkecil_next as jumlah_terkecil_next_old',
				$nama_table_before.'.jumlah_terkecil_os as jumlah_terkecil_os_old'
			] )
			->where($nama_table_before.'.id', $values[$nama_table]['id_'.$nama_table_before] )
			->exec();
		$rs_table_before_old = $qs_table_before_old->fetch();
		
		if($action == 'Create'){
			$jumlah_unit_old = 0;
		}elseif($action == 'Edit'){
			$qs_table_old = $db
				->query('select', $nama_table )
				->get([
					$nama_table.'.jumlah_unit as jumlah_unit'
				] )
				->where($nama_table.'.id', $id_table )
				->exec();
			$rs_table_old = $qs_table_old->fetch();
			$jumlah_unit_old = $rs_table_old['jumlah_unit'];
		}elseif($action == 'Remove'){
			$jumlah_unit_old = 0;
		}

		$jumlah_unit_next_new     = $rs_table_before_old['jumlah_unit_next_old'] - $jumlah_unit_old + $values[$nama_table]['jumlah_unit'];
		$jumlah_unit_os_new       = $rs_table_before_old['jumlah_unit_old'] - $jumlah_unit_next_new;
		$jumlah_terkecil_next_new = $jumlah_unit_next_new * $jumlah_konversi;
		$jumlah_terkecil_os_new   = $jumlah_unit_os_new * $jumlah_konversi;

		$qu_table_before = $db
			->query('update', $nama_table_before)
			->set('jumlah_unit_next', $jumlah_unit_next_new )
			->set('jumlah_unit_os', $jumlah_unit_os_new)
			->set('jumlah_terkecil_next', $jumlah_terkecil_next_new)
			->set('jumlah_terkecil_os', $jumlah_terkecil_os_new)
			->where('id', $values[$nama_table]['id_'.$nama_table_before] )
			->exec();

	}

	$editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) use ($nama_table, $nama_table_before) {
			kalkulasi_jumlah_transaksi_before( $editor->db(), $id, $values, 'Create', $nama_table, $nama_table_before );
			
		})
		->on('preEdit',function( $editor, $id, $values ) use ($nama_table, $nama_table_before) {
			kalkulasi_jumlah_transaksi_before( $editor->db(), $id, $values, 'Edit', $nama_table, $nama_table_before );

		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});

?>