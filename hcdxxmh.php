
<?php
    require_once 'users/init.php';
    include_once( "usersc/lib/DataTables.php" );

	 $nama_tabel       = 'hcdxxmh';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'hcdfmmd';
    $nama_tabels_d[1] = 'hcdedmd';
    $nama_tabels_d[2] = 'hcdjbmd';
    $nama_tabels_d[3] = 'hcdogmd';
    $nama_tabels_d[4] = 'hcddhmd';
    $nama_tabels_d[5] = 'hcdecmd';
    $nama_tabels_d[6] = 'hcdtrmd';
    $nama_tabels_d[7] = 'hcdlgmd';
    $nama_tabels_d[8] = 'hcdrfmd';
?>

<!doctype html>
<html lang="en">
   <?php
      require_once($abs_us_root.$us_url_root.'users/includes/template/header1_must_include.php'); 
      require_once($abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/assets/fonts/glyphicons.php');
      require_once($abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/template_css_load.php');
      require_once($abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/template_css_datatables_load.php');
   ?>
   
  <style>
    .file-preview img {
      max-width: 200px;
      max-height: 200px;
    }

	.fields-info {
		color: blue;
		font-size: 9px;
    	font-weight: bold;
	}

  </style>
      <main>
         <div class="row" style="background-color: white">
            <div class="col">
               <div class="ibox ">
                  <div class="ibox-content">
                     <!-- start Custom Form Datatables Editor -->
                     <div class="container" style="min-height:550px">
                        <h1>Data Kandidat</h1>
                           <br>
                           <form id="myForm">
                           <!-- data-toggle="tab" -->
                           <ul class="nav nav-tabs" role="tablist">
                              <li class="nav-item" id="tab_personal">
                                 <a class="nav-link active" href="#tabpersonal">Personal Data</a>
                              </li>
                              <li class="nav-item" id="tab_sosmed">
                                 <a class="nav-link" href="#tabsosmed">Kontak & Sosmed</a>
                              </li>
                              <li class="nav-item" id="tab_dokumen">
                                 <a class="nav-link" href="#tabdokumen">Dokumen</a>
                              </li>
                              <li class="nav-item" id="tab_lain">
                                 <a class="nav-link" href="#tablain">Lain-lain</a>
                              </li>
                              <li class="nav-item" id="tab_keluarga"><a class="nav-link" href="#tabhcdfmmd"> Keluarga</a></li>
                              <li class="nav-item" id="tab_pendidikan"><a class="nav-link" href="#tabhcdedmd"> Pendidikan</a></li>
                              <li class="nav-item" id="tab_job"><a class="nav-link" href="#tabhcdjbmd"> Pekerjaan</a></li>
                              <li class="nav-item" id="tab_org"><a class="nav-link" href="#tabhcdogmd"> Organisasi</a></li>
                              <li class="nav-item" id="tab_sakit"><a class="nav-link" href="#tabhcddhmd"> Riwayat Penyakit</a></li>
                              <li class="nav-item" id="tab_kontak"><a class="nav-link" href="#tabhcdecmd"> Kontak Darurat</a></li>
                              <li class="nav-item" id="tab_pelatihan"><a class="nav-link" href="#tabhcdtrmd"> Pelatihan</a></li>
                              <li class="nav-item" id="tab_bahasa"><a class="nav-link" href="#tabhcdlgmd"> Bahasa</a></li>
                              <li class="nav-item" id="tab_referensi"><a class="nav-link" href="#tabhcdrfmd"> Referensi</a></li>
                           </ul>

                           <div class="tab-content">
                              <div id="tabpersonal" class="tab-pane fade show active">
                                 <br>
                                 <div class="row">
                                    <div class="form-group">
                                       <label for="id_hcd"></label>
                                       <input type="text" class="form-control" id="id_hcd" name="id_hcd" disabled>
                                    </div>
                                    <div class="col-md-5">
                                       <div class="form-group">
                                          <label for="hcdxxmh_nama">Nama Lengkap <sup class='text-danger'>*</sup></label>
                                          <input type="text" class="form-control" name="hcdxxmh.nama" id="hcdxxmh_nama" required>
                                       </div>
                                    </div>

                                          <!-- <div class="form-group">
                                          <label for="hcdxxmh_vaksin">Vaksin ke-</label>
                                          <input type="text" class="form-control" name="hcdxxmh.vaksin" id="hcdxxmh_vaksin">
                                          </div>  -->
                                    <div class="col-md-2">
                                       <div class="form-group">
                                          <label for="hcdxxmh_gender">Jenis Kelamin <sup class="text-danger">*</sup></label>
                                          <select class="form-control" name="hcdxxmh.gender" id="hcdxxmh_gender" placeholder="Select">
                                             <option value="">Select</option>
                                             <option value="Laki-laki">Laki-laki</option>
                                             <option value="Perempuan">Perempuan</option>
                                          </select>
                                       </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                       <div class="form-group">
                                          <label for="hcdxxmh_tanggal_lahir">Tanggal Lahir <sup class='text-danger'>*</sup></label>
                                          <div class="input-group input-daterange" id="periode">
                                             <input type="text" id="hcdxxmh_tanggal_lahir" class="form-control">
                                          </div>
                                          <!-- <input type="date" class="form-control" name="hcdxxmh.tanggal_lahir" id="hcdxxmh_tanggal_lahir" value="DD MMM YYYY" min="1900-01-01" required> -->
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="form-group">												
                                          <label>Tempat Lahir<sup class='text-danger'>*</sup></label>
                                          <select class="form-control select2" id="selectid_gctxxmh_lahir" name="selectid_gctxxmh_lahir"></select>
                                          <div class="invalid-feedback text-danger">Wajib diisi!</div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="hcdxxmh_agama">Agama<sup class='text-danger'>*</sup></label>
                                          <select class="form-control" name="hcdxxmh.agama" id="hcdxxmh_agama" placeholder="Select">
                                             <option value="">Select</option>
                                             <option value="Islam">Islam</option>
                                             <option value="Kristen">Kristen</option>
                                             <option value="Katolik">Katolik</option>
                                             <option value="Hindu">Hindu</option>
                                             <option value="Budha">Budha</option>
                                             <option value="Konghucu">Konghucu</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="hcdxxmh_perkawinan">Status Perkawinan<sup class='text-danger'>*</sup></label>
                                          <select class="form-control" name="hcdxxmh.perkawinan" id="hcdxxmh_perkawinan" placeholder="Select">
                                             <option value="">Select</option>
                                             <option value="Lajang">Lajang</option>
                                             <option value="Kawin">Kawin</option>
                                             <option value="Janda">Janda</option>
                                             <option value="Duda">Duda</option>
                                             <option value="Cerai">Cerai</option>
                                          </select>
                                       </div>
                                    </div>
                                    <!-- <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="hcdxxmh_suku">Suku Bangsa<sup class='text-danger'>*</sup></label>
                                          <input type="text" class="form-control" name="hcdxxmh.suku" id="hcdxxmh_suku">
                                       </div>
                                    </div> -->
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="hcdmdmh_gol_darah">Golongan Darah<sup class='text-danger'>*</sup></label>
                                          <select class="form-control" name="hcdmdmh.gol_darah" id="hcdmdmh_gol_darah">
                                             <option value="">Select</option>
                                             <option value="A">A</option>
                                             <option value="B">B</option>
                                             <option value="AB">AB</option>
                                             <option value="O">O</option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <!-- <div class="row">
                                    <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="hcdxxmh_berat">Berat Badan (kg)<sup class='text-danger'>*</sup></label>
                                          <input type="text" class="form-control" name="hcdxxmh.berat" id="hcdxxmh_berat">
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="hcdxxmh_tinggi">Tinggi Badan (cm)</label>
                                          <input type="text" class="form-control" name="hcdxxmh.tinggi" id="hcdxxmh_tinggi">
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="hcdxxmh_no_sepatu">No Sepatu</label>
                                          <input type="text" class="form-control" name="hcdxxmh.no_sepatu" id="hcdxxmh_no_sepatu">
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="hcdxxmh_ukuran_seragam">Ukuran Seragam</label>
                                          <select class="form-control" name="hcdxxmh.ukuran_seragam" id="hcdxxmh_ukuran_seragam">
                                             <option value="">Select</option>
                                             <option value="XS">XS</option>
                                             <option value="S">S</option>
                                             <option value="M">M</option>
                                             <option value="L">L</option>
                                             <option value="XL">XL</option>
                                             <option value="XXL">XXL</option>
                                             <option value="XXXL">XXXL</option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>	 -->
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="hcdxxmh_id_files_foto">Foto <sup class='text-danger'>*</sup></label>
                                          <input type="file" class="form-control-file" name="hcdxxmh_id_files_foto" id="hcdxxmh_id_files_foto"
                                          onchange="previewImage(this, 'hcdxxmh_id_files_foto_preview')" accept="image/*" required>
                                          <div class="file-preview">
                                             <img src="" alt="" id="hcdxxmh_id_files_foto_preview">
                                             <span class="no-file-text">Belum ada gambar</span>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="hcdxxmh_id_files_cv">CV <sup class='text-danger'>*</sup></label>
                                          <input type="file" class="form-control-file" name="hcdxxmh_id_files_cv" id="hcdxxmh_id_files_cv"
                                             onchange="previewFile(this, 'hcdxxmh_id_files_cv_preview')" accept=".jpg, .jpeg, .png, .pdf" required>
                                          <div class="file-preview">
                                             <img src="" alt="" id="hcdxxmh_id_files_cv_preview" style="display: none; max-height: 200px;">
                                             <iframe src="" frameborder="0" id="hcdxxmh_id_files_cv_preview_pdf" style="display: none; max-height: 200px;"></iframe>
                                             <span class="no-file-text">Belum ada file</span>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-9 col-lg-11">
                                    </div>
                                    <div class="col-3 col-lg-1">
                                       <button type="button" id="next_sosmed" class="btn btn-primary update_data">Next</button>
                                    </div>
                                 </div>
                              </div>

                              <div id="tabsosmed" class="tab-pane fade">
                                 <br>
                                 <!-- <div class="row">
                                    <div class="col-6">
                                       <div class="form-group">
                                          <label for="hcddcmh_asal_sekolah">Asal Sekolah<sup class="text-danger">*</sup></label>
                                          <input type="text" class="form-control" name="hcddcmh[asal_sekolah]" id="hcddcmh_asal_sekolah">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="hcddcmh_jurusan">Jurusan</label>
                                          <input type="text" class="form-control" name="hcddcmh[jurusan]" id="hcddcmh_jurusan">
                                       </div>
                                    </div>
                                 </div> -->
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="hcdcsmh_email_personal">Email Pribadi</label>
                                          <input type="email" class="form-control" name="hcdcsmh.email_personal" id="hcdcsmh_email_personal">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="hcdcsmh_twitter">Twitter</label>
                                          <input type="email" class="form-control" name="hcdcsmh.twitter" id="hcdcsmh_twitter">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="hcdcsmh_facebook">Facebook</label>
                                          <input type="email" class="form-control" name="hcdcsmh.facebook" id="hcdcsmh_facebook">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="hcdcsmh_linkedin">Linkedin</label>
                                          <input type="email" class="form-control" name="hcdcsmh.linkedin" id="hcdcsmh_linkedin">
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="hcdcsmh_instagram">Instagram</label>
                                          <input type="email" class="form-control" name="hcdcsmh.instagram" id="hcdcsmh_instagram">
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="hcdcsmh_tiktok">Tiktok</label>
                                          <input type="email" class="form-control" name="hcdcsmh.tiktok" id="hcdcsmh_tiktok">
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="hcdcsmh_whatsapp">No WhatsApp</label>
                                          <input type="text" class="form-control" name="hcdcsmh.whatsapp" id="hcdcsmh_whatsapp">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="hcdcsmh_handphone">No Handphone<sup class='text-danger'>*</sup></label>
                                          <input type="text" class="form-control" name="hcdcsmh.handphone" id="hcdcsmh_handphone">
                                       </div>
                                    </div>
                                    <div class="col-md-5">
                                       <div class="form-group">
                                          <label for="hcdcsmh_alamat_tinggal">Alamat Domisili<sup class='text-danger'>*</sup></label>
                                          <textarea class="form-control" name="hcdcsmh.alamat_tinggal" id="hcdcsmh_alamat_tinggal"></textarea>
                                          <p class="fields-info">Isi dengan Alamat Tinggal Sekarang <br> <br>
                                          Contoh: Perumahan Bumi Permai, Jalan Bengawan Solo 17, RT 09 RW 03, Kelurahan Kaliurang, Kecamatan Kebahagiaan, Kota Malang, Jawa Timur</p>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">												
                                          <label>Kota Domisili<sup class='text-danger'>*</sup></label>
                                          <select class="form-control select2" id="kota_tinggal" name="kota_tinggal"></select>
                                          <div class="invalid-feedback text-danger">Wajib diisi!</div>
                                       </div>
                                    </div>
                                 </div>
                                 <!-- <div class="row">
                                    <div class="col-md-1">
                                       <div class="form-group">
                                          <label for="rt">RT</label>
                                          <input type="text" class="form-control" name="rt" id="rt">
                                       </div>
                                    </div>
                                    <div class="col-md-1">
                                       <div class="form-group">
                                          <label for="rw">RW</label>
                                          <input type="text" class="form-control" name="rw" id="rw">
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="kelurahan">Kelurahan</label>
                                          <input type="text" class="form-control" name="kelurahan" id="kelurahan">
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="form-group">
                                          <label for="kecamatan">Kecamatan</label>
                                          <input type="text" class="form-control" name="kecamatan" id="kecamatan">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">												
                                          <label>Kota Tinggal</label>
                                          <select class="form-control" id="kota_tinggal" name="kota_tinggal"></select>
                                       </div>
                                    </div>
                                 </div> -->
                                 
                                 <div class="row">
                                    <div class="col-9 col-lg-11">
                                       <button type="button" id="back_personal" class="btn btn-primary update_data">Back</button>
                                    </div>
                                    <div class="col-3 col-lg-1">
                                       <button type="button" id="next_dokumen" class="btn btn-primary update_data">Next</button>
                                    </div>
                                 </div>
                              </div>

                              <div id="tabdokumen" class="tab-pane fade">
                                 <br>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="hcddcmh_ktp_no">No KTP<sup class="text-danger">*</sup></label>
                                          <input type="text" class="form-control" name="hcddcmh.ktp_no" id="hcddcmh_ktp_no">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="hcddcmh_ktp_alamat">Alamat KTP<sup class='text-danger'>*</sup></label>
                                          <textarea class="form-control" name="hcddcmh.ktp_alamat" id="hcddcmh_ktp_alamat"></textarea>
                                          <p class="fields-info">Isi dengan Alamat KTP dan Gunakan Format seperti mengisi Alamat Tinggal</p>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">												
                                          <label>Kota KTP<sup class='text-danger'>*</sup></label>
                                          <select class="form-control select2" id="kota_ktp" name="kota_ktp"></select>
                                          <div class="invalid-feedback text-danger">Wajib diisi!</div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="hcddcmh_sim_a">SIM A</label>
                                          <input type="text" class="form-control" name="hcddcmh.sim_a" id="hcddcmh_sim_a">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="hcddcmh_sim_b">SIM B</label>
                                          <input type="text" class="form-control" name="hcddcmh.sim_b" id="hcddcmh_sim_b">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="hcddcmh_sim_c">SIM C</label>
                                          <input type="text" class="form-control" name="hcddcmh.sim_c" id="hcddcmh_sim_c">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="hcddcmh_is_npwp">Ber-NPWP</label>
                                          <select class="form-control" name="hcddcmh.is_npwp" id="hcddcmh_is_npwp">
                                             <option value="">Select</option>
                                             <option value="1">Ya</option>
                                             <option value="2">Tidak</option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div id="npwp" style="display: none;">
                                    <div class="row">
                                       <div class="col-md-3">
                                          <div class="form-group">
                                             <label for="hcddcmh_npwp_no">No NPWP<sup class='text-danger'>*</sup></label>
                                             <input type="text" class="form-control" name="hcddcmh.npwp_no" id="hcddcmh_npwp_no">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="hcddcmh_npwp_alamat">Alamat NPWP<sup class='text-danger'>*</sup></label>
                                             <textarea class="form-control" name="hcddcmh.npwp_alamat" id="hcddcmh_npwp_alamat"></textarea>
                                             <p class="fields-info" style="color: blue; font-size: 7px; font-weight: bold;">Isi dengan Alamat NPWP dan Gunakan Format seperti mengisi Alamat Tinggal</p>
                                          </div>
                                       </div>
                                       <div class="col-md-3">
                                          <div class="form-group">
                                             <label>Kota NPWP<sup class='text-danger'>*</sup></label>
                                             <select class="form-control select2" id="hcddcmh_id_gctxxmh_npwp" name="hcddcmh_id_gctxxmh_npwp"></select>
                                             <div class="invalid-feedback text-danger">Wajib diisi!</div>
                                          </div>
                                       </div>
                                       <div class="col-md-2">
                                          <div class="form-group">
                                             <label>Status PTKP<sup class='text-danger'>*</sup></label>
                                             <select class="form-control select2" id="hcddcmh_id_gtxpkmh" name="hcddcmh_id_gtxpkmh"></select>
                                             <div class="invalid-feedback text-danger">Wajib diisi!</div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <!-- BELUM ADA DI MODELS -->
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="hcdjbmh_bpjskes_no">No BPJS Kesehatan</label>
                                          <input type="text" class="form-control" name="hcdjbmh.bpjskes_no" id="hcdjbmh_bpjskes_no">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="hcdjbmh_bpjstk_no">No BPJS Ketenagakerjaan</label>
                                          <input type="text" class="form-control" name="hcdjbmh.bpjstk_no" id="hcdjbmh_bpjstk_no">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="hcddcmh_id_files_ktp">Foto KTP</label>
                                          <input type="file" class="form-control-file" name="hcddcmh.id_files_ktp" id="hcddcmh_id_files_ktp"
                                             onchange="previewImage(this, 'hcddcmh_id_files_ktp_preview')">
                                          <div class="file-preview">
                                             <img src="" alt="" id="hcddcmh_id_files_ktp_preview">
                                             <span class="no-file-text">Belum ada gambar</span>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="hcddcmh_id_files_sim">Foto SIM </label>
                                          <input type="file" class="form-control-file" name="hcddcmh.id_files_sim" id="hcddcmh_id_files_sim"
                                             onchange="previewImage(this, 'hcddcmh_id_files_sim_preview')">
                                          <div class="file-preview">
                                             <img src="" alt="" id="hcddcmh_id_files_sim_preview">
                                             <span class="no-file-text">Belum ada gambar</span>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 
                                 <div class="row">
                                    <div class="col-9 col-lg-11">
                                       <button type="button" id="back_sosmed" class="btn btn-primary update_data">Back</button>
                                    </div>
                                    <div class="col-3 col-lg-1">
                                       <button type="button" id="next_lain" class="btn btn-primary update_data">Next</button>
                                    </div>
                                 </div>
                              </div>

                              <div id="tablain" class="tab-pane fade">
                                 <br>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="hcdjbmh_tempat_tinggal">Rumah Tempat Tinggal</label>
                                          <select class="form-control" name="hcdjbmh.tempat_tinggal" id="hcdjbmh_tempat_tinggal">
                                             <option value="">Select</option>
                                             <option value="Milik Sendiri">Milik Sendiri</option>
                                             <option value="Orang Tua">Orang Tua</option>
                                             <option value="Sewa/Kontrak">Sewa/Kontrak</option>
                                             <option value="Kost">Kost</option>
                                             <option value="Lain-lain">Lain-lain</option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="hcdjbmh_kendaraan">Kendaraan</label>
                                          <select class="form-control" name="hcdjbmh.kendaraan" id="hcdjbmh_kendaraan">
                                             <option value="">Select</option>
                                             <option value="Mobil">Mobil</option>
                                             <option value="Motor">Motor</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="hcdjbmh_kendaraan_milik">Kendaraan Milik</label>
                                          <select class="form-control" name="hcdjbmh.kendaraan_milik" id="hcdjbmh_kendaraan_milik">
                                             <option value="">Select</option>
                                             <option value="Sendiri">Sendiri</option>
                                             <option value="Orang Tua">Orang Tua</option>
                                             <option value="Suami/Istri">Suami/Istri</option>
                                             <option value="Kantor">Kantor</option>
                                             <option value="Lain-lain">Lain-lain</option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="hcdjbmh_intrv_self_1">Apakah anda pernah melamar di group perusahaan ini sebelumnya? Kapan dan sebagai apa?</label>
                                          <textarea class="form-control" name="hcdjbmh.intrv_self_1" id="hcdjbmh_intrv_self_1"></textarea>
                                          <p class="fields-info"> Contoh: YA, Pada Tanggal 10 Juli 2023 sebagai Junior Web Developer. <br>
                                                            Contoh: TIDAK, Saya tidak pernah melamar di group perusahaan ini.
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="hcdjbmh_intrv_self_2">Selain di perusahaan ini, di Perusahaan mana lagi anda melamar saat ini dan sebagai apa?</label>
                                          <textarea class="form-control" name="hcdjbmh.intrv_self_2" id="hcdjbmh_intrv_self_2"></textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="hcdjbmh_intrv_self_3">Apakah anda mempunyai pekerjaan sampingan? Jelaskan.</label>
                                          <textarea class="form-control" name="hcdjbmh.intrv_self_3" id="hcdjbmh_intrv_self_3"></textarea>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="hcdjbmh_intrv_self_4">Apakah anda mempunyai teman/keluarga yang bekerja di group perusahaan ini? Jelaskan.</label>
                                          <textarea class="form-control" name="hcdjbmh.intrv_self_4" id="hcdjbmh_intrv_self_4"></textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="hcdjbmh_intrv_self_5">Apakah anda pernah menderita sakit kronis / sakit keras / kecelakaan / operasi? Jelaskan.</label>
                                          <textarea class="form-control" name="hcdjbmh.intrv_self_5" id="hcdjbmh_intrv_self_5"></textarea>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="hcdjbmh_intrv_self_6">Apakah anda pernah berurusan dengan polisi karena tindak kejahatan?</label>
                                          <textarea class="form-control" name="hcdjbmh.intrv_self_6" id="hcdjbmh_intrv_self_6"></textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="hcdjbmh_intrv_self_7">Apakah anda bersedia bertugas keluar kota?</label>
                                          <textarea class="form-control" name="hcdjbmh.intrv_self_7" id="hcdjbmh_intrv_self_7"></textarea>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="hcdjbmh_intrv_self_8">Apakah anda bersedia ditempatkan keluar kota? Sebutkan nama kotanya</label>
                                          <textarea class="form-control" name="hcdjbmh.intrv_self_8" id="hcdjbmh_intrv_self_8"></textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="hcdjbmh_intrv_self_9">Jenis pekerjaan apa yang anda sukai?</label>
                                          <textarea class="form-control" name="hcdjbmh.intrv_self_9" id="hcdjbmh_intrv_self_9"></textarea>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="hcdjbmh_intrv_self_10">Jenis pekerjaan apa yang tidak anda suka?</label>
                                          <textarea class="form-control" name="hcdjbmh.intrv_self_10" id="hcdjbmh_intrv_self_10"></textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="hcdjbmh_intrv_self_11">Gaji yang diharapkan</label>
                                          <textarea class="form-control" name="hcdjbmh.intrv_self_11" id="hcdjbmh_intrv_self_11"></textarea>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="hcdjbmh_intrv_self_12">Fasilitas yang diharapkan</label>
                                          <textarea class="form-control" name="hcdjbmh.intrv_self_12" id="hcdjbmh_intrv_self_12"></textarea>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="hcdjbmh_intrv_self_13">Kapankah anda dapat mulai bekerja?</label>
                                          <textarea class="form-control" name="hcdjbmh.intrv_self_13" id="hcdjbmh_intrv_self_13"></textarea>
                                       </div>
                                    </div>
                                 </div>
                                 
                                 <div class="row">
                                    <div class="col-9 col-lg-11">
                                       <button type="button" id="back_dokumen" class="btn btn-primary update_data">Back</button>
                                    </div>
                                    <div class="col-3 col-lg-1">
                                       <button type="button" id="next_keluarga" class="btn btn-primary update_data">Next</button>
                                    </div>
                                 </div>
                              </div>
                              
                              
                              <div role="tabpanel" id="tabhcdfmmd" class="tab-pane">
                                 <div class="panel-body">
                                    <div class="table-responsive">
                                       <table id="tblhcdfmmd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                                          <thead>
                                             <tr>
                                                <th>ID</th>
                                                <th>id_hcdxxmh</th>
                                                <th>Hubungan</th>
                                                <th>Nama</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Tempat Lahir</th>
                                                <th>Tanggal Lahir</th>
                                                <th>Pendidikan Terakhir</th>
                                                <th>Pekerjaan</th>
                                             </tr>
                                          </thead>
                                       </table>
                                    </div> <!-- end of table -->
                                 </div>
                                 
                                 <div class="row">
                                    <div class="col-9 col-lg-11">
                                       <button type="button" id="back_lain" class="btn btn-primary update_data">Back</button>
                                    </div>
                                    <div class="col-3 col-lg-1">
                                       <button type="button" id="next_pendidikan" class="btn btn-primary update_data">Next</button>
                                    </div>
                                 </div>
                              </div>
                              <div role="tabpanel" id="tabhcdedmd" class="tab-pane">
                                 <div class="panel-body">
                                    <div class="table-responsive">
                                       <table id="tblhcdedmd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                                          <thead>
                                             <tr>
                                                <th>ID</th>
                                                <th>id_hcdxxmh</th>
                                                <th>Jenjang</th>
                                                <th>Nama</th>
                                                <th>Kota</th>
                                                <th>Tahun Lulus</th>
                                                <th>Jurusan</th>
                                                <th>Nilai Akhir</th>
                                             </tr>
                                          </thead>
                                       </table>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-9 col-lg-11">
                                       <button type="button" id="back_keluarga" class="btn btn-primary update_data">Back</button>
                                    </div>
                                    <div class="col-3 col-lg-1">
                                       <button type="button" id="next_job" class="btn btn-primary update_data">Next</button>
                                    </div>
                                 </div>
                              </div>
                              <div role="tabpanel" id="tabhcdjbmd" class="tab-pane">
                                 <div class="panel-body">
                                    <div class="table-responsive">
                                       <table id="tblhcdjbmd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                                          <thead>
                                             <tr>
                                                <th>ID</th>
                                                <th>id_hcdxxmh</th>
                                                <th>Perusahaan</th>
                                                <th>Jenis Usaha</th>
                                                <th>Alamat</th>
                                                <th>Kota</th>
                                                <th>Tanggal Awal</th>
                                                <th>Tanggal Akhir</th>
                                                <th>Jabatan Awal</th>
                                                <th>Jabatan Akhir</th>
                                                <th>Atasan Langsung</th>
                                                <th>Gaji Terakhir</th>
                                             </tr>
                                          </thead>
                                       </table>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-9 col-lg-11">
                                       <button type="button" id="back_pendidikan" class="btn btn-primary update_data">Back</button>
                                    </div>
                                    <div class="col-3 col-lg-1">
                                       <button type="button" id="next_org" class="btn btn-primary update_data">Next</button>
                                    </div>
                                 </div>
                              </div>
                              <div role="tabpanel" id="tabhcdogmd" class="tab-pane">
                                 <div class="panel-body">
                                    <div class="table-responsive">
                                       <table id="tblhcdogmd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                                          <thead>
                                             <tr>
                                                <th>ID</th>
                                                <th>id_hcdxxmh</th>
                                                <th>Nama</th>
                                                <th>Jenis Organisasi</th>
                                                <th>Tahun</th>
                                                <th>Jabatan</th>
                                             </tr>
                                          </thead>
                                       </table>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-9 col-lg-11">
                                       <button type="button" id="back_job" class="btn btn-primary update_data">Back</button>
                                    </div>
                                    <div class="col-3 col-lg-1">
                                       <button type="button" id="next_sakit" class="btn btn-primary update_data">Next</button>
                                    </div>
                                 </div>
                              </div>
                              <div role="tabpanel" id="tabhcddhmd" class="tab-pane">
                                 <div class="panel-body">
                                    <div class="table-responsive">
                                       <table id="tblhcddhmd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                                          <thead>
                                             <tr>
                                                <th>ID</th>
                                                <th>id_hcdxxmh</th>
                                                <th>Jenis Penyakit</th>
                                                <th>Tahun</th>
                                                <th>Berapa Lama</th>
                                                <th>Tempat Dirawat</th>
                                             </tr>
                                          </thead>
                                       </table>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-9 col-lg-11">
                                       <button type="button" id="back_org" class="btn btn-primary update_data">Back</button>
                                    </div>
                                    <div class="col-3 col-lg-1">
                                       <button type="button" id="next_kontak" class="btn btn-primary update_data">Next</button>
                                    </div>
                                 </div>
                              </div>
                              <div role="tabpanel" id="tabhcdecmd" class="tab-pane">
                                 <div class="panel-body">
                                    <div class="table-responsive">
                                       <table id="tblhcdecmd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                                          <thead>
                                             <tr>
                                                <th>ID</th>
                                                <th>id_hcdxxmh</th>
                                                <th>Nama</th>
                                                <th>Alamat</th>
                                                <th>No HP</th>
                                                <th>Hubungan</th>
                                             </tr>
                                          </thead>
                                       </table>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-9 col-lg-11">
                                       <button type="button" id="back_sakit" class="btn btn-primary update_data">Back</button>
                                    </div>
                                    <div class="col-3 col-lg-1">
                                       <button type="button" id="next_pelatihan" class="btn btn-primary update_data">Next</button>
                                    </div>
                                 </div>
                              </div> 
                              <div role="tabpanel" id="tabhcdtrmd" class="tab-pane">
                                 <div class="panel-body">
                                    <div class="table-responsive">
                                       <table id="tblhcdtrmd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                                          <thead>
                                             <tr>
                                                <th>ID</th>
                                                <th>id_hcdxxmh</th>
                                                <th>Nama</th>
                                                <th>Lembaga</th>
                                                <th>Bersertifikat</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Tanggal Selesai</th>
                                             </tr>
                                          </thead>
                                       </table>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-9 col-lg-11">
                                       <button type="button" id="back_kontak" class="btn btn-primary update_data">Back</button>
                                    </div>
                                    <div class="col-3 col-lg-1">
                                       <button type="button" id="next_bahasa" class="btn btn-primary update_data">Next</button>
                                    </div>
                                 </div>
                              </div>
                              <div role="tabpanel" id="tabhcdlgmd" class="tab-pane">
                                 <div class="panel-body">
                                    <div class="table-responsive">
                                       <table id="tblhcdlgmd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                                          <thead>
                                             <tr>
                                                <th>ID</th>
                                                <th>id_hcdxxmh</th>
                                                <th>Bahasa</th>
                                                <th>Membaca</th>
                                                <th>Mendengar</th>
                                                <th>Menulis</th>
                                                <th>Percakapan</th>
                                             </tr>
                                          </thead>
                                       </table>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-9 col-lg-11">
                                       <button type="button" id="back_pelatihan" class="btn btn-primary update_data">Back</button>
                                    </div>
                                    <div class="col-3 col-lg-1">
                                       <button type="button" id="next_referensi" class="btn btn-primary update_data">Next</button>
                                    </div>
                                 </div>
                              </div>
                              <div role="tabpanel" id="tabhcdrfmd" class="tab-pane">
                                 <div class="panel-body">
                                    <div class="table-responsive">
                                       <table id="tblhcdrfmd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                                          <thead>
                                             <tr>
                                                <th>ID</th>
                                                <th>id_hcdxxmh</th>
                                                <th>Nama</th>
                                                <th>Alamat</th>
                                                <th>Pekerjaan</th>
                                                <th>No HP</th>
                                                <th>Hubungan</th>
                                             </tr>
                                          </thead>
                                       </table>
                                    </div>
                                 </div>
                                 
                                 <div class="row">
                                    <div class="col-9 col-lg-11">
                                       <button type="button" id="back_bahasa" class="btn btn-primary update_data">Back</button>
                                    </div>
                                    <div class="col-3 col-lg-1">
                                       <button type="button" id="confirm" class="btn btn-warning">Confirm</button>
                                    </div>
                                 </div>
                              </div> 
                           </div>
                        </div>
                     </form>
                     <!-- <button type="button" id="confirm" class="btn btn-warning" style="display: none">Confirm</button> -->
                     </div>
                  </div>
               </div>
            </div>
         </div>

     </main>

<!-- BEGIN JS -->
<?php 
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php'; 
?>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hcdxxmh_self/fn/hcdxxmh_fn.php'; ?>

<script>
	// ------------- default variable, do not erase
	var edthcdxxmh, tblhcdxxmh, show_deleted_hcdxxmh = 0, id_hcdxxmh;
	var edthcdfmmd, tblhcdfmmd, show_deleted_hcdfmmd = 0, id_hcdfmmd;
	var edthcdedmd, tblhcdedmd, show_deleted_hcdedmd = 0, id_hcdedmd;
	var edthcdjbmd, tblhcdjbmd, show_deleted_hcdjbmd = 0, id_hcdjbmd;
	var edthcdogmd, tblhcdogmd, show_deleted_hcdogmd = 0, id_hcdogmd;
	var edthcddhmd, tblhcddhmd, show_deleted_hcddhmd = 0, id_hcddhmd;
	var edthcdecmd, tblhcdecmd, show_deleted_hcdecmd = 0, id_hcdecmd;
	var edthcdtrmd, tblhcdtrmd, show_deleted_hcdtrmd = 0, id_hcdtrmd;
	var edthcdlgmd, tblhcdlgmd, show_deleted_hcdlgmd = 0, id_hcdlgmd;
	var edthcdrfmd, tblhcdrfmd, show_deleted_hcdrfmd = 0, id_hcdrfmd;
	// ------------- end of default variable
   var id_gctxxmh_lahir_old = 0;
   id_gctxxmh_tinggal_old = 0;
   id_gctxxmh_lahir_fam_old = 0;
   id_gctxxmh_ktp_old = 0;
   id_gctxxmh_edu_old = 0;
   id_gctxxmh_job_old = 0;
   id_hetxxmh_old = 0;
   id_hedlvmh_fam_old = 0;
   id_hedlvmh_edu_old = 0;
   var id_hcdxxmh =  0;
   console.log('id_hcdxxmh awal = '+id_hcdxxmh);
   var now = new Date();
   console.log(now);

   $('#periode').datepicker({
		setDate: new Date(),
		autoclose: true,
		todayHighlight: true,
		clearBtn: true,
		format: "dd M yyyy",
		minViewMode: 'month' 
	});
	$('#hcdxxmh_tanggal_lahir').datepicker('setDate', moment().format('DD MMM YYYY'));

   var timestamp = Math.floor(now.getTime() / 1000);

   // Output the timestamp as an integer
   console.log(timestamp);
   id_hcdxxmh = timestamp;
		
	//hide id_hcd
	document.getElementById('id_hcd').style.display = 'none';

    function previewImage(input, previewId) {
		var preview = document.getElementById(previewId);
		var file = input.files[0];
		var reader = new FileReader();

		reader.onloadend = function () {
			preview.src = reader.result;
		}

		if (file) {
			var allowedFormats = ['jpg', 'jpeg', 'png']; // Supported photo formats

			var fileFormat = file.name.split('.').pop().toLowerCase();
			if (!allowedFormats.includes(fileFormat)) {
			alert("File harus berformat PNG, JPG, atau JPEG.");
			input.value = ""; // Reset the file input
			preview.src = "";
			preview.style.display = "none";
			preview.nextElementSibling.style.display = "block"; // Show the "Belum ada gambar" text
			return;
			}

			if (file.size <= 500 * 1024) { // Maximum file size: 500 KB
			reader.readAsDataURL(file);
			preview.style.display = "block";
			preview.nextElementSibling.style.display = "none"; // Hide the "Belum ada gambar" text
			} else {
			alert("Foto maksimal 500 KB.");
			input.value = ""; // Reset the file input
			preview.src = "";
			preview.style.display = "none";
			preview.nextElementSibling.style.display = "block"; // Show the "Belum ada gambar" text
			}
		} else {
			preview.src = "";
			preview.style.display = "none";
			preview.nextElementSibling.style.display = "block"; // Show the "Belum ada gambar" text
		}
	}

    function previewFile(input, previewId) {
		var preview = document.getElementById(previewId);
		var file = input.files[0];
		var reader = new FileReader();

		console.log(reader.result);

		reader.onloadend = function () {
			if (file.type === 'application/pdf') {
				$('#hcdxxmh_id_files_cv_preview_pdf').attr('src', reader.result);
				$('#hcdxxmh_id_files_cv_preview_pdf').css('display', 'block');
				$('#hcdxxmh_id_files_cv_preview').css('display', 'none');
				$('.no-file-text').css('display', 'none');
			} else {
				$('#hcdxxmh_id_files_cv_preview').attr('src', reader.result);
				$('#hcdxxmh_id_files_cv_preview').css('display', 'block');
				$('#hcdxxmh_id_files_cv_preview_pdf').css('display', 'none');
				$('.no-file-text').css('display', 'none');
			}
		};



		if (file) {
			var allowedFormats = ['jpg', 'jpeg', 'png', 'pdf'];
			var fileExtension = file.name.split('.').pop().toLowerCase();

			if (!allowedFormats.includes(fileExtension)) {
			alert('File harus berformat PNG, JPG, JPEG, atau PDF.');
			input.value = '';
			preview.src = '';
			preview.style.display = 'none';
			preview.nextElementSibling.style.display = 'block';
			return;
			}

			if (file.size <= 2000 * 1024) {
			reader.readAsDataURL(file);
			} else {
			alert('File maksimal 2 MB.');
			input.value = '';
			preview.src = '';
			preview.style.display = 'none';
			preview.nextElementSibling.style.display = 'block';
			}
		} else {
			preview.src = '';
			preview.style.display = 'none';
			preview.nextElementSibling.style.display = 'block';
		}
	}




	$(document).ready(function() {
      select2Kota($('#kota_tinggal'), 0);
      select2Kota($('#selectid_gctxxmh_lahir'), 0);
      select2Kota($('#kota_ktp'), 0);
      select2Kota($('#hcddcmh_id_gctxxmh_npwp'), 0);
      select2Ptkp($('#hcddcmh_id_gtxpkmh'), 0);

      $('#next_sosmed').click(function() {
         // Validasi
         var arr_personal = [
            $('#hcdxxmh_nama'),
            $('#hcdxxmh_gender'),
            $('#hcdxxmh_tanggal_lahir'),
            $('#selectid_gctxxmh_lahir'),
            $('#hcdxxmh_agama'),
            $('#hcdxxmh_perkawinan'),
            $('#hcdmdmh_gol_darah'),
            $('#hcdxxmh_id_files_foto'),
            $('#hcdxxmh_id_files_cv'),
         ];
         
         var is_next = 0;
         validasiInput(arr_personal, function(isValid) {
            if (isValid) {
               is_next = 1;
            }
         });

         // console.log(is_next);
         if (is_next == 1) {
            $('#tab_sosmed a').tab('show'); // If validation passes, show the tab
         }
      });
      
      //end validasi

      var is_next = 0;
      $('#next_dokumen').click(function() {

         //untuk validasi angka
         var arr_angka = [
            $('#hcdcsmh_handphone'),
         ];

         validasiInput(arr_angka, function(isValid) {
            if (isValid) {
               is_next = 1;
               // $('#tab_dokumen a').tab('show'); // If validation passes, show the tab
               // console.log(isValid);
            } else {
               is_next = 0;
            }
         }, 1);

         //untuk validasi required
         var arr_wajib = [
            $('#hcdcsmh_alamat_tinggal'),
            $('#kota_tinggal'),
         ];

         validasiInput(arr_wajib, function(isValid) {
            if (isValid) {
               if (is_next == 1) {
                  is_next = 2;
                  console.log('wkwkwk');
               }
               // console.log(isValid);
            }
         });
         
         console.log(is_next);
         //next = 2 karena ada 2 function yang berhasil di return atau 2 validasi
         if (is_next == 2) {
            $('#tab_dokumen a').tab('show'); // If validation passes, show the tab
            // console.log(1123);
         }
      });

      $('#next_lain').click(function() {
         
         //untuk validasi angka
         var arr_angka = [
            $('#hcddcmh_ktp_no'),
         ];

         validasiInput(arr_angka, function(isValid) {
            if (isValid) {
               is_next = 1;
            } else {
               is_next = 0;
            }
         }, 1);

         //untuk validasi required
         var arr_wajib = [
            $('#hcddcmh_ktp_alamat'),
            $('#kota_ktp'),
         ];

         validasiInput(arr_wajib, function(isValid) {
            if (isValid) {
               if (is_next == 1) {
                  is_next = 2;
                  console.log('wkwkwk');
               }
            }
         });

         hcddcmh_is_npwp = $('#hcddcmh_is_npwp').val();

         //jika ada npwp
         if (hcddcmh_is_npwp == 1) {
            //untuk validasi angka
            var arr_angka = [
               $('#hcddcmh_npwp_no'),
            ];

            validasiInput(arr_angka, function(isValid) {
               if (isValid) {
                  is_next = 3;
               } else {
                  is_next = 2;
               }
            }, 1);

            //untuk validasi required
            var arr_wajib = [
               $('#hcddcmh_npwp_alamat'),
               $('#hcddcmh_id_gctxxmh_npwp'),
               $('#hcddcmh_id_gtxpkmh'),
            ];

            validasiInput(arr_wajib, function(isValid) {
               if (isValid) {
                  if (is_next == 3) {
                     is_next = 4;
                  }
               }
            });

            if (is_next == 4) {
               $('#tab_lain a').tab('show'); // If validation passes, show the tab
            }
         } else {
            console.log(is_next);
            //next = 2 karena ada 2 function yang berhasil di return atau 2 validasi
            if (is_next == 2) {
               $('#tab_lain a').tab('show'); // If validation passes, show the tab
            }
         }

      });


      $('#next_pendidikan').click(function() {
         $('#tab_pendidikan a').tab('show');
      });

      $('#next_job').click(function() {
         $('#tab_job a').tab('show');
      });

      $('#next_org').click(function() {
         $('#tab_org a').tab('show');
      });

      $('#next_sakit').click(function() {
         $('#tab_sakit a').tab('show');
      });

      $('#next_kontak').click(function() {
         $('#tab_kontak a').tab('show');
      });

      $('#next_pelatihan').click(function() {
         $('#tab_pelatihan a').tab('show');
      });

      $('#next_bahasa').click(function() {
         $('#tab_bahasa a').tab('show');
      });

      $('#next_referensi').click(function() {
         $('#tab_referensi a').tab('show');
         // hcddcmh_ktp_no = $('#hcddcmh_ktp_no').val();
         // hcdxxmh_nama = $('#hcdxxmh_nama').val();
         // if (hcddcmh_ktp_no != '' && hcdxxmh_nama != '') {
               // $('#confirm').show();
         // }
      });

      /// Back button
      $('#back_personal').click(function() {
         $('#tab_personal a').tab('show');
      });

      $('#back_sosmed').click(function() {
         $('#tab_sosmed a').tab('show');
      });

      $('#back_dokumen').click(function() {
         $('#tab_dokumen a').tab('show');
      });

      $('#back_lain').click(function() {
         $('#tab_lain a').tab('show');
      });

      $('#back_keluarga').click(function() {
         $('#tab_keluarga a').tab('show');
      });

      createHeader();

      $('#back_pendidikan').click(function() {
         $('#tab_pendidikan a').tab('show');
      });

      $('#back_job').click(function() {
         $('#tab_job a').tab('show');
      });

      $('#back_org').click(function() {
         $('#tab_org a').tab('show');
      });

      $('#back_kontak').click(function() {
         $('#tab_kontak a').tab('show');
      });

      $('#back_sakit').click(function() {
         $('#tab_sakit a').tab('show');
      });

      $('#back_pelatihan').click(function() {
         $('#tab_pelatihan a').tab('show');
      });

      $('#back_bahasa').click(function() {
         $('#tab_bahasa a').tab('show');
      });

      $('#back_referensi').click(function() {
         $('#tab_referensi a').tab('show');
      });
      
      var familyData = family(id_hcdxxmh);
      var educationData = education(id_hcdxxmh);
      var jobsData = jobs(id_hcdxxmh);
      var organisasiData = organisasi(id_hcdxxmh);
      var penyakitData = penyakit(id_hcdxxmh);
      var kontakDaruratData = kontakDarurat(id_hcdxxmh);
      var pelatihanData = pelatihan(id_hcdxxmh);
      var bahasaData = bahasa(id_hcdxxmh);
      var referensiData = referensi(id_hcdxxmh);
      confirmData(id_hcdxxmh)
	});


</script>

  </body>
</html>