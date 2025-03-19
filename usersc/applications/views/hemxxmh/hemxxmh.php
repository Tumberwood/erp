<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel        = 'hemxxmh';
	$nama_tabels_d     = [];
	$nama_tabels_d[0]  = 'hemfmmd';
	$nama_tabels_d[1]  = 'hadxxtd';
	$nama_tabels_d[4]  = 'httlptd';
	$nama_tabels_d[5]  = 'hemtrmd';
	$nama_tabels_d[6]  = 'hesxxtd';
	$nama_tabels_d[7]  = 'hemjbrd';
	$nama_tabels_d[8]  = 'hemedmd';
	$nama_tabels_d[9]  = 'hemwrmd';
	$nama_tabels_d[10] = 'hemlgmd';
	$nama_tabels_d[11] = 'hacemtd';
	$nama_tabels_d[12] = 'kisemtd';
?>
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<!-- start Custom Form Datatables Editor -->
				<div id="frmhemxxmh">
					<div class="tabs-container">
						<ul class="nav nav-tabs" role="tablist">
							<li><a class="nav-link active" data-toggle="tab" href="#tabpersonaldata"> Personal Data</a></li>
							<li><a class="nav-link" data-toggle="tab" href="#tabpekerjaan"> Pekerjaan</a></li>
							<li><a class="nav-link" data-toggle="tab" href="#tabsosmed"> Kontak & SosMed</a></li>
							<li><a class="nav-link" data-toggle="tab" href="#tabdokumen"> Dokumen</a></li>
						</ul>
						<div class="tab-content">
							<div role="tabpanel" id= "tabpersonaldata" class="tab-pane active">
								<div class="panel-body">
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemxxmh.fname"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hemxxmh.lname"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemxxmh.nama"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hemxxmh.kode"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemxxmh.tanggal_lahir"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hemxxmh.id_gctxxmh_lahir"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemxxmh.agama"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hemxxmh.perkawinan"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemxxmh.gender"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hemxxmh.golongan_darah"></editor-field>
										</div>
									</div>
								</div>
							</div>
							<div role="tabpanel" id="tabpekerjaan" class="tab-pane">
								<div class="panel-body">
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemjbmh.id_gcpxxmh"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hemjbmh.id_gbrxxmh"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemjbmh.id_hovxxmh"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hemjbmh.id_hodxxmh"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemjbmh.id_hevxxmh"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hemjbmh.id_hetxxmh"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemjbmh.id_heyxxmh"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hemjbmh.id_hesxxmh"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemjbmh.tanggal_masuk"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hemjbmh.tanggal_keluar"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemjbmh.is_checkclock"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hemxxmh.id_files_foto"></editor-field>
										</div>
									</div>
								</div>
							</div>
							<div role="tabpanel" id="tabsosmed" class="tab-pane">
								<div class="panel-body">
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemcsmh.email_personal"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hemcsmh.whatsapp"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemcsmh.twitter"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hemcsmh.facebook"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemcsmh.linkedin"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hemcsmh.instagram"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemcsmh.tiktok"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hemcsmh.handphone"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemcsmh.alamat_tinggal"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hemcsmh.id_gctxxmh_tinggal"></editor-field>
										</div>
									</div>
								</div>
							</div>
							<div role="tabpanel" id= "tabdokumen" class="tab-pane">
								<div class="panel-body">
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemdcmh.ktp_no"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hemdcmh.ktp_alamat"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemdcmh.id_gctxxmh_ktp"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hemdcmh.sim_a"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemdcmh.sim_b"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hemdcmh.sim_c"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemdcmh.no_bpjs_tk"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hemdcmh.no_bpjs_kes"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemdcmh.is_npwp"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemdcmh.npwp_no"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hemdcmh.npwp_alamat"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemdcmh.id_gtxpkmh"></editor-field>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<editor-field name="hemxxmh.id_files_ktp"></editor-field>
										</div>
										<div class="col-lg-6">
											<editor-field name="hemxxmh.id_files_npwp"></editor-field>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- end Custom Form Datatables Editor -->
				<div class="table-responsive">
                    <table id="tblhemxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NIP</th>
                                <th>No KTP</th>
                                <th>Nama Depan</th>
                                <th>Nama Belakang</th>
                                <th>Level</th>
                                <th>Department</th>
                                <th>Jabatan</th>
                                <th>Status</th>
                                <th>Tanggal Masuk</th>
                            </tr>
                        </thead>
                    </table>
				</div>    
				
				<legend>Detail</legend>
				<div class="tabs-container">
					<ul class="nav nav-tabs" role="tablist">
						<li><a class="nav-link active" data-toggle="tab" href="#tabhemfmmd" data-i18n="family"></a></li>
						<li><a class="nav-link" data-toggle="tab" href="#tabhemedmd" data-i18n="formalEducation"></a></li>
						<li><a class="nav-link" data-toggle="tab" href="#tabhemwrmd" data-i18n="pastJobHistory"></a></li>
						<li><a class="nav-link" data-toggle="tab" href="#tabhemlgmd" data-i18n="language"></a></li>
						<li><a class="nav-link" data-toggle="tab" href="#tabhemtrmd" data-i18n="training"></a></li>
						<!-- <li><a class="nav-link" data-toggle="tab" href="#tabhesxxtd"> PKWT</a></li> -->
						<li><a class="nav-link" data-toggle="tab" href="#tabhemjbrd"> Job History</a></li>
						<li><a class="nav-link" data-toggle="tab" href="#tabhttlptd"> Leave & Permission</a></li>
						<li><a class="nav-link" data-toggle="tab" href="#tabhadxxtd "> Pelanggaran</a></li>
						<li><a class="nav-link" data-toggle="tab" href="#tabhacemtd">Medical Record</a></li>
						<li><a class="nav-link" data-toggle="tab" href="#tabkisemtd">Insiden Record</a></li>
					</ul>
					<div class="tab-content">
						<div role="tabpanel" id="tabhemfmmd" class="tab-pane active">
							<div class="panel-body">
								<div class="table-responsive">
									<table id="tblhemfmmd" class="table table-striped table-bordered table-hover nowrap" width="100%">
										<thead>
											<tr>
												<th>ID</th>
												<th>id_hemxxmh</th>
												<th data-i18n="relationship"></th>
												<th data-i18n="name"></th>
												<th data-i18n="gender"></th>
												<th data-i18n="dateOfBirth"></th>
												<th data-i18n="highestEducation"></th>
												<th data-i18n="job"></th>
											</tr>
										</thead>
									</table>
								</div> <!-- end of table -->

							</div>
						</div>
						<div role="tabpanel" id="tabhemedmd" class="tab-pane">
							<div class="panel-body">
								<div class="table-responsive">
									<table id="tblhemedmd" class="table table-striped table-bordered table-hover nowrap" width="100%">
										<thead>
											<tr>
												<th>ID</th>
												<th>id_hemxxmh</th>
												<th data-i18n="educationalLevel"></th>
												<th data-i18n="name"></th>
												<th data-i18n="startYear"></th>
												<th data-i18n="endYear"></th>
											</tr>
										</thead>
									</table>
								</div> <!-- end of table -->

							</div>
						</div>
						<div role="tabpanel" id="tabhemwrmd" class="tab-pane">
							<div class="panel-body">
								<div class="table-responsive">
									<div id="template_hemwrmd">
										<div class="panel-body">
											<div class="row">
												<div class="col-lg-6">
													<editor-field name="hemwrmd.perusahaan"></editor-field>
												</div>
												<div class="col-lg-6">
													<editor-field name="hemwrmd.jenis_usaha"></editor-field>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-6">
													<editor-field name="hemwrmd.alamat"></editor-field>
												</div>
												<div class="col-lg-6">
													<editor-field name="hemwrmd.id_gctxxmh"></editor-field>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-6">
													<editor-field name="hemwrmd.tanggal_masuk"></editor-field>
												</div>
												<div class="col-lg-6">
													<editor-field name="hemwrmd.tanggal_keluar"></editor-field>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-6">
													<editor-field name="hemwrmd.alasan_keluar"></editor-field>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-6">
													<editor-field name="hemwrmd.nama_atasan"></editor-field>
												</div>
												<div class="col-lg-6">
													<editor-field name="hemwrmd.jabatan_atasan"></editor-field>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-6">
													<editor-field name="hemwrmd.jabatan_awal"></editor-field>
												</div>
												<div class="col-lg-6">
													<editor-field name="hemwrmd.jabatan_akhir"></editor-field>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-6">
													<editor-field name="hemwrmd.gaji_terakhir"></editor-field>
												</div>
											</div>
										</div>
									</div>
									<table id="tblhemwrmd" class="table table-striped table-bordered table-hover nowrap" width="100%">
										<thead>
											<tr>
												<th>ID</th>
												<th>id_hemxxmh</th>
												<th data-i18n="companyName"></th> 
												<th data-i18n="typeOfBusiness"></th>
												<th data-i18n="cityName"></th>
												<th data-i18n="startDate"></th>
												<th data-i18n="endDate"></th>
											</tr>
										</thead>
									</table>
								</div> <!-- end of table -->

							</div>
						</div>
						<div role="tabpanel" id="tabhemlgmd" class="tab-pane">
							<div class="panel-body">
								<div class="table-responsive">
									<table id="tblhemlgmd" class="table table-striped table-bordered table-hover nowrap" width="100%">
										<thead>
											<tr>
												<th>ID</th>
												<th>id_hemxxmh</th>
												<th data-i18n="language"></th>
												<th data-i18n="reading"></th>
												<th data-i18n="listening"></th>
												<th data-i18n="writing"></th>
												<th data-i18n="conversation"></th>
											</tr>
										</thead>
									</table>
								</div> <!-- end of table -->

							</div>
						</div>
						<div role="tabpanel" id="tabhadxxtd" class="tab-pane">
							<div class="panel-body">
								<div class="table-responsive">
									<table id="tblhadxxtd" class="table table-striped table-bordered table-hover" width="100%">
										<thead>
											<tr>
												<th>ID</th>
												<th>id_hemxxmh</th>
												<th>Kode</th>
												<th>Jenis</th>
												<th>Pelanggaran</th>
												<th>Tanggal Berlaku</th>
												<th>Keterangan</th>
											</tr>
										</thead>
									</table>
								</div> <!-- end of table -->

							</div>
						</div>
						<div role="tabpanel" id="tabhttlptd" class="tab-pane">
							<div class="panel-body">
								<div class="table-responsive">
									<table id="tblhttlptd" class="table table-striped table-bordered table-hover nowrap" width="100%">
										<thead>
											<tr>
												<th>ID</th>
												<th>id_hemxxmh</th>
												<th>Tgl Awal</th>
												<th>Tgl Akhir</th>
												<th>Jam Awal</th>
												<th>Jam Akhir</th>
												<th>Doc No.</th>
												<th>Jenis</th>
												<th>Nama Izin/Cuti</th>
											</tr>
										</thead>
									</table>
								</div> 

							</div>
						</div>
						<div role="tabpanel" id="tabhemtrmd" class="tab-pane">
							<div class="panel-body">
								<div class="table-responsive">
									<table id="tblhemtrmd" class="table table-striped table-bordered table-hover nowrap" width="100%">
										<thead>
											<tr>
												<th>ID</th>
												<th>id_hemxxmh</th>
												<th>Nama Pelatihan</th>
												<th>Penyelenggara</th>
												<th>Tanggal Awal</th>
												<th>Tanggal Akhir</th>
											</tr>
										</thead>
									</table>
								</div> 

							</div>
						</div>
						<div role="tabpanel" id="tabhesxxtd" class="tab-pane">
							<div class="panel-body">
								<div class="table-responsive">
									<table id="tblhesxxtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
										<thead>
											<tr>
												<th>ID</th>
												<th>id_hemxxmh</th>
												<th>Status</th>
												<th>Tanggal Awal</th>
												<th>Tanggal Akhir</th>
												<th>No PKWT/TT</th>
											</tr>
										</thead>
									</table>
								</div> 

							</div>
						</div>
						<div role="tabpanel" id="tabhemjbrd" class="tab-pane">
							<div class="panel-body">
								<div class="table-responsive">
									<table id="tblhemjbrd" class="table table-striped table-bordered table-hover nowrap" width="100%">
										<thead>
											<tr>
												<th>ID</th>
												<th>id_hemxxmh</th>
												<th>Kode</th>
												<th>Status </th>
												<th>Jenis</th>
												<th>Tanggal Awal</th>
												<th>Tanggal Akhir</th>
												<th>Keterangan</th>
											</tr>
										</thead>
									</table>
								</div> <!-- end of table -->

							</div>
						</div>
						<div role="tabpanel" id="tabhacemtd" class="tab-pane">
							<div class="panel-body">
								<div class="table-responsive">
								<table id="tblhacemtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
									<thead>
										<tr>
											<th>ID</th>
											<th>id_hemxxmh</th>
											<th data-i18n="code"></th>
											<th data-i18n="date"></th>
											<th data-i18n="Med Exam Type"></th>
											<th data-i18n="employee"></th>
											<th data-i18n="state"></th>
										</tr>
									</thead>
								</table>
								</div> <!-- end of table -->
							</div>
						</div>
						<div role="tabpanel" id="tabkisemtd" class="tab-pane">
							<div class="panel-body">
								<div class="table-responsive">
								<table id="tblkisemtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
									<thead>
										<tr>
											<th>ID</th>
											<th>id_hemxxmh</th>
											<th data-i18n="code"></th>
											<th data-i18n="date"></th>
											<th data-i18n="Med Exam Type"></th>
											<th data-i18n="employee"></th>
											<th data-i18n="state"></th>
										</tr>
									</thead>
								</table>
								</div> <!-- end of table -->
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<?php
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_log.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_dt_fs.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_toast.php';
?>

