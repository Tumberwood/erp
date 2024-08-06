

<script>
	// bug fix datatables tidak aligned antara header dan body saat dipasang di multitab
	// $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
	// 	$($.fn.dataTable.tables(true)).DataTable()
	// 	.columns.adjust();
	// });

	// bug fix select2 di buka di firefox tidak mau di klik
	$.fn.modal.Constructor.prototype.enforceFocus = function() {};
	
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	});
		
	// membuat left menu expand saat dipilih
	/** add active class and stay opened when selected */
	var url = window.location;

	// for side-menu
	$('ul.nav-second-level a').filter(function() {
		 return this.href == url;
	}).parentsUntil("#side-menu").addClass('active');
	// end of membuat left menu expand saat dipilih

	// BEGIN search menu
	var menuData = <?php echo json_encode($menu_data); ?>;
    function updateSearchResults(query) {
        if (query.trim() === "") {
            $(".non-search").show();
        } else {
            $(".non-search").hide();
        }

        $("#results").empty();

        var filteredData = menuData.filter(function (item) {
            return (
                query.trim() !== "" &&
                item.label.toLowerCase().includes(query.toLowerCase())
            );
        });

        filteredData.forEach(function (item) {
            var $listItem = $("<a class='menu-item' href='" + item.link + "'>" + item.label + "</a>");
            $("#results").append($listItem);
        });
    }

    $("#searchInput").on("input", function () {
        var query = $(this).val();
        updateSearchResults(query);
    });
	// END search menu

	// BEGIN Sidebar Auto close
	var sidebar 	= $("#main_nav"); 		//ini area sidebar
	var timesIcon 	= $("#close_sidebar"); 	//icon x di sidebar
	var btn_bar 	= $(".open_sidebar"); 	//ini icon bar tiga
	var is_sidebar_open = 0;

	//jika btn bar di click maka ada flag sidebar telah dibuka
	btn_bar.on("click", function () {
		is_sidebar_open = 1; //sidebar open
	});

	timesIcon.on("click", function () {
		is_sidebar_open = 0; //sidebar close
	});

	$(document).on("click", function (e) {
		//Jika sidebar open && target bulan btn_bar && tidak dalam sidebar && tidak diarea sidebar maka trigger tutup
		if (is_sidebar_open == 1 && !btn_bar.is(e.target) && !sidebar.is(e.target) && sidebar.has(e.target).length === 0) {
			timesIcon.click(); // Trigger click tombol x di sidebar
			is_sidebar_open = 0;
		} 
	});
	// END Sidebar Auto close

	// Enable/disable collapse menu
	$('#collapsemenu').click(function (){
		if ($('#collapsemenu').is(':checked')){
			$("body").addClass('mini-navbar');
			SmoothlyMenu();

			if (localStorageSupport){
				localStorage.setItem("collapse_menu",'on');
			}

		} else{
			$("body").removeClass('mini-navbar');
			SmoothlyMenu();

			if (localStorageSupport){
				localStorage.setItem("collapse_menu",'off');
			}
		}
	});

	// BEGIN Notifications
	var is_notification, notification_interval_ms;
	$.ajax( {
		url: '../../../helpers/fn_notification_setting.php',
		dataType: 'json',
		type: 'POST',
		async: false,
		data: {},
		success: function ( json ) {
			notification_interval_ms = json.data.rs_notification_interval_setting.notification_interval_ms;
			is_notification = json.data.rs_notification_interval_setting.is_notification;
		}
	} );

	function cekNotification(){
		// load notif
		$.ajax( {
			url: '../../../helpers/fn_notification_load.php',
			dataType: 'json',
			type: 'POST',
			data: {
				id_users: <?php echo $_SESSION['user']; ?>
			},
			success: function ( json ) {
				str = '';
				if( json.data.c_rs_notifications_unread > 0){
					$('#notifCount').show();
					$('#notifCount').html(json.data.c_rs_notifications_unread);
					tblnotifications.ajax.reload(null, false);
				}else{
					// $('#c_notification_unread').hide();
					$('#notifCount').hide();
					str='<li>No Unread Notification</li>';
				}
			
			}

		} );
	}
	// END Notifications

	toastr.options = {
		"closeButton": true,
		"debug": false,
		"newestOnTop": false,
		"progressBar": true,
		"positionClass": "toast-top-right",
		"preventDuplicates": false,
		"onclick": null,
		"showDuration": "300",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}

	// global variable
	var hak_c               = <?php echo json_encode($hak_c) ?>;
	var hak_u               = <?php echo json_encode($hak_u) ?>;
	var hak_d               = <?php echo json_encode($hak_d) ?>;
	var hak_a               = <?php echo json_encode($hak_a) ?>;
	var hak_e               = <?php echo json_encode($hak_e) ?>;
	var hak_p               = <?php echo json_encode($hak_p) ?>;
	
	// var is_master_table		= 0;	// jika master table, maka bisa edit meskipun sudah confirm
	var id_transaksi_log	= 0;
	var transaction_state	= 0;
	var approval_state 		= 0;
	var is_defaultprogram	= 0;
	var is_approve          = 0;	// status persetujuan transaksi
	var tr_status           = 0;	// status persetujuan transaksi
	var is_nextprocess      = 0;	// sudah ditarik ke proses selanjutnya atau belum
	// var is_jurnal 		    = 0;
	var is_valid_harga_d    = 0;
	// var is_need_generate_kode = 0;	// untuk generate kode saat approve
	// var is_need_delete	    = 1; 	
	// var is_need_approval    = 0;	// untuk cek apakah transaksi perlu approval atau tidak
	// var is_need_inventory   = 0;	// menentukan apakah transaksi terkait inventory atau tidak
	// var is_need_jurnal 	 	= 0;	// menentukan apakah transaksi terkait jurnal accounting atau tidak
	// var is_active 	  	    = 0;
	var kategori_dokumen	= '';
	var kategori_dokumen_value = '';

	// variable terkait setting default data
	// dipakai di helpers/fn_is_default_update.php
	var is_default_old = 0;
	var is_update_default = 0;
	var id_transaksi_default = 0;

	var act;	//pengganti action datatables editor, untuk dibawa ke dependent
	var is_pkp, is_ppn, persen_ppn, ppn_in_ex, is_pph, persen_pph, pph_in_ex;

	// BEGIN variable terkait moment.js
	// format web DD MMM YYYY, dipakai di datepicker
	var tanggal_hariini_dmy = moment().format('DD MMM YYYY');
	var awal_bulan_dmy 		= moment().startOf('month').format('DD MMM YYYY');
	var akhir_bulan_dmy 	= moment().endOf('month').format('DD MMM YYYY');
	var awal_tahun_dmy 		= moment().startOf('year').format('DD MMM YYYY');
	var akhir_tahun_dmy 	= moment().endOf('year').format('DD MMM YYYY');
	var today_sub_m_dmy		= moment().subtract(1, 'months').format('DD MMM YYYY');
	var today_add_m_dmy		= moment().add(1, 'months').format('DD MMM YYYY');

	var tanggaljam_hariini_dmy = moment().format("DD MMM YYYY HH:mm:ss");

	// format database YYYY-MM-DD, dipakai di untuk model
	var tanggal_hariini_ymd = moment().format('YYYY-MM-DD');
	var awal_bulan_ymd 		= moment().startOf('month').format('YYYY-MM-DD');
	var akhir_bulan_ymd 	= moment().endOf('tahun').format('YYYY-MM-DD');
	var awal_tahun_ymd 		= moment().startOf('tahun').format('YYYY-MM-DD');
	var akhir_tahun_ymd 	= moment().endOf('month').format('YYYY-MM-DD');
	var today_sub_m_ymd		= moment().subtract(1, 'months').format('YYYY-MM-DD');
	var today_add_m_ymd		= moment().add(1, 'months').format('YYYY-MM-DD');

	var tanggaljam_hariini_ymd = moment().format("YYYY-MM-DD HH:mm:ss");
	// END variable terkait moment.js

	// var imtxxmh_kode 		= 0; // untuk movement type

	// BEGIN default jquery-validator
	$.validator.setDefaults({
		errorPlacement: function(error, element) {
			// Kosongkan untuk mencegah penempatan pesan error di DOM
		},
		showErrors: function(errorMap, errorList) {
			if (errorList.length) {
				var errorMessages = [];
				$.each(errorList, function(index, error) {
					errorMessages.push(error.message);
				});				
				toastr.error(errorMessages.join("<br>"));
			}
			this.defaultShowErrors();
		},
		onfocusout: false, // Tidak memvalidasi saat focus hilang dari input
		onkeyup: false     // Tidak memvalidasi saat keyup di input
	});
	// END default jquery-validator

	// BEGIN datepicker init
	$('#periode').datepicker({
		setDate: new Date(),
		autoclose: true,
		todayHighlight: true,
		clearBtn: true,
		format: "dd M yyyy",
		minViewMode: 'month' 
	});
	$('#start_date').datepicker('setDate', awal_bulan_dmy);
	$('#end_date').datepicker('setDate', tanggal_hariini_dmy);
	// END datepicker init
	
	
	var edtnotifications, tblnotifications, show_inactive_status = 0, id_notifications;
	// END end of default variable

	var id_notifications = 0;
	var notifSpan = document.getElementById('notifCount');

	// Get the text content of the span
	var notifValue = notifSpan.textContent || notifSpan.innerText;
	
	$(document).ready(function() {
		// BEGIN notification
		
		if(is_notification == 1){
			$("#notification_parent").show();
			setInterval(cekNotification, notification_interval_ms);
			cekNotification();
		}else{
			$("#notification_parent").hide();
		}
		// END notification

		tblnotifications = $('#tblnotifications').DataTable( {
			ajax: {
				url: "../../../../usersc/applications/models/core/notifications.php",
				type: 'POST',
				data: function (d){
				}
			},
			// serverSide: true,
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "notifications.id",visible:false },
				{ data: "notifications.message" },
				{ data: "notifications.date_created" },
			],
			buttons: [
				{ 
					text: 'Mark as Read', 
					name: "btnMark",
					className: 'btn btn-primary', 
					titleAttr: 'Mark as Read',
					action: function ( e, dt, node, config ) {
						$.ajax( {
							url: '../../../../usersc/applications/models/core/notifications_fn_read.php',
							dataType: 'json',
							type: 'POST',
							data: {
								id_notifications: id_notifications,
							},
							success: function ( json ) {
								c_badge = json.badge;

								var notifSpan = document.getElementById('notifCount');
								notifSpan.textContent = c_badge; 

								// console.log('Updated notifCount:', notifSpan.textContent || notifSpan.innerText);

								tblnotifications.ajax.reload(null, false);
								tblnotifications.rows().deselect();
							}
						} );
						// console.log(id_notifications);
					}
				},
				{ 
					text: 'Mark All as Read', 
					name: "btnMarkAll",
					className: 'btn btn-danger', 
					titleAttr: 'Mark All as Read',
					action: function ( e, dt, node, config ) {
						message_transaction_state = "Apakah Anda Yakin Ingin Read All Notif?";
							
						swal({
							text: message_transaction_state,
							icon: "info",
							buttons: {
								cancel: true,
								confirm: true
							},
						})
						.then((willConfirm) => {
							if (willConfirm) {
								$.ajax( {
									url: '../../../../usersc/applications/models/core/notifications_fn_read_all.php',
									dataType: 'json',
									type: 'POST',
									data: {
									},
									success: function ( json ) {
										c_badge = json.badge;

										var notifSpan = document.getElementById('notifCount');
										notifSpan.textContent = c_badge; 

										// console.log('Updated notifCount:', notifSpan.textContent || notifSpan.innerText);

										tblnotifications.ajax.reload(null, false);
										tblnotifications.rows().deselect();
									}
								} );
							}
						});
						// console.log(id_notifications);
					}
				}
			]
			
		} );
		tblnotifications.button('btnMark:name').disable();

		tblnotifications.on( 'select', function( e, dt, type, indexes ) {
			notifications_data = tblnotifications.row( { selected: true } ).data().notifications;
			id_notifications = notifications_data.id;
			tblnotifications.button('btnMark:name').enable();
		} );

		tblnotifications.on( 'deselect', function () {
			id_notifications = 0;
			tblnotifications.button('btnMark:name').disable();
		} );

	} );// end of document.ready global

</script>