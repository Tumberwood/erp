<?php
    ini_set("allow_url_fopen", 1);
    require_once '../../../../users/init.php';
    // require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    require_once $abs_us_root.$us_url_root.'usersc/templates/' . $settings->template . '/header.php';
    
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
	$qs_ggsxxsh 		= $db->query("SELECT files.web_path as url_logo, posisi_logo_login FROM ggsxxsh LEFT JOIN files ON files.id = ggsxxsh.id_files_company_logo");
	$rs_ggsxxsh	= $qs_ggsxxsh->first();
  $_SESSION['company_logo'] = $rs_ggsxxsh->url_logo;
?>

<style>
	body {
		background-color: #f2f2f3;
	}
    #regis {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

<body class="gray-bg">
  <div class="middle-box text-center loginscreen animated fadeInDown">
    <h3>Welcome to </h3>
    <?php 
      if($rs_ggsxxsh->posisi_logo_login == 1){
    ?>
        <img class="text-center" style="width:100%" src="<?php echo $rs_ggsxxsh->url_logo;?>"></img>    
    <?php 
    }
    ?>

    <h3><?=$settings->site_name?></h3>

  </div>

    <div class="row text-center loginscreen  animated fadeInDown" id="regis">
        <div>
            <form class="m-t" role="form" id="registerForm">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="First Name" id="fname" required="">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Last Name" id="lname" required="">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Username" id="username" required="">
                            <span class="text-danger" id="err_username"></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Email" id="email" required="">
                            <span class="text-danger" id="err_email"></span>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>
                            Password (<?php echo $settings->min_pw; ?>-<?php echo $settings->max_pw; ?> chars)
                            </label>

                            <div class="input-group" data-container="body">
                                <input class="form-control" type="password" name="password" id="password" <?php if ($settings->force_pr == 1) { ?> value="<?php echo $random_password; ?>" readonly<?php } ?> placeholder="Password" required autocomplete="off" aria-describedby="passwordhelp">
                                
                                <div class="input-group-append">
						            <span class="input-group-text" id="show-password">
                                    <span class="fa fa-eye"></span>
                                    </span>
                                </div>
                            </div>
                            <span class="text-danger" id="err_password"></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <div class="input-group" data-container="body">
                            <input type="password" id="confirm" name="confirm" <?php if ($settings->force_pr == 1) { ?> value="<?php echo $random_password; ?>" readonly <?php } ?> class="form-control" autocomplete="off" placeholder="Confirm Password" required>
                            <div class="input-group-prepend">
						        <span class="input-group-text" id="show-confirm">
                                <span class="fa fa-eye"></span>
                                </span>
                            </div>

                            <?php if ($settings->force_pr == 1) { ?>
                                <div class="input-group-append">
                                <span class="input-group-text" id="addon2">
                                    <a class="nounderline pwpopover" data-container="body" data-toggle="popover" data-placement="top" title="Why can't I edit this?" data-bs-toggle="tooltip" title="The Administrator has manual creation password resets enabled. If you choose to send an email to this user, it will supply them with the password reset link and let them know they have an account. If you choose to not, you should manually supply them with this password (discouraged).">
                                    <i class="fa fa-question"></i>
                                    </a>
                                </span>
                                </div>
                            <?php } ?>
                            </div>
                            <span class="text-danger" id="err_confirm"></span>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="checkbox i-checks">
                        <label>
                            <input type="checkbox" id="agreeCheckbox"><i></i> Agree to the terms and policy
                        </label>
                    </div>
                </div>

                <button type="submit" id="submitForm" class="btn btn-primary block full-width m-b" disabled>Register</button>

                <p class="text-muted text-center"><small>Already have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="login.php">Login</a>
            </form>
            <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
        </div>
    </div>
        
		<br>
		
    <br>
    <br>
    <br>

    <?php 
      if($rs_ggsxxsh->posisi_logo_login == 2){
    ?>
        <img class="text-center" style="width:100%" src="<?php echo $rs_ggsxxsh->url_logo;?>"></img>    
    <?php 
      }
    ?>
    
	</div>

    <?php require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php'; ?>
    
<script>
  $(document).ready(function() {
    url_root = <?php echo $us_url_root; ?>;
    
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

    $('#submitForm').prop('disabled', true); // Disable submit button initially

    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
        increaseArea: '20%'
    });

    $('#agreeCheckbox').on('ifChanged', function() {
        if ($(this).is(':checked')) {
            $('#submitForm').prop('disabled', false);
        } else {
            $('#submitForm').prop('disabled', true);
        }
    });

    $('#registerForm').submit(function(event) {
        event.preventDefault();
        $('#err_username').empty();
        $('#err_email').empty();
        $('#err_password').empty();
        $('#err_confirm').empty();

        var password = $('#password').val();
        var confirm = $('#confirm').val();

        if (confirm == password) {
            var formData = new FormData(this);
            formData.append('action', 'join');
            formData.append('fname', $('#fname').val());
            formData.append('lname', $('#lname').val());
            formData.append('username', $('#username').val());
            formData.append('password', password);
            formData.append('email', $('#email').val());

            $.ajax({
                type: 'POST',
                url: url_root+'/api/',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    toastr["success"]("Berhasil Melakukan Registrasi","INFO")

                    $('#fname').val('')
                    $('#lname').val('')
                    $('#email').val('')
                    $('#password').val('')
                    $('#confirm').val('')
                    $('#username').val('')
                    console.log(response);
                    console.log(response.apikey);

                    var apikey = response.apikey;
                    window.location.href = "<?=$us_url_root?>usersc/applications/views/core/verify_resend.php";
                },
                error: function(xhr, status, error) {

                    console.log(xhr.responseJSON.userMessage);
                    error_msg = xhr.responseJSON.userMessage;

                    error_msg.forEach(err_msg => {
                        console.log(err_msg.danger);
                        let err_validasi = err_msg.danger;
                        if (err_validasi.includes("Username")) {
                            $('#err_username').html(err_validasi);
                        }

                        if (err_validasi.includes("Email")) {
                            $('#err_email').html(err_validasi);
                        }

                        if (err_validasi.includes("Password")) {
                            $('#err_password').html(err_validasi);
                        }
                    });

                }
            });
        } else {
            $('#err_confirm').html('Confirm Password harus sama dengan password yang dimasukkan');
        }
    });
});

</script>

</body>