<!-- BEGIN JS -->
<?php 
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_setup.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php'; 
?>

<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/validation_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hemxxmh/fn/hemxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthemxxmh, tblhemxxmh, show_deleted_hemxxmh = 0, id_hemxxmh;
	var edthemfmmd, tblhemfmmd, show_deleted_hemfmmd = 0, id_hemfmmd;
	var edthemedmd, tblhemedmd, show_deleted_hemedmd = 0, id_hemedmd;
	var edthemwrmd, tblhemwrmd, show_deleted_hemwrmd = 0, id_hemwrmd;
	var edthemlgmd, tblhemlgmd, show_deleted_hemlgmd = 0, id_hemlgmd;
	var edthadxxtd, tblhadxxtd, show_deleted_hadxxtd = 0, id_hadxxtd;
	var edthttlptd, tblhttlptd, show_deleted_httlptd = 0, id_httlptd;
	var edthemtrmd, tblhemtrmd, show_deleted_hemtrmd = 0, id_hemtrmd;
	var edthesxxtd, tblhesxxtd, show_deleted_hesxxtd = 0, id_hesxxtd;
	var edthemjbrd, tblhemjbrd, show_deleted_hemjbrd = 0, id_hemjbrd;
	var edthacemtd, tblhacemtd, show_deleted_hacemtd = 0, id_hacemtd;
	var edtkisemtd, tblkisemtd, show_deleted_kisemtd = 0, id_kisemtd;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('hemxxmh');
	
	var id_hovxxmh_old = 0, id_hodxxmh_old = 0, id_hosxxmh_old = 0, id_hetxxmh_old = 0, id_hevxxmh_old = 0, id_heyxxmh_old = 0, id_hesxxmh_old = 0;
	var id_hgnedmh_old = 0;
	var id_gtxpkmh_old = 0, id_gcpxxmh_old = 0, id_gbrxxmh_old = 0;
	var id_heyxxmd_old = 0, id_gctxxmh_tinggal_old = 0, id_gctxxmh_ktp_old = 0;
	var id_httlpmh_old = 0, id_hgnlgmh_old = 0, id_gctxxmh_lahir_old = 0;
	var id_hesxxmh_pkwt = 0, id_gctxxmh_hemedmd = 0, id_gctxxmh_hemwrmd = 0;

	$(document).ready(function() {

		//start datatables editor
		edthemxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hemxxmh/hemxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hemxxmh = show_deleted_hemxxmh;
				}
			},
			table: "#tblhemxxmh",
			template: "#frmhemxxmh",
			fields: [
				// field wajib
				{
					label: "hemxxmh.start_at",
					name: "hemxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "hemxxmh.finish_at",
					name: "hemxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hemxxmh",
					type: "hidden"
				},	
				{
					label: "hemxxmh.transaction_state",
					name: "hemxxmh.transaction_state",
					type: "hidden",
					def: 0
				},

				// tab Personal Data
				{
					label: "First Name <sup class='text-danger'>*<sup>",
					name: "hemxxmh.fname"
				}, 	
				{
					label: "Last Name <sup class='text-danger'>*<sup>",
					name: "hemxxmh.lname"
				}, 	
				{
					label: "Nama Lengkap",
					name: "hemxxmh.nama",
					type: "readonly"
				}, 	
				{
					label: "Tanggal Lahir <sup class='text-danger'>*<sup>",
					name: "hemxxmh.tanggal_lahir",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},	
				{
					label: "Tempat Lahir <sup class='text-danger'>*<sup>",
					name: "hemxxmh.id_gctxxmh_lahir",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/core/gctxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_gctxxmh_old: id_gctxxmh_lahir_old,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1,
						},
					}
				},
				{
					label: "Agama",
					name: "hemxxmh.agama",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Islam", "value": "Islam" },
						{ "label": "Kristen", "value": "Kristen" },
						{ "label": "Katolik", "value": "Katolik" },
						{ "label": "Hindu", "value": "Hindu" },
						{ "label": "Budha", "value": "Budha" },
						{ "label": "Konghucu", "value": "Konghucu" }
					]
				},
				{
					label: "Status Perkawinan",
					name: "hemxxmh.perkawinan",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Lajang", "value": "Lajang"},
						{ "label": "Kawin", "value": "Kawin"},
						{ "label": "Janda", "value": "Janda"},
						{ "label": "Duda", "value": "Duda"}
					]
				},
				{
					label: "Jenis Kelamin <sup class='text-danger'>*<sup>",
					name: "hemxxmh.gender",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Laki-laki", "value": "Laki-laki" },
						{ "label": "Perempuan", "value": "Perempuan" }
					]
				},
				{
					label: "Golongan Darah",
					name: "hemxxmh.golongan_darah",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "A", "value": "A" },
						{ "label": "B", "value": "B" },
						{ "label": "AB", "value": "AB" },
						{ "label": "O", "value": "O" }
					]
				},

				{
					label: "No KTP <sup class='text-danger'>*<sup>",
					name: "hemdcmh.ktp_no"
				}, 	
				{
					label: "Alamat KTP",
					name: "hemdcmh.ktp_alamat",
					type: "textarea"
				}, 	
				
				{
					label: "Foto KTP",
					name: "hemxxmh.id_files_ktp",
					type: "upload",
					display: function ( fileId, counter ) {
						if (fileId == 0){
							return 'Belum ada lampiran';
						}else{
							return '<a href="'+edthemxxmh.file( 'files', fileId ).web_path+'" target="_blank">'+ edthemxxmh.file( 'files', fileId ).filename + '</a>'; 
						}
					},
					noFileText: 'Belum ada gambar'
				},
				
				{
					label: "Foto Karyawan",
					name: "hemxxmh.id_files_foto",
					type: "upload",
					display: function ( fileId, counter ) {
						if (fileId == 0){
							return 'Belum ada lampiran';
						}else{
							return '<a href="'+edthemxxmh.file( 'files', fileId ).web_path+'" target="_blank">'+ edthemxxmh.file( 'files', fileId ).filename + '</a>'; 
						}
					},
					noFileText: 'Belum ada gambar'
				},
				
				{
					label: "Foto NPWP",
					name: "hemxxmh.id_files_npwp",
					type: "upload",
					display: function ( fileId, counter ) {
						if (fileId == 0){
							return 'Belum ada lampiran';
						}else{
							return '<a href="'+edthemxxmh.file( 'files', fileId ).web_path+'" target="_blank">'+ edthemxxmh.file( 'files', fileId ).filename + '</a>'; 
						}
					},
					noFileText: 'Belum ada gambar'
				},
				{
					label: "No BPJS TK <sup class='text-danger'>*<sup>",
					name: "hemdcmh.no_bpjs_tk"
				}, 	
				{
					label: "No BPJS Kesehatan <sup class='text-danger'>*<sup>",
					name: "hemdcmh.no_bpjs_kes"
				}, 
				{
					label: "Divisi <sup class='text-danger'>*<sup>",
					name: "hemjbmh.id_hovxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hovxxmh/hovxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hovxxmh: 0,
									id_hovxxmh_old: id_hovxxmh_old,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1,
						},
					}
				},
				{
					label: "Department <sup class='text-danger'>*<sup>",
					name: "hemjbmh.id_hodxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hodxxmh/hodxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hodxxmh: 0,
									id_hodxxmh_old: id_hodxxmh_old,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1,
						},
					}
				},
				{
					label: "Level",
					name: "hemjbmh.id_hevxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hevxxmh/hevxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hevxxmh: 0,
									id_hevxxmh_old: id_hevxxmh_old,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1,
						},
					}
				},
				{
					label: "Jabatan <sup class='text-danger'>*<sup>",
					name: "hemjbmh.id_hetxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hetxxmh/hetxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hetxxmh: 0,
									id_hetxxmh_old: id_hetxxmh_old,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1,
						},
					}
				},
				{
					label: "Status",
					name: "hemjbmh.id_hesxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hesxxmh/hesxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hesxxmh: 0,
									id_hesxxmh_old: id_hesxxmh_old,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1,
						},
					}
				},
				{
					label: "Type <sup class='text-danger'>*<sup>",
					name: "hemjbmh.id_heyxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/heyxxmh/heyxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_heyxxmh_old: id_heyxxmh_old,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1,
						},
					}
				},
				{
					label: "Company <sup class='text-danger'>*<sup>",
					name: "hemjbmh.id_gcpxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/core/gcpxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_gcpxxmh_old: id_gcpxxmh_old,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1,
						},
					}
				},
				{
					label: "Branch <sup class='text-danger'>*<sup>",
					name: "hemjbmh.id_gbrxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/core/gbrxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_gbrxxmh_old: id_gbrxxmh_old,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1,
						},
					}
				},
				{
					label: "Tanggal Masuk",
					name: "hemjbmh.tanggal_masuk",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					label: "Tanggal Keluar",
					name: "hemjbmh.tanggal_keluar",
					type: "datetime",
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					label: "Wajib Checkclock <sup class='text-danger'>*<sup>",
					name: "hemjbmh.is_checkclock",
					type: "select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Keterangan",
					name: "hemxxmh.keterangan",
					type: "textarea"
				},
				{
					label: "Status Aktif",
					name: "status_aktif",
					type: "select",
					options: [
						{ "label": "Aktif", "value": 1 },
						{ "label": "Non Aktif", "value": 0 }
					]
				},
				{
					label: "PTKP <sup class='text-danger'>*<sup>",
					name: "hemdcmh.id_gtxpkmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/gtxpkmh/gtxpkmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_gtxpkmh_old: id_gtxpkmh_old,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1,
						},
					}
				},
				{
					label: "NPWP <sup class='text-danger'>*<sup>",
					name: "hemdcmh.is_npwp",
					type: "select2",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "No NPWP <sup class='text-danger'>*<sup>" ,
					name: "hemdcmh.npwp_no"
				},
				{
					label: "Alamat NPWP <sup class='text-danger'>*<sup>" ,
					name: "hemdcmh.npwp_alamat",
					type: "textarea"
				},
				{
					label: "Email Pribadi <sup class='text-danger'>*<sup>",
					name: "hemcsmh.email_personal"
				}, 	
				{
					label: "No. WhatsApp<sup class='text-danger'>*<sup>",
					name: "hemcsmh.whatsapp"
				}, 	
				{
					label: "Twitter",
					name: "hemcsmh.twitter"
				}, 	
				{
					label: "Facebook",
					name: "hemcsmh.facebook"
				}, 	
				{
					label: "Linkedin",
					name: "hemcsmh.linkedin"
				}, 	
				{
					label: "Instagram",
					name: "hemcsmh.instagram"
				}, 	
				{
					label: "Tiktok",
					name: "hemcsmh.tiktok"
				}, 	
				{
					label: "No Handphone<sup class='text-danger'>*<sup>",
					name: "hemcsmh.handphone"
				}, 	
				{
					label: "Alamat Tinggal<sup class='text-danger'>*<sup>",
					name: "hemcsmh.alamat_tinggal",
					type: "textarea"
				}, 	
				{
					label: "Kota Tinggal",
					name: "hemcsmh.id_gctxxmh_tinggal",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/core/gctxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_gctxxmh_old: id_gctxxmh_tinggal_old,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1,
						},
					}
				},
				{
					label: "Kota KTP",
					name: "hemdcmh.id_gctxxmh_ktp",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/core/gctxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_gctxxmh_old: id_gctxxmh_ktp_old,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1,
						},
					}
				},
				{
					label: "SIM A",
					name: "hemdcmh.sim_a"
				},	
				{
					label: "SIM B",
					name: "hemdcmh.sim_b"
				},	
				{
					label: "SIM C",
					name: "hemdcmh.sim_c"
				},
				
				
			]
		} );
		
		edthemxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthemxxmh.field('hemxxmh.start_at').val(start_at);
			//cek_is_need_generate_kode
			cek_is_need_generate_kode('hemxxmh', edthemxxmh, 1);

			if(action == 'create'){
				tblhemxxmh.rows().deselect();

				edthemxxmh.field('hemjbmh.tanggal_keluar').disable();
				edthemxxmh.field('hemxxmh.fname').enable();
				edthemxxmh.field('hemxxmh.lname').enable();
				
			}else if(action == 'edit'){
				edthemxxmh.field('hemjbmh.tanggal_keluar').enable();
				
				if(transaction_state == 0){
					edthemxxmh.field('hemxxmh.fname').enable();
					edthemxxmh.field('hemxxmh.lname').enable();
				}else{
					edthemxxmh.field('hemxxmh.fname').disable();
					edthemxxmh.field('hemxxmh.lname').disable();	
				}
			}
		});

		edthemxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			
			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirmHD();
		});

		edthemxxmh.dependent( 'hemxxmh.fname', function ( val, data, callback ) {
			fname = edthemxxmh.field('hemxxmh.fname').val();
			lname = edthemxxmh.field('hemxxmh.lname').val();

			nama_lengkap = fname + " " + lname;
			edthemxxmh.field('hemxxmh.nama').val(nama_lengkap)
			return {}
		}, {event: 'keyup change'});

		edthemxxmh.dependent( 'hemxxmh.lname', function ( val, data, callback ) {
			fname = edthemxxmh.field('hemxxmh.fname').val();
			lname = edthemxxmh.field('hemxxmh.lname').val();

			nama_lengkap = fname + " " + lname;
			edthemxxmh.field('hemxxmh.nama').val(nama_lengkap)
			return {}
		}, {event: 'keyup change'});

		edthemxxmh.dependent( 'hemdcmh.is_npwp', function ( val, data, callback ) {
				if (val == 1) {
					edthemxxmh.field('hemdcmh.npwp_no').show();
					edthemxxmh.field('hemdcmh.npwp_alamat').show();
					edthemxxmh.field('hemdcmh.npwp_no').val();
					edthemxxmh.field('hemdcmh.npwp_alamat').val();
				} else {
					edthemxxmh.field('hemdcmh.npwp_no').hide();
					edthemxxmh.field('hemdcmh.npwp_alamat').hide();
					edthemxxmh.field('hemdcmh.npwp_no').val('');
					edthemxxmh.field('hemdcmh.npwp_alamat').val('');
				}
				return {}
			}, {event: 'keyup change'});
			
			edthemxxmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					// BEGIN of validasi hemxxmh.fname 
					fname = edthemxxmh.field('hemxxmh.fname').val();
					if(!fname || fname == ''){
						edthemxxmh.field('hemxxmh.fname').error( 'Wajib diisi!' );
					}
					// END of validasi hemxxmh.fname 

					// BEGIN of validasi hemxxmh.lname 
					lname = edthemxxmh.field('hemxxmh.lname').val();
					if(!lname || lname == ''){
						edthemxxmh.field('hemxxmh.lname').error( 'Wajib diisi!' );
					}
					// END of validasi hemxxmh.lname 
					
					// BEGIN of validasi hemjbmh.is_checkclock 
					is_checkclock = edthemxxmh.field('hemjbmh.is_checkclock').val();
					if(!is_checkclock || is_checkclock == ''){
						edthemxxmh.field('hemjbmh.is_checkclock').error( 'Wajib diisi!' );
					}
					// END of validasi hemjbmh.is_checkclock 
					
					// BEGIN of validasi hemjbmh.id_heyxxmh 
					id_heyxxmh = edthemxxmh.field('hemjbmh.id_heyxxmh').val();
					if(!id_heyxxmh || id_heyxxmh == ''){
						edthemxxmh.field('hemjbmh.id_heyxxmh').error( 'Wajib diisi!' );
					}
					// END of validasi hemjbmh.id_heyxxmh 
					
					// BEGIN of validasi hemjbmh.id_gcpxxmh 
					id_gcpxxmh = edthemxxmh.field('hemjbmh.id_gcpxxmh').val();
					if(!id_gcpxxmh || id_gcpxxmh == ''){
						edthemxxmh.field('hemjbmh.id_gcpxxmh').error( 'Wajib diisi!' );
					}
					// END of validasi hemjbmh.id_gcpxxmh 
					
					// BEGIN of validasi hemjbmh.id_gbrxxmh 
					id_gbrxxmh = edthemxxmh.field('hemjbmh.id_gbrxxmh').val();
					if(!id_gbrxxmh || id_gbrxxmh == ''){
						edthemxxmh.field('hemjbmh.id_gbrxxmh').error( 'Wajib diisi!' );
					}
					// END of validasi hemjbmh.id_gbrxxmh 

					// BEGIN of validasi hemdcmh.ktp_no 
					ktp_no = edthemxxmh.field('hemdcmh.ktp_no').val();
					if(!ktp_no || ktp_no == ''){
						edthemxxmh.field('hemdcmh.ktp_no').error( 'Wajib diisi!' );
					}
					// END of validasi hemxxmh.ktp_no  

					// BEGIN of validasi hemdcmh.id_gtxpkmh 
					id_gtxpkmh = edthemxxmh.field('hemdcmh.id_gtxpkmh').val();
					if(!id_gtxpkmh || id_gtxpkmh == ''){
						edthemxxmh.field('hemdcmh.id_gtxpkmh').error( 'Wajib diisi!' );
					}
					// END of validasi hemxxmh.id_gtxpkmh  

					// BEGIN of validasi hemdcmh.no_bpjs_kes 
					no_bpjs_kes = edthemxxmh.field('hemdcmh.no_bpjs_kes').val();
					if(!no_bpjs_kes || no_bpjs_kes == ''){
						edthemxxmh.field('hemdcmh.no_bpjs_kes').error( 'Wajib diisi!' );
					}
					// END of validasi hemxxmh.no_bpjs_kes 

					// BEGIN of validasi hemdcmh.no_bpjs_tk 
					no_bpjs_tk = edthemxxmh.field('hemdcmh.no_bpjs_tk').val();
					if(!no_bpjs_tk || no_bpjs_tk == ''){
						edthemxxmh.field('hemdcmh.no_bpjs_tk').error( 'Wajib diisi!' );
					}
					// END of validasi hemxxmh.no_bpjs_tk 

					// BEGIN of validasi hemjbmh.id_hovxxmh 
					id_hovxxmh = edthemxxmh.field('hemjbmh.id_hovxxmh').val();
					if(!id_hovxxmh || id_hovxxmh == ''){
						edthemxxmh.field('hemjbmh.id_hovxxmh').error( 'Wajib diisi!' );
					}
					// END of validasi hemjbmh.id_hovxxmh 

					// BEGIN of validasi hemjbmh.id_hodxxmh 
					id_hodxxmh = edthemxxmh.field('hemjbmh.id_hodxxmh').val();
					if(!id_hodxxmh || id_hodxxmh == ''){
						edthemxxmh.field('hemjbmh.id_hodxxmh').error( 'Wajib diisi!' );
					}
					// END of validasi hemjbmh.id_hodxxmh 

					// BEGIN of validasi hemjbmh.id_hetxxmh 
					id_hetxxmh = edthemxxmh.field('hemjbmh.id_hetxxmh').val();
					if(!id_hetxxmh || id_hetxxmh == ''){
						edthemxxmh.field('hemjbmh.id_hetxxmh').error( 'Wajib diisi!' );
					}
					// END of validasi hemjbmh.id_hetxxmh 

					is_npwp = edthemxxmh.field('hemdcmh.is_npwp').val();
					if(!is_npwp || is_npwp == ''){
						edthemxxmh.field('hemdcmh.is_npwp').error( 'Wajib diisi!' );
					}
					if (is_npwp == 1) {
						// BEGIN of validasi hemdcmh.npwp_no 
						npwp_no = edthemxxmh.field('hemdcmh.npwp_no').val();
						if(!npwp_no || npwp_no == ''){
							edthemxxmh.field('hemdcmh.npwp_no').error( 'Wajib diisi!' );
						}
							
						// END of validasi hemdcmh.npwp_alamat 
					}

					// BEGIN of validasi hemcsmh.email_personal 
					email_personal = edthemxxmh.field('hemcsmh.email_personal').val();
					if(!email_personal || email_personal == ''){
						edthemxxmh.field('hemcsmh.email_personal').error( 'Wajib diisi!' );
					}
					// END of validasi hemcsmh.email_personal 

					var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
					if (!emailRegex.test(email_personal)) {
						edthemxxmh.field('hemcsmh.email_personal').error('Format email tidak valid!');
					}

					// BEGIN of validasi hemcsmh.alamat_tinggal 
					alamat_tinggal = edthemxxmh.field('hemcsmh.alamat_tinggal').val();
					if(!alamat_tinggal || alamat_tinggal == ''){
						edthemxxmh.field('hemcsmh.alamat_tinggal').error( 'Wajib diisi!' );
					}
					// END of validasi hemxxmh.alamat_tinggal 

					// BEGIN of validasi hemcsmh.whatsapp 
					whatsapp = edthemxxmh.field('hemcsmh.whatsapp').val();
					if(!whatsapp || whatsapp == ''){
						edthemxxmh.field('hemcsmh.whatsapp').error( 'Wajib diisi!' );
					}
					// validasi min atau max angka
					if(whatsapp <= 0 ){
						edthemxxmh.field('hemcsmh.whatsapp').error( 'Inputan harus > 0' );
					}
					
					// validasi angka
					if(isNaN(whatsapp) ){
						edthemxxmh.field('hemcsmh.whatsapp').error( 'Inputan harus berupa Angka!' );
					}
					// END of validasi hemcsmh.whatsapp 

					// BEGIN of validasi hemcsmh.handphone 
					handphone = edthemxxmh.field('hemcsmh.handphone').val();
					if(!handphone || handphone == ''){
						edthemxxmh.field('hemcsmh.handphone').error( 'Wajib diisi!' );
					}
					// validasi min atau max angka
					if(handphone <= 0 ){
						edthemxxmh.field('hemcsmh.handphone').error( 'Inputan harus > 0' );
					}
					
					// validasi angka
					if(isNaN(handphone) ){
						edthemxxmh.field('hemcsmh.handphone').error( 'Inputan harus berupa Angka!' );
					}
					// END of validasi hemcsmh.handphone 

					// BEGIN of validasi hemxxmh.tanggal_lahir 
					tanggal_lahir = edthemxxmh.field('hemxxmh.tanggal_lahir').val();
					if(!tanggal_lahir || tanggal_lahir == ''){
						edthemxxmh.field('hemxxmh.tanggal_lahir').error( 'Wajib diisi!' );
					}
					// END of validasi hemxxmh.tanggal_lahir 

					// BEGIN of validasi hemxxmh.id_gctxxmh_lahir 
					id_gctxxmh_lahir = edthemxxmh.field('hemxxmh.id_gctxxmh_lahir').val();
					if(!id_gctxxmh_lahir || id_gctxxmh_lahir == ''){
						edthemxxmh.field('hemxxmh.id_gctxxmh_lahir').error( 'Wajib diisi!' );
					}
					// END of validasi hemxxmh.id_gctxxmh_lahir 

					// BEGIN of validasi hemxxmh.gender 
					jenis_kelamin = edthemxxmh.field('hemxxmh.gender').val();
					if(!jenis_kelamin || jenis_kelamin == ''){
						edthemxxmh.field('hemxxmh.gender').error( 'Wajib diisi!' );
					}
					// END of validasi hemxxmh.gender 
				}

				
				if ( edthemxxmh.inError() ) {
					return false;
				}
			});

		edthemxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthemxxmh.field('hemxxmh.finish_at').val(finish_at);
		});
		
		edthemxxmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblhemxxmh.ajax.reload(null,false);
		} );

		edthemxxmh.on( 'close', function () {
			edthemxxmh.enable();
		} );
		
		//start datatables
		tblhemxxmh = $('#tblhemxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-3',
			},
			ajax: {
				url: "../../models/hemxxmh/hemxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hemxxmh = show_deleted_hemxxmh;
				}
			},
			order: [[ 1, "asc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2,3]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: ['_all']
				}
			],
			columns: [
				{ data: "hemxxmh.id",visible:false },
				{ data: "hemxxmh.kode" },
				{ data: "hemdcmh.ktp_no" },
				{ data: "hemxxmh.fname" },
				{ data: "hemxxmh.lname" },
				{ data: "hevxxmh.nama" },
				{ data: "hodxxmh.nama" },
				{ data: "hetxxmh.nama" },
				{ data: "hesxxmh.nama" },
				{ data: "hemjbmh.tanggal_masuk" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hemxxmh';
					$table       = 'tblhemxxmh';
					$edt         = 'edthemxxmh';
					$show_status = '_hemxxmh';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.hemxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hemxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhemxxmh.searchPanes.container().appendTo('#sphemxxmh');
			tblhemxxmh.searchBuilder.container().appendTo( '#sbhemxxmh' );
		
		tblhemxxmh.on( 'init', function () {
			// atur hak akses
			tbl_details = [
				tblhemfmmd, tblhadxxtd
				, tblhttlptd
				, tblhemtrmd
				, tblhesxxtd
				, tblhemjbrd
				, tblhemedmd
				, tblhemwrmd
				, tblhemlgmd
				, tblhacemtd
				, tblkisemtd
			];
			CekInitHeaderHD(tblhemxxmh, tbl_details);
		} );
		
		tblhemxxmh.on( 'select', function( e, dt, type, indexes ) {
			hemxxmh_data    	= tblhemxxmh.row( { selected: true } ).data().hemxxmh;
			id_hemxxmh      	= hemxxmh_data.id;
			id_transaksi_h 		= id_hemxxmh; // dipakai untuk general
			id_transaksi_log	= id_hemxxmh; // dipakai untuk general
			transaction_state   = hemxxmh_data.transaction_state;
			approval_state   	= hemxxmh_data.approval_state;
			is_nextprocess 		= hemxxmh_data.is_nextprocess;
			id_gctxxmh_lahir_old 		= hemxxmh_data.id_gctxxmh_lahir;
			
			data_hemjbmh = tblhemxxmh.row( { selected: true } ).data().hemjbmh;
			id_hovxxmh_old   = data_hemjbmh.id_hovxxmh;
			id_hodxxmh_old   = data_hemjbmh.id_hodxxmh;
			id_hosxxmh_old   = data_hemjbmh.id_hosxxmh;
			id_hevxxmh_old   = data_hemjbmh.id_hevxxmh;
			id_hetxxmh_old   = data_hemjbmh.id_hetxxmh;
			id_heyxxmh_old   = data_hemjbmh.id_heyxxmh;
			id_gcpxxmh_old   = data_hemjbmh.id_gcpxxmh;
			id_gbrxxmh_old   = data_hemjbmh.id_gbrxxmh;
			id_heyxxmd_old   = data_hemjbmh.id_heyxxmd;
			id_hesxxmh_old   = data_hemjbmh.id_hesxxmh;

			data_hemdcmh = tblhemxxmh.row( { selected: true } ).data().hemdcmh;
			id_gtxpkmh_old   = data_hemdcmh.id_gtxpkmh;
			id_gctxxmh_ktp_old   = data_hemdcmh.id_gctxxmh_ktp;
			
			data_hemcsmh = tblhemxxmh.row( { selected: true } ).data().hemcsmh;
			id_gctxxmh_tinggal_old = data_hemcsmh.id_gctxxmh_tinggal;

			// atur hak akses
			tbl_details = [
				tblhemfmmd, tblhadxxtd
				, tblhttlptd
				, tblhemtrmd
				, tblhesxxtd
				, tblhemjbrd
				, tblhemedmd
				, tblhemwrmd
				, tblhemlgmd
				, tblhacemtd
				, tblkisemtd
			];
			CekSelectHeaderHD(tblhemxxmh, tbl_details);

			$('#sisa_cuti_text').empty();
			const tanggal = moment().format('YYYY-MM-DD');
			const year = moment().format('YYYY');

			// $.ajax( {
			// 	url: "../../models/htlxxth/fn_sisa_saldo_cuti.php",
			// 	dataType: 'json',
			// 	type: 'POST',
			// 	data: {
			// 		tanggal: tanggal,
			// 		id_hemxxmh: id_hemxxmh
			// 	},
			// 	success: function ( json ) {
			// 		saldo = json.data.rs_saldo.sisa_saldo;
			// 		$('#sisa_cuti_text').html('Sisa Cuti '+ year + ' : ' +saldo);
			// 	}
			// } );
		} );
		
		tblhemxxmh.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_hemxxmh = 0, id_gctxxmh_old = 0, id_gbuxxmh_old = 0, id_gpvxxmh_old = 0, id_gctxxmh_ktp_old = 0, id_gctxxmh_tinggal_old = 0, id_gctxxmh_lahir_old=0;
			id_heyxxmh_old = 0;
			id_gcpxxmh_old = 0;
			id_gbrxxmh_old = 0;

			// atur hak akses
			tbl_details = [
				tblhemfmmd, tblhadxxtd
				, tblhttlptd
				, tblhemtrmd
				, tblhesxxtd
				, tblhemjbrd
				, tblhemedmd
				, tblhemwrmd
				, tblhemlgmd
				, tblhacemtd
				, tblkisemtd
			];
			CekDeselectHeaderHD(tblhemxxmh, tbl_details);
			$('#sisa_cuti_text').empty();
		} );
		
