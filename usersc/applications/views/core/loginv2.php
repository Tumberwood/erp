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

    if (isset($_SESSION['user'])) {
        Redirect::to($us_url_root.'usersc/applications/views/core/dashboard.php');   
    }
?>

<style>
	body {
		background-color: #f2f2f3;
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
        <div class="row">
          <div class="col-sm-12">
          </div>
        </div>

    <h3><?=$settings->site_name?></h3>

  </div>
    
    <div class="loginColumns animated fadeInDown">
      <div class="row">

          <div class="col-md-6">
              <h2 class="font-bold">Welcome to IN+</h2>

              <p>
                  Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.
              </p>

              <p>
                  Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
              </p>

              <p>
                  When an unknown printer took a galley of type and scrambled it to make a type specimen book.
              </p>

              <p>
                  <small>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</small>
              </p>

          </div>
          <div class="col-md-6">
              <div class="ibox-content">
                  <form class="m-t" role="form" id="loginForm">
                      <div class="form-group">
                          <input id="username" type="text" class="form-control" placeholder="Username" required="">
                      </div>
                      <div class="form-group">
                          <input id="password" type="password" class="form-control" placeholder="Password" required="">
                      </div>
                      <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                      <a href="<?=$us_url_root?>usersc/applications/views/core/forgot_password.php">
                          <small>Forgot password?</small>
                      </a>

                      <p class="text-muted text-center">
                          <small>Do not have an account?</small>
                      </p>
                      <a class="btn btn-sm btn-white btn-block" href="register.php">Create an account</a>
                  </form>
                  <p class="m-t">
                      <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small>
                  </p>
              </div>
          </div>
      </div>
      <hr/>
      <div class="row">
          <div class="col-md-6">
              Copyright Example Company
          </div>
          <div class="col-md-6 text-right">
              <small>© 2014-2015</small>
          </div>
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
    url_root = <?php echo $us_url_root; ?>;
    $(document).ready(function() {
        var user_id = 0;
        $('#loginForm').submit(function(event) {
            event.preventDefault();

            var formData = new FormData(this);
            formData.append('action', 'login');
            formData.append('username', $('#username').val());
            formData.append('password', $('#password').val());
            // console.log($('#username').val());
            // console.log($('#password').val());

            $.ajax({
                type: 'POST',
                url: url_root+'/api/',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    console.log('Login successful');
                    console.log(response);
                    console.log(response.user_id);

                    user_id = response.user_id;
                    console.log("id_users : " + user_id );
                    // if(user_id == 1) {
                        window.location.href = "dashboard.php";
                    // }
                },
                error: function(xhr, status, error) {
                    console.log(status);
                    toastr["warning"]("Akun tidak ditemukan!!!","WARNING");
                    // alert('Akun tidak ditemukan!!!')
                }
            });
        });
    });

</script>

</body>