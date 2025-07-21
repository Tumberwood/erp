<!-- datatables main -->
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/DataTables/datatables.min.js"></script>

<!-- datatables 3rd party plugins -->
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/DataTables/absolute.js"></script>
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/DataTables/datatables.mark.js"></script>
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/DataTables/datetime-moment.js"></script>
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/DataTables/sum().js"></script>

<!-- datatables editor main -->
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/editor/dataTables.editor.min.js"></script>
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/editor/editor.bootstrap4.min.js"></script>

<!-- datatables editor plugins -->
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/editor/editor.select2.js"></script>
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/editor/editor.mask.js"></script>
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/editor/editor.quill.js"></script>

<!-- Instascan QR Scanner -->
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/editor_qr/instascan.min.js"></script>

<!-- DataTables Editor QR Plugin -->
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/editor_qr/editor.qr.js"></script>

<script>
// Setup Default for Datatables
// If you want to change the setup, please write individually on each page

var colCount;
var colvisCount;

$.fn.dataTable.moment('DD MMM YYYY');
$.fn.dataTable.moment('DD MMM YYYY HH:mm:ss');
$.fn.dataTable.moment('DD MMM YYYY HH:mm');

$.extend( true, $.fn.dataTable.Editor.defaults, {
	formOptions: {
		main: {
			focus: 4,
			onBackground: 'none'
		}
	}
} );

// dom
// P: SearchPanes 
// Q: SearchBuilder 
var dom0 = 
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'l>>" +
	"<'row'<'col-lg-6 col-md-12 col-sm-12 col-xs-12'B><'col-lg-6 col-md-6 col-sm-12 col-xs-12'f>>" +
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'tr>>" +
	"<'row'<'col-lg-5 col-md-5 col-sm-12 col-xs-12'i><'col-lg-7 col-md-7 col-sm-12 col-xs-12'p>>";

var domP = 
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'P>>" +
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'l>>" +
	"<'row'<'col-lg-6 col-md-12 col-sm-12 col-xs-12'B><'col-lg-6 col-md-6 col-sm-12 col-xs-12'f>>" +
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'tr>>" +
	"<'row'<'col-lg-5 col-md-5 col-sm-12 col-xs-12'i><'col-lg-7 col-md-7 col-sm-12 col-xs-12'p>>";

var domQ = 
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'Q>>" +
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'l>>" +
	"<'row'<'col-lg-6 col-md-12 col-sm-12 col-xs-12'B><'col-lg-6 col-md-6 col-sm-12 col-xs-12'f>>" +
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'tr>>" +
	"<'row'<'col-lg-5 col-md-5 col-sm-12 col-xs-12'i><'col-lg-7 col-md-7 col-sm-12 col-xs-12'p>>";

var domPQ = 
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'P>>" +
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'Q>>" +
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'l>>" +
	"<'row'<'col-lg-6 col-md-12 col-sm-12 col-xs-12'B><'col-lg-6 col-md-6 col-sm-12 col-xs-12'f>>" +
	"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'tr>>" +
	"<'row'<'col-lg-5 col-md-5 col-sm-12 col-xs-12'i><'col-lg-7 col-md-7 col-sm-12 col-xs-12'p>>";

// absolute sorting
var nullTop = $.fn.dataTable.absoluteOrder( [
    { value: null, position: 'top' }
] );

$.extend( true, $.fn.dataTable.defaults, {
	dom: dom0,
	lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
	pageLength: 10,
	language: {
		paginate: {
			first: "<<",
			previous: "<",
			next: ">",
			last: ">>"
		}
	},
	mark: true,
	select: true,
	processing: true,
	responsive: true,
	
	/**
	 * searchpanes 
	 * disetting di masing-masing halaman
	 */
	// searchPanes: {},	
	
	/**
	 * scroller
	 * di off kan sementara, karena ada bugs pada tab
	 */
	// scrollCollapse: true,
	// scrollY: 300,
    // scroller: {
    //     displayBuffer: 2,
	// 	loadingIndicator: true
    // },
	// scroller: true,
	// deferRender: true,
	
	colReorder: true,
	// stateSave: true,
	// fixedColumns: true,
	// fixedHeader: {
	// 	header: true
	// },
	
} );

$('table').on( 'init.dt', function () {
	colCount = $('table').DataTable().columns().header().length;
	var i;
	colvisCount = '0'
	for (i = 1; i < colCount; i++) { 
		colvisCount += "," + i;
	}

	$('table').DataTable().button( 'btnPrint:name' )
		.nodes()
		.css( 'display', 'none' );
	$('table').DataTable().button( 'btnPrintJurnal:name' )
		.nodes()
		.css( 'display', 'none' );
} );

</script>