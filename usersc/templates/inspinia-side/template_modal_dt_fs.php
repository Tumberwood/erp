<?php $c_tabel_detail = count($nama_tabels_d);?>
<style>
	.modal-xxxl {
		max-width: 1250px;
		top: -10px;
	}
</style>

<div class="modal fade" id="modalP<?php echo $nama_tabel; ?>">
	<div class="modal-dialog modal-xxxl">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Filter</h4>
			</div>
			<div class="modal-body">
				<div id="sp<?php echo $nama_tabel; ?>"></div> 
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalQ<?php echo $nama_tabel; ?>">
	<div class="modal-dialog modal-xxxl">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Search</h4>
			</div>
			<!-- pane8 -->
			<div class="modal-body">
                <div id="sb<?php echo $nama_tabel; ?>"></div> 
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<?php for ($i=0; $i < $c_tabel_detail; $i++) { ?>
    <div class="modal fade" id="modalP<?php echo $nama_tabels_d[$i]; ?>">
        <div class="modal-dialog modal-xxxl">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <h4 class="modal-title">Filter</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="sp<?php echo $nama_tabels_d[$i]; ?>"></div> 
                </div>
                <div class="modal-footer">
					<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalQ<?php echo $nama_tabels_d[$i]; ?>">
        <div class="modal-dialog modal-xxxl">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <h4 class="modal-title">Search</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- pane8 -->
                <div class="modal-body">
                    <div id="sb<?php echo $nama_tabels_d[$i]; ?>"></div> 
                </div>
                <div class="modal-footer">
					<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