// --------- start _detail --------------- //

		//start datatables editor
		edthemfmmd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hemxxmh/hemfmmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hemfmmd = show_deleted_hemfmmd;
					d.id_hemxxmh = id_hemxxmh;
				}
			},
			table: "#tblhemfmmd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "hemfmmd.start_at",
					name: "hemfmmd.start_at",
					type: "hidden"
				},	
				{
					label: "hemfmmd.finish_at",
					name: "hemfmmd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hemfmmd",
					type: "hidden"
				},	
				{
					label: "hemfmmd.transaction_state",
					name: "hemfmmd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_hemxxmh",
					name: "hemfmmd.id_hemxxmh",
					type: "hidden"
				},	
				{
					label: "Hubungan <sup class='text-danger'>*<sup>",
					name: "hemfmmd.hubungan",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Ayah", "value": "Ayah" },
						{ "label": "Ibu", "value": "Ibu" },
						{ "label": "Kakak", "value": "Kakak" },
						{ "label": "Adik", "value": "Adik" },
						{ "label": "Suami", "value": "Suami" },
						{ "label": "Istri", "value": "Istri" },
						{ "label": "Anak", "value": "Anak" },
					]
				},	{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "hemfmmd.nama"
				},	{
					label: "Gender <sup class='text-danger'>*<sup>",
					name: "hemfmmd.gender",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Laki-laki", "value": "Laki-laki" },
						{ "label": "Perempuan", "value": "Perempuan" }
					]
				}, 	{
					label: "Tanggal Lahir <sup class='text-danger'>*<sup>",
					name: "hemfmmd.tanggal_lahir",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},	{
					label: "Pendidikan Terakhir",
					name: "hemfmmd.id_hgnedmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hgnedmh/hgnedmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hgnedmh_old: id_hgnedmh_old,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1,
						},
					}
				},	{
					label: "Pekerjaan <sup class='text-danger'>*<sup>",
					name: "hemfmmd.pekerjaan"
				}
			]
		} );
			
		edthemfmmd.on( 'preOpen', function( e, mode, action ) {
			edthemfmmd.field('hemfmmd.id_hemxxmh').val(id_hemxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthemfmmd.field('hemfmmd.start_at').val(start_at);
			
			if(action == 'create'){
				tblhemfmmd.rows().deselect();
			}
		});

		edthemfmmd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthemfmmd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				tanggal_lahir = edthemfmmd.field('hemfmmd.tanggal_lahir').val();
				nama       = edthemfmmd.field('hemfmmd.nama').val();
				gender     = edthemfmmd.field('hemfmmd.gender').val();
				hubungan     = edthemfmmd.field('hemfmmd.hubungan').val();
				pekerjaan     = edthemfmmd.field('hemfmmd.pekerjaan').val();

				validasiRequired(
					edthemfmmd,
					'hemfmmd',
					{
						'tanggal_lahir': tanggal_lahir,
						'nama'      : nama,
						'gender'    : gender,
						'pekerjaan'    : pekerjaan,
						'hubungan'    : hubungan,
					}
				);
			}
			
			if ( edthemfmmd.inError() ) {
				return false;
			}
		});

		edthemfmmd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthemfmmd.field('hemfmmd.finish_at').val(finish_at);
		});
			
		edthemfmmd.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblhemfmmd.rows().deselect();
			tblhemfmmd.ajax.reload(null, false);
		} );

		edthemfmmd.on( 'close', function () {
			edthemfmmd.enable();
		} );
		
		//start datatables
		tblhemfmmd = $('#tblhemfmmd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-2',
			},
			ajax: {
				url: "../../models/hemxxmh/hemfmmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hemfmmd = show_deleted_hemfmmd;
					d.id_hemxxmh = id_hemxxmh;
				}
			},
			order: [[ 2, "desc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [2,3]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0,1,4,5]
				}
			],
			responsive: false,
			// scrollX: true,
			columns: [
				{ data: "hemfmmd.id",visible:false },
				{ data: "hemfmmd.id_hemxxmh",visible:false },
				{ data: "hemfmmd.hubungan" },
				{ data: "hemfmmd.nama" },
				{ data: "hemfmmd.gender" },
				{ data: "hemfmmd.tanggal_lahir" },
				{ data: "hgnedmh.nama" },
				{ data: "hemfmmd.pekerjaan" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hemfmmd';
					$table       = 'tblhemfmmd';
					$edt         = 'edthemfmmd';
					$show_status = '_hemfmmd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log_d','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			}
		} );

		tblhemfmmd.searchPanes.container().appendTo('#sphemfmmd');
		tblhemfmmd.searchBuilder.container().appendTo( '#sbhemfmmd' );

		tblhemfmmd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD(tblhemfmmd, 0 );
			CekDrawDetailHDFinal(tblhemxxmh);
		} );

		tblhemfmmd.on( 'select', function( e, dt, type, indexes ) {
			data_hemfmmd 		= tblhemfmmd.row( { selected: true } ).data().hemfmmd;
			id_hemfmmd   		= data_hemfmmd.id;
			id_transaksi_d 		= id_hemfmmd; // dipakai untuk general
			id_transaksi_log_d  = id_hemfmmd; // dipakai untuk log

			transaction_state_d   = data_hemfmmd.transaction_state;
			id_hgnedmh_old   = data_hemfmmd.id_hgnedmh;
			// atur hak akses
			CekSelectDetailHD(tblhemxxmh, tblhemfmmd );
		} );

		tblhemfmmd.on( 'deselect', function() {
			id_hemfmmd = 0;
			id_hgnedmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblhemxxmh, tblhemfmmd );
		} );

