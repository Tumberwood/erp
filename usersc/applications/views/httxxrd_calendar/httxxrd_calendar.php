<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'httxxrd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
		<div class="ibox">
			<div class="ibox-content">
				<div id="calendar"></div>
			</div>
		</div>
	</div>
</div>

<?php
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_log.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_dt_fs.php';
?>

<!-- BEGIN JS -->
<?php 
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_setup.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php'; 
?>

<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/fullcalendar/index.global.min.js"></script>

<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/validation_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/httxxrd_calendar/fn/httxxrd_calendar_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	
		// ------------- default variable, do not erase
		var edthttxxrd, tblhttxxrd, show_deleted_httxxrd = 0, id_httxxrd;
		// ------------- end of default variable
		var event_data, awal,akhir;
		var id_nirxxmh_old = 0;
		
		// get tableRelation
		// tableRelation('httxxrd');

		$(document).ready(function() {

			var calendarEl = $('#calendar')[0];
        	var calendar = new FullCalendar.Calendar(calendarEl, {
				initialView: 'dayGridMonth',
				navLinks: true,
				headerToolbar: {
					center: 'title',
					end: 'dayGridMonth,timeGridWeek,timeGridDay'
				},
				footerToolbar: {
					start: '',
					center: '',
					end: 'prevYear,prev,next,nextYear'
				},
				contentHeight: 400,
				// eventClick: function(info) {
				// 	alert('Event: ' + info.event.title);
				// 	var keterangan = info.event.title.split(" ");
				// 	console.log(keterangan);
				// 	//extendedProps itu untuk keys yang dibuat manual, atau yang tidak ada di default FullCalendar
				// 	//seperti id_transaksi itu aslinya tidak ada di FullCalendar, tapi saya tambahkan sendiri
				// 	console.log(info.event.extendedProps.id_transaksi); 
				// 	console.log(info.event.start); 
				// 	console.log(info.event.end); 

				// 	// Keterangan yang dipisah dengan spasi ke 2 akan menghasilkan kode cuti, seperti CB/(Dari Cuti Bersama) dan LP/ (dari Leave Permission)
				// 	if (keterangan[2].startsWith("CB/")) {
				// 		console.log("cuti"); // Logging "cuti" if condition is met
				// 	} else {
				// 		console.log("Report"); // Logging "Report" if condition is not met
				// 	}
				// },
				events: function(info, successCallback, failureCallback) {
					console.log(awal);
					$.ajax( {
						url: "../../models/httxxrd_calendar/httxxrd_calendar_fn_load_calendar.php",
						dataType: 'json',
						type: 'POST',
						data: {
							awal: awal,
							akhir: akhir 
						},
						success: function ( json ) {
							event_data = json.data.rs_httxxrd
							// console.log(event_data);

							var events = json.data.rs_httxxrd.map(function(event) {
								return {
									title: event.title,
									start: event.start,
									end: event.end,
									//custom key variable untuk menyimpan id_transaksi
									// id_transaksi: event.id_transaksi,
									url: event.url
								};
							});
							// Panggil successCallback dengan array events
							successCallback(events);
						}
					} );
				},
				// datesSet: function (dateInfo) {
				// 	awal =  moment(dateInfo.view.activeStart).format("YYYY-MM-DD HH:mm:ss");
				// 	akhir = moment(dateInfo.view.activeEnd).format("YYYY-MM-DD HH:mm:ss");
				// },
       	 	});
        	calendar.render();

			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
