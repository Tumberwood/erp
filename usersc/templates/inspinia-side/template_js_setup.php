<script>
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

	// global variable
	var hak_c               = <?php echo json_encode($hak_c) ?>;
	var hak_u               = <?php echo json_encode($hak_u) ?>;
	var hak_d               = <?php echo json_encode($hak_d) ?>;
	var hak_a               = <?php echo json_encode($hak_a) ?>;
	
	var is_master_table		= 0;	// jika master table, maka bisa edit meskipun sudah confirm
	var id_transaksi_log	= 0;
	var transaction_state	= 0;
	var approval_state 		= 0;
	var is_defaultprogram	= 0;
	var is_approve          = 0;	// status persetujuan transaksi
	var tr_status           = 0;	// status persetujuan transaksi
	var is_nextprocess      = 0;	// sudah ditarik ke proses selanjutnya atau belum
	var is_jurnal 		    = 0;
	var is_valid_harga_d    = 0;
	var is_need_generate_kode = 0;	// untuk generate kode saat approve
	var is_need_delete	    = 1; 	
	var is_need_approval    = 0;	// untuk cek apakah transaksi perlu approval atau tidak
	var is_need_inventory   = 0;	// menentukan apakah transaksi terkait inventory atau tidak
	var is_need_jurnal 	 	= 0;	// menentukan apakah transaksi terkait jurnal accounting atau tidak
	var is_active 	  	    = 0;
	var kategori_dokumen	= '';
	var kategori_dokumen_value = '';

	var act;	//pengganti action datatables editor, untuk dibawa ke dependent
	var is_pkp, is_ppn, persen_ppn, ppn_in_ex, is_pph, persen_pph, pph_in_ex;

	var tanggal_hariini_dmy = moment().format('DD MMM YYYY');
	var awal_bulan_dmy 		= moment().startOf('month').format('DD MMM YYYY');
	var akhir_bulan_dmy 	= moment().endOf('month').format('DD MMM YYYY');

	var tanggal_hariini_ymd = moment().format('YYYY-MM-DD');
	var awal_bulan_ymd 		= moment().startOf('month').format('YYYY-MM-DD');
	var akhir_bulan_ymd 	= moment().endOf('month').format('YYYY-MM-DD');

	var imtxxmh_kode 		= 0; // untuk movement type

</script>