// --------- end _detail --------------- //		

// --------- start _detail --------------- // hemedmd

		//start datatables editor
		edthemedmd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hemxxmh/hemedmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hemedmd = show_deleted_hemedmd;
					d.id_hemxxmh = id_hemxxmh;
				}
			},
			table: "#tblhemedmd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "hemedmd.start_at",
					name: "hemedmd.start_at",
					type: "hidden"
				},	
				{
					label: "hemedmd.finish_at",
					name: "hemedmd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hemedmd",
					type: "hidden"
				},	
				{
					label: "hemedmd.transaction_state",
					name: "hemedmd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_hemxxmh",
					name: "hemedmd.id_hemxxmh",
					type: "hidden"
				},	
				{
					label: "Jenjang Pendidikan",
					name: "hemedmd.id_hgnedmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hgnedmh/hgnedmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hgnedmh_old: id_hgnedmh_old,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1,
						},
					}
				},	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "hemedmd.nama"
				},
				{
					label: "Kota <sup class='text-danger'>*<sup>",
					name: "hemedmd.id_gctxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/core/gctxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_gctxxmh_old: id_gctxxmh_hemedmd,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1,
						},
					}
				},
				{
					label: "Tahun Awal <sup class='text-danger'>*<sup>",
					name: "hemedmd.tahun_awal",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'YYYY'
				},	
				{
					label: "Tahun Akhir <sup class='text-danger'>*<sup>",
					name: "hemedmd.tahun_akhir",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'YYYY'
				},	
				{
					label: "Jurusan",
					name: "hemedmd.jurusan"
				},
				{
					label: "Nilai Akhir",
					name: "hemedmd.nilai_akhir"
				}
			]
		} );
			
		edthemedmd.on( 'preOpen', function( e, mode, action ) {
			edthemedmd.field('hemedmd.id_hemxxmh').val(id_hemxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthemedmd.field('hemedmd.start_at').val(start_at);
			
			if(action == 'create'){
				tblhemedmd.rows().deselect();
			}
		});

		edthemedmd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthemedmd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				id_gctxxmh = edthemedmd.field('hemedmd.id_gctxxmh').val();
				nama       = edthemedmd.field('hemedmd.nama').val();
				tahun_awal     = edthemedmd.field('hemedmd.tahun_awal').val();
				tahun_akhir     = edthemedmd.field('hemedmd.tahun_akhir').val();
				id_hgnedmh     = edthemedmd.field('hemedmd.id_hgnedmh').val();

				validasiRequired(
					edthemedmd,
					'hemedmd',
					{
						'id_gctxxmh': id_gctxxmh,
						'nama'      : nama,
						'tahun_awal'    : tahun_awal,
						'id_hgnedmh'    : id_hgnedmh,
						'tahun_akhir'    : tahun_akhir,
					}
				);

				if (tahun_awal > tahun_akhir) {
					edthemedmd.field('hemedmd.tahun_awal').error( 'Tahun Awal harus lebih kecil dari Tahun Akhir!' );
				}
			}
			
			if ( edthemedmd.inError() ) {
				return false;
			}
		});

		edthemedmd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthemedmd.field('hemedmd.finish_at').val(finish_at);
		});
			
		edthemedmd.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblhemedmd.rows().deselect();
			tblhemedmd.ajax.reload(null, false);
		} );

		edthemedmd.on( 'close', function () {
			edthemedmd.enable();
		} );
		
		//start datatables
		tblhemedmd = $('#tblhemedmd').DataTable( {
			dom: dom0,
			ajax: {
				url: "../../models/hemxxmh/hemedmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hemedmd = show_deleted_hemedmd;
					d.id_hemxxmh = id_hemxxmh;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "hemedmd.id",visible:false },
				{ data: "hemedmd.id_hemxxmh",visible:false },
				{ data: "hgnedmh.nama" },
				{ data: "hemedmd.nama" },
				{ data: "hemedmd.tahun_awal" },
				{ data: "hemedmd.tahun_akhir" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hemedmd';
					$table       = 'tblhemedmd';
					$edt         = 'edthemedmd';
					$show_status = '_hemedmd';
					$table_name  = $nama_tabels_d[8];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log_d','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
			}
		} );

		tblhemedmd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD(tblhemedmd, 0 );
			CekDrawDetailHDFinal(tblhemxxmh);
		} );

		tblhemedmd.on( 'select', function( e, dt, type, indexes ) {
			data_hemedmd 		= tblhemedmd.row( { selected: true } ).data().hemedmd;
			id_hemedmd   		= data_hemedmd.id;
			id_transaksi_d 		= id_hemedmd; // dipakai untuk general
			id_transaksi_log_d  = id_hemedmd; // dipakai untuk log

			transaction_state_d   = data_hemedmd.transaction_state;
			id_hgnedmh_old   = data_hemedmd.id_hgnedmh;
			id_gctxxmh_hemedmd   = data_hemedmd.id_gctxxmh;
			// atur hak akses
			CekSelectDetailHD(tblhemxxmh, tblhemedmd );
		} );

		tblhemedmd.on( 'deselect', function() {
			id_hemedmd = 0;
			id_hgnedmh_old = 0;
			id_gctxxmh_hemedmd = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblhemxxmh, tblhemedmd );
		} );

