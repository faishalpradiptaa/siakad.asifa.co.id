<!DOCTYPE html>
<html>
<head>
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <title>SIAKAD ASIFA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Font CSS (Via CDN) -->
  <!--link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'-->

  <!-- Theme CSS -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/skin/default_skin/css/theme.css'); ?>">

  <!-- Admin Forms CSS -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin-tools/admin-forms/css/admin-forms.css'); ?>">

  <!-- Favicon -->
  <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico'); ?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
  <?php
  //cegah tombol back setelah login
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
  header('Content-Type: text/html');
   ?>
	<style>
		.logo, .logo:hover, .logo:active, .logo:visited {
			color: #fff;
			text-decoration: none;
			font-size: 30px;
		}
		.modal-loading{
			padding: 20px;
			text-align: center;
		}
	</style>

</head>

<body class="external-page sb-l-c sb-r-c">

  <!-- Start: Main -->
  <div id="main" class="animated fadeIn">

    <!-- Start: Content-Wrapper -->
    <section id="content_wrapper">

      <!-- begin canvas animation bg -->
      <div id="canvas-wrapper">
        <canvas id="demo-canvas"></canvas>
      </div>

      <!-- Begin: Content -->
      <section id="content">

        <div class="admin-form theme-info" id="login1">

          <div class="row mb15 table-layout">
            <div class="col-xs-12 va-m pln text-center">
              <a href="<?php echo base_url(); ?>" class="logo">
                <img src="assets/custom/img/logo-small.png" style="max-width:50%;height:auto;width:auto">
                <!--img src="<?php //echo base_url('assets/custom/img/logo-small.png'); ?>" title="Logo" class="img-responsive"-->
								SIAKAD ASIFA
              </a>
            </div>
          </div>

          <div class="panel panel-info mt10 br-n">

            <div class="panel-heading heading-border bg-white">
            </div>

            <!-- end .form-header section -->
            <form method="post" action="<?php echo site_url('login'); ?>">
              <div class="panel-body bg-light p30">
								<?php
									$error = $this->session->flashdata('result_login');
									$username = $this->session->flashdata('username');
									if($error) {
								?>
								<div class="alert alert-sm alert-border-left alert-danger alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<i class="fa fa-exclamation-triangle pr10"></i> <?php echo $error; ?>
								</div>
								<?php } ?>

                <div class="row">
                  <div class="col-sm-5 pr30">

										<div class="section">
                      <label for="username" class="field-label text-muted fs18 mb10">No. Induk</label>
                      <label for="username" class="field prepend-icon">
												<input type="text" name="user_username" id="username" class="gui-input" placeholder="Masukkan No. Induk" value="<?php echo $username; ?>" required autofocus>
                        <label for="username" class="field-icon">
                          <i class="fa fa-user"></i>
                        </label>
                      </label>
                    </div>
                    <!-- end section -->

                    <div class="section">
                      <label for="username" class="field-label text-muted fs18 mb10">Password</label>
                      <label for="password" class="field prepend-icon">
                        <input type="password" name="user_password" id="password" class="gui-input" placeholder="Masukkan password" required>
                        <label for="password" class="field-icon">
                          <i class="fa fa-lock"></i>
                        </label>
                      </label>
                    </div>

                    <div class="section">
                        <button type="submit" class="button btn-primary form-control fs18 mb10" onClick="saveUP()" id="signin">Sign In</button>
                    </div>
                    <!-- end section -->
                  </div>



									<div class="col-sm-7 br-l br-grey pl00">
										<div class="panel-body pn" style="overflow: auto; height: 200px; width: auto;">
											<table class="table mbn tc-med-1 tc-bold-last tc-fs13-last">
												<thead>
													<tr class="hidden">
														<th>Source</th>
														<th>Count</th>
													</tr>
												</thead>
												<tbody style="overflow-y: scroll;height: 200px;">
<?php
                            if(is_array($pengumuman)) foreach($pengumuman as $row)
                              {
?>
													<tr>
                            <td class="visible-md visible-lg">
                              <span class="<?php echo $row->icon; ?> text-alert fs14 mr10"></span>
														</td>
                            <td width="70%">
															<span>
																<a data-toggle="modal" data-target="#main-modal-lg" data-effect="mfp-zoomOut" href="<?php echo site_url('pengumuman/'.$row->id_pengumuman); ?>" style="text-decoration: none;font-family: Open Sans, Helvetica, Arial, sans-serif;font-size: 13px;color: #39545B;">
<?php
                                echo $row->judul;
?>
																</a>
															</span>
														</td>
														<td style="color: #E8BE0C;" width="40%">
<?php
                              echo date('d M Y', strtotime($row->publish_date));
?>
                            </td>
													</tr>
<?php
                            }
?>
												</tbody>
											</table>
										</div>

									</div>
                </div>
              </div>
              <!-- end .form-body section -->
              <div class="panel-footer clearfix p10 ph15">

                <!--label  BUTTON SIGN IN class="switch ib switch-primary pull-left input-align mt10">
                  <input type="checkbox" name="remember" id="remember" checked style="background:#9999A3">
                  <label for="remember" data-on="YES" data-off="NO"></label>
                  <span>Remember me</span>
                </label-->
              </div>
              <!-- end .form-footer section -->
            </form>
          </div>
        </div>

      </section>
      <!-- End: Content -->

    </section>
    <!-- End: Content-Wrapper -->

  </div>
  <!-- End: Main -->

	<!-- BEGIN MODAl -->
	<div id="main-modal-lg" class="modal fade">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-loading"><i class="fa fa-refresh fa-spin"></i>&nbsp; Loading Data</div>
			</div>
		</div>
	</div>
	<!-- END MODAL -->


  <!-- BEGIN: PAGE SCRIPTS -->

  <!-- jQuery -->
  <script src="<?php echo base_url('assets/vendor/jquery/jquery-1.11.1.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/vendor/jquery/jquery_ui/jquery-ui.min.js'); ?>"></script>
  <script type="text/javascript">
    function saveUP() {
        var u = document.getElementById("username").value;
        var p = document.getElementById("password").value;
        Android.saveUP(u,p);
    }
  </script>

  <!-- CanvasBG Plugin(creates mousehover effect) -->
  <script src="<?php echo base_url('assets/vendor/plugins/canvasbg/canvasbg.js'); ?>"></script>

  <!-- Theme Javascript -->
  <script src="<?php echo base_url('assets/js/utility/utility.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/demo/demo.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/main.js'); ?>"></script>

  <!-- Page Javascript -->
  <script type="text/javascript">
  jQuery(document).ready(function() {
    "use strict";
    // Init Theme Core
    Core.init();
    // Init Demo JS
    Demo.init();

		$('body').on('hidden.bs.modal', '#main-modal-lg, #main-modal-md', function () {
			$(this).removeData('bs.modal');
			$(this).find('.modal-content').html('<div class="modal-loading"><i class="fa fa-refresh fa-spin"></i>&nbsp; Loading Data</div>')
		});

		$("body").on("shown.bs.modal", '#main-modal-lg, #main-modal-md', function(e) {
			$(this).find('.form-control').first().focus();
		});
  });
  </script>

  <!-- END: PAGE SCRIPTS -->

</body>

</html>
