
	<div id="notificationsModal" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="notification_type">New Notifications</h4>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-12"> 
						<div class="ibox float-e-margins">
							<div class="ibox-content">
									<table id="tblnotifications" class="table table-striped table-bordered table-hover responsive" width="100%">
										<thead>
											<tr>
												<th>ID</th>
												<th>Pesan</th>
												<th>Tanggal Dibuat</th>
											</tr>
										</thead>
									</table>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>

	<script type="text/javascript">
		// BEGIN default variable, do not erase
		var edtnotifications, tblnotifications, show_inactive_status = 0, id_notifications;
		// END end of default variable

		var id_notifications = 0;
		var notifSpan = document.getElementById('notifCount');

		// Get the text content of the span
		var notifValue = notifSpan.textContent || notifSpan.innerText;

		// Output the value
		// console.log(notifValue);
		function displayNotifications(new_all) {
		}

		$(document).ready(function() {
			//start datatables
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
		} );// end of document.ready
	
	</script>