// --------- end _detail --------------- //	

// --------- start _detail --------------- // hemwrmd

		//start datatables editor
		edthemwrmd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hemxxmh/hemwrmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hemwrmd = show_deleted_hemwrmd;
					d.id_hemxxmh = id_hemxxmh;
				}
			},
			template: "#template_hemwrmd",
			table: "#tblhemwrmd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "hemwrmd.start_at",
					name: "hemwrmd.start_at",
					type: "hidden"
				},	
				{
					label: "hemwrmd.finish_at",
					name: "hemwrmd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hemwrmd",
					type: "hidden"
				},	
				{
					label: "hemwrmd.transaction_state",
					name: "hemwrmd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_hemxxmh",
					name: "hemwrmd.id_hemxxmh",
					type: "hidden"
				},	
				{
					label: "Perusahaan <sup class='text-danger'>*<sup>",
					name: "hemwrmd.perusahaan"
				},
				{
					label: "Jenis Usaha <sup class='text-danger'>*<sup>",
					name: "hemwrmd.jenis_usaha"
				},
				{
					label: "Kota <sup class='text-danger'>*<sup>",
					name: "hemwrmd.id_gctxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/core/gctxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_gctxxmh_old: id_gctxxmh_hemwrmd,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1,
						},
					}
				},
				{
					label: "Tanggal Masuk <sup class='text-danger'>*<sup>",
					name: "hemwrmd.tanggal_masuk",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					label: "Tanggal Keluar",
					name: "hemwrmd.tanggal_keluar",
					type: "datetime",
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					label: "Alamat <sup class='text-danger'>*<sup>",
					name: "hemwrmd.alamat",
					type: "textarea"
				},
				{
					label: "Alasan Keluar",
					name: "hemwrmd.alasan_keluar"
				},
				{
					label: "Nama Atasan Langsung <sup class='text-danger'>*<sup>",
					name: "hemwrmd.nama_atasan"
				},
				{
					label: "Jabatan Atasan Langsung <sup class='text-danger'>*<sup>",
					name: "hemwrmd.jabatan_atasan"
				},
				{
					label: "Jabatan Awal <sup class='text-danger'>*<sup>",
					name: "hemwrmd.jabatan_awal"
				},
				{
					label: "Jabatan Akhir <sup class='text-danger'>*<sup>",
					name: "hemwrmd.jabatan_akhir"
				},
				{
					label: "Gaji Terakhir <sup class='text-danger'>*<sup>",
					name: "hemwrmd.gaji_terakhir"
				},
			]
		} );
			
		edthemwrmd.on( 'preOpen', function( e, mode, action ) {
			edthemwrmd.field('hemwrmd.id_hemxxmh').val(id_hemxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthemwrmd.field('hemwrmd.start_at').val(start_at);
			
			if(action == 'create'){
				tblhemwrmd.rows().deselect();
			}
		});

		edthemwrmd.dependent( 'hemwrmd.tanggal_keluar', function ( val, data, callback ) {
			//dependent validasi pre * bintang required
			console.log(val);
			if (val.trim() !== '') {
				edthemwrmd.field('hemwrmd.alasan_keluar').label("Alasan Keluar <sup class='text-danger'>*<sup>")
			} else {
				edthemwrmd.field('hemwrmd.alasan_keluar').label("Alasan Keluar")
			}
			return {}
		}, {event: 'keyup change'});

		edthemwrmd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthemwrmd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				id_gctxxmh = edthemwrmd.field('hemwrmd.id_gctxxmh').val();
				tanggal_masuk       = edthemwrmd.field('hemwrmd.tanggal_masuk').val();
				tanggal_keluar       = edthemwrmd.field('hemwrmd.tanggal_keluar').val();
				perusahaan     = edthemwrmd.field('hemwrmd.perusahaan').val();
				jenis_usaha     = edthemwrmd.field('hemwrmd.jenis_usaha').val();
				alamat     = edthemwrmd.field('hemwrmd.alamat').val();
				alasan_keluar     = edthemwrmd.field('hemwrmd.alasan_keluar').val();
				nama_atasan     = edthemwrmd.field('hemwrmd.nama_atasan').val();
				jabatan_atasan     = edthemwrmd.field('hemwrmd.jabatan_atasan').val();
				jabatan_awal     = edthemwrmd.field('hemwrmd.jabatan_awal').val();
				jabatan_akhir     = edthemwrmd.field('hemwrmd.jabatan_akhir').val();
				gaji_terakhir     = edthemwrmd.field('hemwrmd.gaji_terakhir').val();

				validasiRequired(
					edthemwrmd,
					'hemwrmd',
					{
						'id_gctxxmh': id_gctxxmh,
						'tanggal_masuk'      : tanggal_masuk,
						'perusahaan'    : perusahaan,
						'alamat'    : alamat,
						'nama_atasan'    : nama_atasan,
						'jabatan_atasan'    : jabatan_atasan,
						'jabatan_awal'    : jabatan_awal,
						'jabatan_akhir'    : jabatan_akhir,
						'gaji_terakhir'    : gaji_terakhir,
						'jenis_usaha'    : jenis_usaha,
					}
				);

				// console.log(tanggal_keluar);
				//jika tanggal keluar diisi
				if (tanggal_keluar.trim() !== '') {

					validasiRequired(
						edthemwrmd,
						'hemwrmd',
						{
							'alasan_keluar'    : alasan_keluar,
						}
					);

					
					if (tanggal_masuk > tanggal_keluar) {
						edthemwrmd.field('hemwrmd.tanggal_masuk').error( 'Tanggal Masuk harus lebih kecil dari Tanggal Keluar!' );
						edthemwrmd.field('hemwrmd.tanggal_keluar').error( 'Tanggal Keluar harus lebih besar dari Tanggal Masuk!' );
					}
				}

				
				validasiNumber(
					edthemwrmd,
					'hemwrmd',
					{
						'gaji_terakhir': gaji_terakhir
					},
					0,
					'>'
				);
			}
			
			if ( edthemwrmd.inError() ) {
				return false;
			}
		});

		edthemwrmd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthemwrmd.field('hemwrmd.finish_at').val(finish_at);
		});
			
		edthemwrmd.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblhemwrmd.rows().deselect();
			tblhemwrmd.ajax.reload(null, false);
		} );

		edthemwrmd.on( 'close', function () {
			edthemwrmd.enable();
		} );
		
		//start datatables
		tblhemwrmd = $('#tblhemwrmd').DataTable( {
			dom: dom0,
			ajax: {
				url: "../../models/hemxxmh/hemwrmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hemwrmd = show_deleted_hemwrmd;
					d.id_hemxxmh = id_hemxxmh;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "hemwrmd.id",visible:false },
				{ data: "hemwrmd.id_hemxxmh",visible:false },
				{ data: "hemwrmd.perusahaan" },
				{ data: "hemwrmd.jenis_usaha" },
				{ data: "gctxxmh.nama" },
				{ data: "hemwrmd.tanggal_masuk" },
				{ data: "hemwrmd.tanggal_keluar" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hemwrmd';
					$table       = 'tblhemwrmd';
					$edt         = 'edthemwrmd';
					$show_status = '_hemwrmd';
					$table_name  = $nama_tabels_d[9];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log_d','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
			}
		} );

		tblhemwrmd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD(tblhemwrmd, 0 );
			CekDrawDetailHDFinal(tblhemxxmh);
		} );

		tblhemwrmd.on( 'select', function( e, dt, type, indexes ) {
			data_hemwrmd 		= tblhemwrmd.row( { selected: true } ).data().hemwrmd;
			id_hemwrmd   		= data_hemwrmd.id;
			id_transaksi_d 		= id_hemwrmd; // dipakai untuk general
			id_transaksi_log_d  = id_hemwrmd; // dipakai untuk log

			transaction_state_d   = data_hemwrmd.transaction_state;
			id_gctxxmh_hemwrmd   = data_hemwrmd.id_gctxxmh;
			// atur hak akses
			CekSelectDetailHD(tblhemxxmh, tblhemwrmd );
		} );

		tblhemwrmd.on( 'deselect', function() {
			id_hemwrmd = 0;
			id_gctxxmh_hemwrmd = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblhemxxmh, tblhemwrmd );
		} );

