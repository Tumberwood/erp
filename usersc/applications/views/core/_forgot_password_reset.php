<?php
/*
this is a user-facing page
UserSpice 5
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>

<div class="row">
	<div class="col-12 col-sm-8 offeset-sm-1 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
		<h2 class="text-center">Hello <?=$ruser->data()->fname;?></h2>
		<p class="text-center"><?=lang("VER_PLEASE");?></p>
		<form action="" method="post">
			<?php if(!$errors=='') { display_errors($errors); } ?>
			<div class="form-group">
				<label for="password"><?=lang("PW_NEW");?>:</label>
				
				<div class="input-group" data-container="body">
					<input type="password" name="password" value="" id="password" class="form-control" autocomplete="new-password">
					
					<div class="input-group-append">
						<span class="input-group-text" id="show-password">
						<span class="fa fa-eye"></span>
						</span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="confirm"><?=lang("PW_CONF");?>:</label>
				<div class="input-group" data-container="body">
					<input type="password" name="confirm" value="" id="confirm" class="form-control" autocomplete='new-password'>
					
					<div class="input-group-append">
						<span class="input-group-text" id="show-confirm">
						<span class="fa fa-eye"></span>
						</span>
					</div>
				</div>
			</div>
			<input type="hidden" name="csrf" value="<?=Token::generate();?>">
			<input type="hidden" name="email" value="<?=$email;?>">
			<input type="hidden" name="vericode" value="<?=$vericode;?>">
			<input type="submit" name="resetPassword" value="<?=lang("GEN_RESET");?>" class="btn btn-primary">
		</form>
		<br />
	</div><!-- /.col -->
</div><!-- /.row -->

<?php 
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php'; 
?>

<script>
	$(document).ready(function() {
		$('#show-password').hover(function() {
			$('#password').attr('type', 'text');
		}, function() {
			$('#password').attr('type', 'password');
		});

		$('#show-confirm').hover(function() {
			$('#confirm').attr('type', 'text');
		}, function() {
			$('#confirm').attr('type', 'password');
		});
	});
</script>
