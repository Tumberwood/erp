<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'nevxxth';
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/nevxxth/fn/nevxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	
		// ------------- default variable, do not erase
		var edtnevxxth, tblnevxxth, show_deleted_nevxxth = 0, id_nevxxth;
		// ------------- end of default variable
		var event_data, awal,akhir;
		var id_nirxxmh_old = 0;
		
		// get tableRelation
		// tableRelation('nevxxth');

		$(document).ready(function() {
			
			// BEGIN nevxxth
			edtnevxxth = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/nevxxth/nevxxth.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_nevxxth = show_deleted_nevxxth;
					}
				},
				// table: "#tblnevxxth",
				fields: [ 
					{
						label: "nevxxth.start_at",
						name: "nevxxth.start_at",
						type: "hidden"
					},	
					{
						label: "nevxxth.finish_at",
						name: "nevxxth.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "nevxxth",
						type: "hidden"
					},	
					{
						label: "nevxxth.transaction_state",
						name: "nevxxth.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Event <sup class='text-danger'>*<sup>",
						name: "nevxxth.nama"
					}, 	
					{
						label: "Keterangan",
						name: "nevxxth.keterangan",
						type: "textarea"
					},
					{
						label: "Start",
						name: "nevxxth.tanggaljam_awal",
						type: "datetime",
						def: function () { 
							return new Date(); 
						},
						opts:{
							minDate: new Date('1900-01-01'),
							firstDay: 0
						},
						format: 'DD MMM YYYY HH:mm'
					},
					{
						label: "End",
						name: "nevxxth.tanggaljam_akhir",
						type: "datetime",
						def: function () { 
							return new Date(); 
						},
						opts:{
							minDate: new Date('1900-01-01'),
							firstDay: 0
						},
						format: 'DD MMM YYYY HH:mm'
					},
					{
						label: "Location",
						name: "nevxxth.id_nirxxmh",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/nirxxmh/nirxxmh_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_nirxxmh_old: id_nirxxmh_old,
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
						label: "Repeat",
						name: "nevxxth.is_repeat",
						type: "select",
						placeholder : "Select",
						options: [
							{ "label": "Yes", "value": 1 },
							{ "label": "No", "value": 0 }
						]
					},
					{
						label: "Repeat Every",
						name: "nevxxth.repeat_every"
					},
					{
						label: "Repeat Periode",
						name: "nevxxth.repeat_periode",
						type: "select",
						placeholder : "Select",
						options: [
							{ "label": "Day", "value": "Day" },
							{ "label": "Week", "value": "Week" },
							{ "label": "Month", "value": "Month" },
							{ "label": "Year", "value": "Year" }
						]
					},
					{
						label: "Cycle",
						name: "nevxxth.repeat_cycle"
					}
				]
			} );

			$('#btnCreate').on('click', function () {
				edtnevxxth
					.buttons({
						label: 'Save',
						fn: function () {
							this.submit();
						}
					})
					.create()
					.title('Create');
			});

			$('#btnEdit').on('click', function () {
				edtnevxxth
					.buttons({
						label: 'Save',
						fn: function () {
							this.submit();
						}
					})
					.edit()
					.title('Edit');
			});

			// edtnevxxth.on( 'preOpen', function( e, mode, action ) {
			// 	start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			// 	edtnevxxth.field('nevxxth.start_at').val(start_at);
				
			// 	if(action == 'create'){
			// 		tblnevxxth.rows().deselect();
			// 	}
			// });

			// edtnevxxth.on("open", function (e, mode, action) {
			// 	$(".modal-dialog").addClass("modal-lg");
			// });

            // edtnevxxth.on( 'preSubmit', function (e, data, action) {
			// 	if(action != 'remove'){

			// 		nama = edtnevxxth.field('nevxxth.nama').val();

			// 		validasiRequired(
			// 			edtnevxxth,
			// 			'nevxxth',
			// 			{
			// 				'nama': nama
			// 			}
			// 		);

			// 	}
				
			// 	if ( edtnevxxth.inError() ) {
			// 		return false;
			// 	}
			// });
			
			// edtnevxxth.on('initSubmit', function(e, action) {
			// 	finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			// 	edtnevxxth.field('nevxxth.finish_at').val(finish_at);
			// });

			// edtnevxxth.on( 'close', function () {
			// 	edtnevxxth.enable();
			// } );

			// BEGIN calendar
			// nevxxth_fn_load_calendar();
			// END calendar

			var calendarEl = $('#calendar')[0];
        	var calendar = new FullCalendar.Calendar(calendarEl, {
				initialView: 'dayGridMonth',
				headerToolbar: {
					start: 'custom1,custom2',
					center: 'title',
					end: 'dayGridMonth,timeGridWeek,timeGridDay'
				},
				footerToolbar: {
					start: '',
					center: '',
					end: 'prevYear,prev,next,nextYear'
				},
				customButtons: {
					custom1: {
						text: 'Create',
						click: function() {
							edtnevxxth
								.buttons({
									label: 'Save',
									fn: function () {
										this.submit();
									}
								})
								.create()
								.title('Create');
						}
					},
					custom2: {
						text: 'Edit',
						click: function() {
							edtnevxxth
								.buttons({
									label: 'Save',
									fn: function () {
										this.submit();
									}
								})
								.edit()
								.title('Edit');
						}
					}
				},
				contentHeight: 400,
				events: function(info, successCallback, failureCallback) {
					console.log(awal);
					$.ajax( {
						url: "../../models/nevxxth/nevxxth_fn_load_calendar.php",
						dataType: 'json',
						type: 'POST',
						data: {
							awal: awal,
							akhir: akhir 
						},
						success: function ( json ) {
							event_data = json.data.rs_nevxxth
							console.log(event_data);

							var events = json.data.rs_nevxxth.map(function(event) {
								return {
									title: event.title,
									start: event.start,
									end: event.end
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