// --------- end _detail --------------- //	

// --------- start _detail --------------- // hemlgmd

		//start datatables editor
		edthemlgmd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hemxxmh/hemlgmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hemlgmd = show_deleted_hemlgmd;
					d.id_hemxxmh = id_hemxxmh;
				}
			},
			table: "#tblhemlgmd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "hemlgmd.start_at",
					name: "hemlgmd.start_at",
					type: "hidden"
				},	
				{
					label: "hemlgmd.finish_at",
					name: "hemlgmd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hemlgmd",
					type: "hidden"
				},	
				{
					label: "hemlgmd.transaction_state",
					name: "hemlgmd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_hemxxmh",
					name: "hemlgmd.id_hemxxmh",
					type: "hidden"
				},	
				{
					label: "Bahasa <sup class='text-danger'>*<sup>",
					name: "hemlgmd.id_hgnlgmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hgnlgmh/hgnlgmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hgnlgmh_old: id_hgnlgmh_old,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1,
						},
					}
				},	{
					label: "Mendengar <sup class='text-danger'>*<sup>",
					name: "hemlgmd.mendengar",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Baik Sekali", "value": "Baik Sekali" },
						{ "label": "Baik", "value": "Baik" },
						{ "label": "Kurang", "value": "Kurang" },
						{ "label": "Kurang Sekali", "value": "Kurang Sekali" }
					]
				},	{
					label: "Membaca <sup class='text-danger'>*<sup>",
					name: "hemlgmd.membaca",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Baik Sekali", "value": "Baik Sekali" },
						{ "label": "Baik", "value": "Baik" },
						{ "label": "Kurang", "value": "Kurang" },
						{ "label": "Kurang Sekali", "value": "Kurang Sekali" }
					]
				},	{
					label: "Menulis <sup class='text-danger'>*<sup>",
					name: "hemlgmd.menulis",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Baik Sekali", "value": "Baik Sekali" },
						{ "label": "Baik", "value": "Baik" },
						{ "label": "Kurang", "value": "Kurang" },
						{ "label": "Kurang Sekali", "value": "Kurang Sekali" }
					]
				},	{
					label: "Percakapan <sup class='text-danger'>*<sup>",
					name: "hemlgmd.percakapan",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Baik Sekali", "value": "Baik Sekali" },
						{ "label": "Baik", "value": "Baik" },
						{ "label": "Kurang", "value": "Kurang" },
						{ "label": "Kurang Sekali", "value": "Kurang Sekali" }
					]
				}
			]
		} );
			
		edthemlgmd.on( 'preOpen', function( e, mode, action ) {
			edthemlgmd.field('hemlgmd.id_hemxxmh').val(id_hemxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthemlgmd.field('hemlgmd.start_at').val(start_at);
			
			if(action == 'create'){
				tblhemlgmd.rows().deselect();
			}
		});

		edthemlgmd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthemlgmd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				id_hgnlgmh = edthemlgmd.field('hemlgmd.id_hgnlgmh').val();
				mendengar       = edthemlgmd.field('hemlgmd.mendengar').val();
				membaca     = edthemlgmd.field('hemlgmd.membaca').val();
				menulis     = edthemlgmd.field('hemlgmd.menulis').val();
				percakapan     = edthemlgmd.field('hemlgmd.percakapan').val();

				validasiRequired(
					edthemlgmd,
					'hemlgmd',
					{
						'percakapan': percakapan,
						'mendengar'      : mendengar,
						'membaca'    : membaca,
						'id_hgnlgmh'    : id_hgnlgmh,
						'menulis'    : menulis,
					}
				);
			}
			
			if ( edthemlgmd.inError() ) {
				return false;
			}
		});

		edthemlgmd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthemlgmd.field('hemlgmd.finish_at').val(finish_at);
		});
			
		edthemlgmd.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblhemlgmd.rows().deselect();
			tblhemlgmd.ajax.reload(null, false);
		} );

		edthemlgmd.on( 'close', function () {
			edthemlgmd.enable();
		} );
		
		//start datatables
		tblhemlgmd = $('#tblhemlgmd').DataTable( {
			dom: dom0,
			ajax: {
				url: "../../models/hemxxmh/hemlgmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hemlgmd = show_deleted_hemlgmd;
					d.id_hemxxmh = id_hemxxmh;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "hemlgmd.id",visible:false },
				{ data: "hemlgmd.id_hemxxmh",visible:false },
				{ data: "hgnlgmh.nama" },
				{ data: "hemlgmd.membaca" },
				{ data: "hemlgmd.mendengar" },
				{ data: "hemlgmd.menulis" },
				{ data: "hemlgmd.percakapan" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hemlgmd';
					$table       = 'tblhemlgmd';
					$edt         = 'edthemlgmd';
					$show_status = '_hemlgmd';
					$table_name  = $nama_tabels_d[10];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log_d','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
			}
		} );

		tblhemlgmd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD(tblhemlgmd, 0 );
			CekDrawDetailHDFinal(tblhemxxmh);
		} );

		tblhemlgmd.on( 'select', function( e, dt, type, indexes ) {
			data_hemlgmd 		= tblhemlgmd.row( { selected: true } ).data().hemlgmd;
			id_hemlgmd   		= data_hemlgmd.id;
			id_transaksi_d 		= id_hemlgmd; // dipakai untuk general
			id_transaksi_log_d  = id_hemlgmd; // dipakai untuk log

			transaction_state_d   = data_hemlgmd.transaction_state;
			id_hgnlgmh_old   = data_hemlgmd.id_hgnlgmh;
			// atur hak akses
			CekSelectDetailHD(tblhemxxmh, tblhemlgmd );
		} );

		tblhemlgmd.on( 'deselect', function() {
			id_hemlgmd = 0;
			id_hgnlgmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblhemxxmh, tblhemlgmd );
		} );

// --------- end _detail --------------- //	

// --------- start _detail --------------- //

		//start datatables editor
		edthadxxtd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hemxxmh/hadxxtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hadxxtd = show_deleted_hadxxtd;
					d.id_hemxxmh = id_hemxxmh;
				}
			},
			table: "#tblhadxxtd",
			formOptions: {
				main: {
					focus: 5
				}
			},
			fields: [ 
				{
					label: "hadxxtd.start_at",
					name: "hadxxtd.start_at",
					type: "hidden"
				},	
				{
					label: "hadxxtd.finish_at",
					name: "hadxxtd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hadxxtd",
					type: "hidden"
				},	
				{
					label: "hadxxtd.transaction_state",
					name: "hadxxtd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_hemxxmh",
					name: "hadxxtd.id_hemxxmh",
					type: "hidden"
				},	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "hadxxtd.nama"
				}, 
				{
					label: "Pelanggaran <sup class='text-danger'>*<sup>",
					name: "hadxxtd.id_havxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/havxxmh/havxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_havxxmh_old: id_havxxmh_old,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1,
						},
					}
				},
				{
					label: "Tindakan <sup class='text-danger'>*<sup>",
					name: "hadxxtd.id_hadxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hadxxmh/hadxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hadxxmh_saran: id_hadxxmh_saran,
									id_hadxxmh_old: id_hadxxmh_old,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1,
						},
					}
				},
				{
					label: "Tanggal Mulai Berlaku",
					name: "hadxxtd.tanggal_awal",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					label: "Tanggal Selesai Berlaku",
					name: "hadxxtd.tanggal_akhir",
					type: "datetime",
					format: 'DD MMM YYYY'
				},
				{
					label: "Bukti",
					name: "hadxxtd.id_files_bukti",
					type: "upload",
					display: function ( fileId, counter ) {
						if(fileId > 0){
							return '<img src="'+edthadxxtd.file( 'files', fileId ).web_path+'"/>';
						}
					},
					noFileText: 'Belum ada lampiran'
				},
				{
					label: "Dokumen",
					name: "hadxxtd.id_files_dokumen",
					type: "upload",
					display: function ( fileId, counter ) {
						if(fileId > 0){
							return '<img src="'+edthadxxtd.file( 'files', fileId ).web_path+'"/>';
						}
					},
					noFileText: 'Belum ada lampiran'
				},
				{
					label: "Keterangan",
					name: "hadxxtd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edthadxxtd.on( 'preOpen', function( e, mode, action ) {
			edthadxxtd.field('hadxxtd.id_hemxxmh').val(id_hemxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthadxxtd.field('hadxxtd.start_at').val(start_at);
			
			if(action == 'create'){
				tblhadxxtd.rows().deselect();
			}
		});

		edthadxxtd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthadxxtd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_havxxmh = edthadxxtd.field('hadxxtd.id_havxxmh').val();
				id_hadxxmh = edthadxxtd.field('hadxxtd.id_hadxxmh').val();

				validasiRequired(
					edthadxxtd,
					'hadxxtd',
					{
						'id_havxxmh': nama,
						'id_hadxxmh': id_hadxxmh
					}
				);
			}
			
			if ( edthadxxtd.inError() ) {
				return false;
			}
		});

		edthadxxtd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthadxxtd.field('hadxxtd.finish_at').val(finish_at);
		});
			
		edthadxxtd.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblhadxxtd.rows().deselect();
			tblhadxxtd.ajax.reload(null, false);
		} );

		edthadxxtd.on( 'close', function () {
			edthadxxtd.enable();
		} );
		
		//start datatables
		tblhadxxtd = $('#tblhadxxtd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-2',
			},
			ajax: {
				url: "../../models/hemxxmh/hadxxtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hadxxtd = show_deleted_hadxxtd;
					d.id_hemxxmh = id_hemxxmh;
				}
			},
			order: [[ 2, "desc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [2,3]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0,1,4,5]
				}
			],
			// responsive: false,
			// scrollX: true,
			columns: [
				{ data: "hadxxtd.id",visible:false },
				{ data: "hadxxtd.id_hemxxmh",visible:false },
				{ data: "hadxxtd.kode" },
				{ data: "hadxxmh.nama" },
				{ data: "havxxmh.nama" },
				{ data: "hadxxtd.tanggal_awal" },
				{ data: "hadxxtd.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hadxxtd';
					$table       = 'tblhadxxtd';
					$edt         = 'edthadxxtd';
					$show_status = '_hadxxtd';
					$table_name  = $nama_tabels_d[1];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_action 	= [];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			}
		} );

		tblhadxxtd.searchPanes.container().appendTo('#sphadxxtd');
		tblhadxxtd.searchBuilder.container().appendTo( '#sbhadxxtd' );

		tblhadxxtd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD(tblhadxxtd, 0 );
			CekDrawDetailHDFinal(tblhemxxmh);
		} );

		tblhadxxtd.on( 'select', function( e, dt, type, indexes ) {
			data_hadxxtd 		= tblhadxxtd.row( { selected: true } ).data().hadxxtd;
			id_hadxxtd   		= data_hadxxtd.id;
			id_transaksi_d 		= id_hadxxtd; // dipakai untuk general
			id_transaksi_log_d 	= id_hadxxtd; // dipakai untuk log

			transaction_state_d  = data_hadxxtd.transaction_state;
			id_hadxxmh_old   = data_hadxxtd.id_hadxxmh;
			// atur hak akses
			CekSelectDetailHD(tblhemxxmh, tblhadxxtd );
		} );

		tblhadxxtd.on( 'deselect', function() {
			id_hadxxtd = 0;
			id_hadxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblhemxxmh, tblhadxxtd );
		} );

// --------- end _detail --------------- //		

// Perjalanan Dinas Nonaktif dulu
// --------- start _detail --------------- //
		//start datatables
		tblhttlptd = $('#tblhttlptd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-2',
			},
			ajax: {
				url: "../../models/hemxxmh/httlptd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_httlptd = show_deleted_httlptd;
					d.id_hemxxmh = id_hemxxmh;
				}
			},
			order: [[ 2, "desc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [2,3]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0,1,4,5]
				}
			],
			responsive: false,
			// scrollX: true,
			order: [[ 1, "desc" ]],
			columns: [
				{ data: "httlptd.id",visible:false },
				{ data: "httlptd.id_hemxxmh",visible:false },
				{ data: "httlptd.tanggal_awal" },
				{ data: "httlptd.tanggal_akhir" },
				{ data: "httlptd.jam_awal" },
				{ data: "httlptd.jam_akhir" },
				{ data: "httlptd.kode" },
				{ 
					data: "httlptd.jenis",
					render: function (data) {
						if (data == 1) {
							return '<span class="badge badge-primary">Hari</span>';
						} else if (data == 2) {
							return '<span class="badge badge-primary">Jam</span>';
						} else {
							return '<span class="badge badge-warning">INVALID</span>';
						}
					}
				},
				{ data: "httlpmh.nama" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_httlptd';
					$table       = 'tblhttlptd';
					$edt         = 'edthttlptd';
					$show_status = '_httlptd';
					$table_name  = $nama_tabels_d[4];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_action 	= [];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			}
		} );

		tblhttlptd.searchPanes.container().appendTo('#sphttlptd');
		tblhttlptd.searchBuilder.container().appendTo( '#sbhttlptd' );

		tblhttlptd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD(tblhttlptd, 0 );
			CekDrawDetailHDFinal(tblhemxxmh);
		} );

		tblhttlptd.on( 'select', function( e, dt, type, indexes ) {
			data_httlptd 		= tblhttlptd.row( { selected: true } ).data().httlptd;
			id_httlptd   		= data_httlptd.id;
			id_transaksi_d 		= id_httlptd; // dipakai untuk general
			id_transaksi_log_d 	= id_httlptd; // dipakai untuk log

			transaction_state_d  = data_httlptd.transaction_state;
			id_hgnedmh_old   = data_httlptd.id_hgnedmh;
			// atur hak akses
			CekSelectDetailHD(tblhemxxmh, tblhttlptd );
		} );

		tblhttlptd.on( 'deselect', function() {
			id_httlptd = 0;
			id_hgnedmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblhemxxmh, tblhttlptd );
		} );

// --------- end _detail --------------- //		


// --------- start _detail --------------- //
		//start datatables
		
		//start datatables editor
		edthemtrmd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hemxxmh/hemtrmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hemtrmd = show_deleted_hemtrmd;
					d.id_hemxxmh = id_hemxxmh;
				}
			},
			table: "#tblhemtrmd",
			fields: [ 
				{
					label: "hemtrmd.start_at",
					name: "hemtrmd.start_at",
					type: "hidden"
				},	
				{
					label: "hemtrmd.finish_at",
					name: "hemtrmd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hemtrmd",
					type: "hidden"
				},	
				{
					label: "hemtrmd.transaction_state",
					name: "hemtrmd.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "id_hemxxmh",
					name: "hemtrmd.id_hemxxmh",
					type: "hidden"
				},		
				{
					label: "Nama Pelatihan <sup class='text-danger'>*<sup>",
					name: "hemtrmd.nama"
				},
				{
					label: "Penyelenggara <sup class='text-danger'>*<sup>",
					name: "hemtrmd.penyelenggara"
				},
				{
					label: "Tanggal Awal <sup class='text-danger'>*<sup>",
					name: "hemtrmd.tanggal_awal",
					type: "datetime",
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				}, 	
				{
					label: "Tanggal Akhir <sup class='text-danger'>*<sup>",
					name: "hemtrmd.tanggal_akhir",
					type: "datetime",
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				}, 	
			]
		} );
		
		edthemtrmd.on( 'preOpen', function( e, mode, action ) {
			edthemtrmd.field('hemtrmd.id_hemxxmh').val(id_hemxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthemtrmd.field('hemtrmd.start_at').val(start_at);			
		});

		edthemtrmd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthemtrmd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				penyelenggara       = edthemtrmd.field('hemtrmd.penyelenggara').val();
				nama     = edthemtrmd.field('hemtrmd.nama').val();
				tanggal_awal = edthemtrmd.field('hemtrmd.tanggal_awal').val();
				tanggal_akhir = edthemtrmd.field('hemtrmd.tanggal_akhir').val();

				validasiRequired(
					edthemtrmd,
					'hemtrmd',
					{
						'penyelenggara': penyelenggara,
						'nama': nama,
						'tanggal_awal': tanggal_awal,
						'tanggal_akhir': tanggal_akhir,
					}
				);
				
				if (tanggal_awal > tanggal_akhir) {
					edthemtrmd.field('hemtrmd.tanggal_awal').error( 'Tanggal Awal harus lebih kecil dari Tanggal Akhir!' );
					edthemtrmd.field('hemtrmd.tanggal_akhir').error( 'Tanggal Akhir harus lebih besar dari Tanggal Awal!' );
				}
				
			}
			
			if ( edthemtrmd.inError() ) {
				return false;
			}
		});

		edthemtrmd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthemtrmd.field('hemtrmd.finish_at').val(finish_at);
		});
		
		edthemtrmd.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblhemtrmd.ajax.reload(null,false);
		} );

		edthemtrmd.on( 'close', function () {
			edthemtrmd.enable();
		} );
		
		tblhemtrmd = $('#tblhemtrmd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-2',
			},
			ajax: {
				url: "../../models/hemxxmh/hemtrmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hemtrmd = show_deleted_hemtrmd;
					d.id_hemxxmh = id_hemxxmh;
				}
			},
			order: [[ 2, "desc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [2,3]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: "_all"
				}
			],
			responsive: false,
			// scrollX: true,
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "hemtrmd.id",visible:false },
				{ data: "hemtrmd.id_hemxxmh",visible:false },
				{ data: "hemtrmd.nama" },
				{ data: "hemtrmd.penyelenggara" },
				{ data: "hemtrmd.tanggal_awal" },
				{ data: "hemtrmd.tanggal_akhir" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hemtrmd';
					$table       = 'tblhemtrmd';
					$edt         = 'edthemtrmd';
					$show_status = '_hemtrmd';
					$table_name  = $nama_tabels_d[5];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log_d','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			}
		} );

		tblhemtrmd.searchPanes.container().appendTo('#sphemtrmd');
		tblhemtrmd.searchBuilder.container().appendTo( '#sbhemtrmd' );

		tblhemtrmd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD(tblhemtrmd, 0 );
			CekDrawDetailHDFinal(tblhemxxmh);
		} );

		tblhemtrmd.on( 'select', function( e, dt, type, indexes ) {
			data_hemtrmd 		= tblhemtrmd.row( { selected: true } ).data().hemtrmd;
			id_hemtrmd   		= data_hemtrmd.id;
			id_transaksi_d 		= id_hemtrmd; // dipakai untuk general
			id_transaksi_log_d 	= id_hemtrmd; // dipakai untuk log

			transaction_state_d  = data_hemtrmd.transaction_state;
			// id_hgnedmh_old   = data_hemtrmd.id_hgnedmh;
			// atur hak akses
			CekSelectDetailHD(tblhemxxmh, tblhemtrmd );
		} );

		tblhemtrmd.on( 'deselect', function() {
			id_hemtrmd = 0;
			// id_hgnedmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblhemxxmh, tblhemtrmd );
		} );

// --------- end _detail --------------- //	

	
// --------- start _detail --------------- //
		//start datatables
		
		//start datatables editor
		edthesxxtd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hemxxmh/hesxxtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hesxxtd = show_deleted_hesxxtd;
					d.id_hemxxmh = id_hemxxmh;
				}
			},
			table: "#tblhesxxtd",
			fields: [ 
				{
					label: "hesxxtd.start_at",
					name: "hesxxtd.start_at",
					type: "hidden"
				},	
				{
					label: "hesxxtd.finish_at",
					name: "hesxxtd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hesxxtd",
					type: "hidden"
				},	
				{
					label: "hesxxtd.transaction_state",
					name: "hesxxtd.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "id_hemxxmh",
					name: "hesxxtd.id_hemxxmh",
					type: "hidden"
				},	
				{
					label: "Status",
					name: "hesxxtd.id_hesxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hesxxmh/hesxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hesxxmh: 0,
									id_hesxxmh_old: id_hesxxmh_pkwt,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1,
						},
					}
				},	
				{
					label: "No PKWT/TT <sup class='text-danger'>*<sup>",
					name: "hesxxtd.kode"
				},
				{
					label: "Tanggal Awal <sup class='text-danger'>*<sup>",
					name: "hesxxtd.tanggal_awal",
					type: "datetime",
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				}, 	
				{
					label: "Tanggal Akhir",
					name: "hesxxtd.tanggal_akhir",
					type: "datetime",
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				}, 	
			]
		} );
		
		edthesxxtd.on( 'preOpen', function( e, mode, action ) {
			edthesxxtd.field('hesxxtd.id_hemxxmh').val(id_hemxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthesxxtd.field('hesxxtd.start_at').val(start_at);			
		});

		edthesxxtd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthesxxtd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode       = edthesxxtd.field('hesxxtd.kode').val();
				id_hesxxmh     = edthesxxtd.field('hesxxtd.id_hesxxmh').val();
				tanggal_awal = edthesxxtd.field('hesxxtd.tanggal_awal').val();

				validasiRequired(
					edthesxxtd,
					'hesxxtd',
					{
						'kode': kode,
						'id_hesxxmh': id_hesxxmh,
						'tanggal_awal': tanggal_awal,
					}
				);
				
			}
			
			if ( edthesxxtd.inError() ) {
				return false;
			}
		});

		edthesxxtd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthesxxtd.field('hesxxtd.finish_at').val(finish_at);
		});
		
		edthesxxtd.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblhesxxtd.ajax.reload(null,false);
		} );

		edthesxxtd.on( 'close', function () {
			edthesxxtd.enable();
		} );
		
		tblhesxxtd = $('#tblhesxxtd').DataTable( {
			dom: dom0,
			ajax: {
				url: "../../models/hemxxmh/hesxxtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hesxxtd = show_deleted_hesxxtd;
					d.id_hemxxmh = id_hemxxmh;
				}
			},
			order: [[ 2, "desc" ]],
			columnDefs:[
			],
			responsive: false,
			// scrollX: true,
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "hesxxtd.id",visible:false },
				{ data: "hesxxtd.id_hemxxmh",visible:false },
				{ data: "hesxxmh.nama" },
				{ data: "hesxxtd.tanggal_awal" },
				{ data: "hesxxtd.tanggal_akhir" },
				{ data: "hesxxtd.kode" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hesxxtd';
					$table       = 'tblhesxxtd';
					$edt         = 'edthesxxtd';
					$show_status = '_hesxxtd';
					$table_name  = $nama_tabels_d[6];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log_d','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
			}
		} );

		tblhesxxtd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD(tblhesxxtd, 0 );
			CekDrawDetailHDFinal(tblhemxxmh);
		} );

		tblhesxxtd.on( 'select', function( e, dt, type, indexes ) {
			data_hesxxtd 		= tblhesxxtd.row( { selected: true } ).data().hesxxtd;
			id_hesxxtd   		= data_hesxxtd.id;
			id_transaksi_d 		= id_hesxxtd; // dipakai untuk general
			id_transaksi_log_d 	= id_hesxxtd; // dipakai untuk log

			transaction_state_d  = data_hesxxtd.transaction_state;
			id_hesxxmh_pkwt   = data_hesxxtd.id_hesxxmh;
			// atur hak akses
			CekSelectDetailHD(tblhemxxmh, tblhesxxtd );
		} );

		tblhesxxtd.on( 'deselect', function() {
			id_hesxxtd = 0;
			id_hesxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblhemxxmh, tblhesxxtd );
		} );

// --------- end _detail --------------- //	

		tblhemjbrd = $('#tblhemjbrd').DataTable( {
			dom: dom0,
			ajax: {
				url: "../../models/hemxxmh/hemjbrd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hemjbrd = show_deleted_hemjbrd;
					d.id_hemxxmh = id_hemxxmh;
				}
			},
			order: [[ 2, "desc" ]],
			responsive: false,
			// scrollX: true,
			columns: [
				{ data: "hemjbrd.id",visible:false },
				{ data: "hemjbrd.id_hemxxmh",visible:false },
				{ data: "hemjbrd.kode" },
				{ data: "hesxxmh.nama" },
				{ 
					data: "harxxmh.nama",
					render: function (data, type, row) {
						if (row.hemjbrd.kode.includes('RTS')) { 
							return 'Rotasi';
						}else{
							return data;
						}
					}
				},
				{ data: "hemjbrd.tanggal_awal" },
				{ data: "hemjbrd.tanggal_akhir" },
				{ data: "hemjbrd.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hemjbrd';
					$table       = 'tblhemjbrd';
					$edt         = 'edthemjbrd';
					$show_status = '_hemjbrd';
					$table_name  = $nama_tabels_d[7];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_action 	= [];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
			}
		} );

		tblhemjbrd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD(tblhemjbrd, 0 );
			CekDrawDetailHDFinal(tblhemxxmh);
		} );

		tblhemjbrd.on( 'select', function( e, dt, type, indexes ) {
			// data_hemjbrd 		= tblhemjbrd.row( { selected: true } ).data().hemjbrd;
			// id_hemjbrd   		= data_hemjbrd.id;
			// id_transaksi_d 		= id_hemjbrd; // dipakai untuk general
			// id_transaksi_log_d 	= id_hemjbrd; // dipakai untuk log

			// transaction_state_d  = data_hemjbrd.transaction_state;
			// id_hadxxmh_old   = data_hemjbrd.id_hadxxmh;
			// atur hak akses
			CekSelectDetailHD(tblhemxxmh, tblhemjbrd );
		} );

		tblhemjbrd.on( 'deselect', function() {
			id_hemjbrd = 0;
			id_hadxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblhemxxmh, tblhemjbrd );
		} );

		tblhacemtd = $('#tblhacemtd').DataTable( {
			dom: dom0,
			ajax: {
				url: "../../models/hemxxmh/hacemtd_hemxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hacemtd = show_deleted_hacemtd;
					d.id_hemxxmh = id_hemxxmh;
				}
			},
			order: [[ 2, "desc" ]],
			responsive: false,
			// scrollX: true,
			
			columns: [
				{ data: "hacemtd.id",visible:false },
				{ data: "hacemtd.id_hemxxmh",visible:false },
				{ data: "hacemtd.kode" },
				{ data: "hacemtd.tanggal" },
				{ data: "hactpmh.nama" },
				{ data: "hemxxmh_fullname" },
				{ 
					data: "hacemtd.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hacemtd';
					$table       = 'tblhacemtd';
					$edt         = 'edthacemtd';
					$show_status = '_hacemtd';
					$table_name  = $nama_tabels_d[11];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_action 	= [];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
			}
		} );

		tblhacemtd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD(tblhacemtd, 0 );
			CekDrawDetailHDFinal(tblhemxxmh);
		} );

		tblhacemtd.on( 'select', function( e, dt, type, indexes ) {
			CekSelectDetailHD(tblhemxxmh, tblhacemtd );
		} );

		tblhacemtd.on( 'deselect', function() {
			id_hacemtd = 0;
			id_hadxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblhemxxmh, tblhacemtd );
		} );

		tblkisemtd = $('#tblkisemtd').DataTable( {
			dom: dom0,
			ajax: {
				url: "../../models/hemxxmh/kisemtd_hemxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_kisemtd = show_deleted_kisemtd;
					d.id_hemxxmh = id_hemxxmh;
				}
			},
			order: [[ 2, "desc" ]],
			responsive: false,
			// scrollX: true,
			
			columns: [
				{ data: "kisemtd.id",visible:false },
				{ data: "kisemtd.id_hemxxmh",visible:false },
				{ data: "kisemtd.kode" },
				{ data: "kisemtd.tanggal" },
				{ data: "kisctmh.nama" },
				{ data: "hemxxmh_fullname" },
				{ 
					data: "kisemtd.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_kisemtd';
					$table       = 'tblkisemtd';
					$edt         = 'edtkisemtd';
					$show_status = '_kisemtd';
					$table_name  = $nama_tabels_d[12];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_action 	= [];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
			}
		} );

		tblkisemtd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD(tblkisemtd, 0 );
			CekDrawDetailHDFinal(tblhemxxmh);
		} );

		tblkisemtd.on( 'select', function( e, dt, type, indexes ) {
			CekSelectDetailHD(tblhemxxmh, tblkisemtd );
		} );

		tblkisemtd.on( 'deselect', function() {
			id_kisemtd = 0;
			id_hadxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblhemxxmh, tblkisemtd );
		} );

	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
