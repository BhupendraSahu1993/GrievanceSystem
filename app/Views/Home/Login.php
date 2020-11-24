<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Grievance System | Login</title>

  <!-- Bootstrap -->
  <link href="<?php echo base_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="<?php echo base_url('assets/vendors/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
  <!-- NProgress -->
  <link href="<?php echo base_url('assets/vendors/nprogress/nprogress.css');?>" rel="stylesheet">
  <!-- Animate.css -->
  <link href="<?php echo base_url('assets/vendors/animate.css/animate.min.css');?>" rel="stylesheet">
  <!-- iCheck -->
  <link href="<?php echo base_url('assets/vendors/iCheck/skins/flat/green.css');?>" rel="stylesheet">
  <!-- bootstrap-wysiwyg -->
  <link href="<?php echo base_url('assets/vendors/google-code-prettify/bin/prettify.min.css');?>" rel="stylesheet">
  <!-- Select2 -->
  <link href="<?php echo base_url('assets/vendors/select2/dist/css/select2.min.css');?>" rel="stylesheet">
  <!-- Switchery -->
  <link href="<?php echo base_url('assets/vendors/switchery/dist/switchery.min.css');?>" rel="stylesheet">
  <!-- starrr -->
  <link href="<?php echo base_url('assets/vendors/starrr/dist/starrr.css');?>" rel="stylesheet">
  <!-- bootstrap-daterangepicker -->
  <link href="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.css');?>" rel="stylesheet">
  <!-- Custom Theme Style -->
  <link href="<?php echo base_url('assets/build/css/custom.min.css');?>" rel="stylesheet">
</head>

<body class="login">
  <div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper" style="margin-top:0;">
      <div class="animate form login_form">
        <section class="login_content" style="margin-top:50%;">
        <?php if (session('msg')) : ?>
          <div class="alert alert-danger alert-dismissible">
            <?= session('msg') ?>
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
          </div>
        <?php endif ?>
          <form action="<?php echo base_url('home/login_user');?>" method="post">
            <h1>Login Form</h1>
            <div>
              <input type="text" name="uname" class="form-control" placeholder="Username" required="" />
            </div>
            <div>
              <input type="password" name="pass" class="form-control" placeholder="Password" required="" />
            </div>
            <div>
              <input type="submit" class="btn btn-primary btn-sm" value="Log In">
              <!-- <a class="btn btn-default submit" href="index.html">Log in</a> -->
              <a class="reset_pass" href="#">Lost your password?</a>
            </div>

            <div class="clearfix"></div>

            <div class="separator">
              <p class="change_link">New to site?
                <a href="#signup" class="to_register"> Create Account </a>
              </p>

              <div class="clearfix"></div>
              <br />

              <div>
                <h1> Grievance System </h1>
                <p>©2020 All Rights Reserved. ChiPS</p>
              </div>
            </div>
          </form>
        </section>
      </div>

      <div id="register" class="animate form registration_form">
        <section class="login_content">
          <form action="<?php echo base_url('home/register_user');?>" method="post" id="demo-form2"
            data-parsley-validate class="form-horizontal form-label-left">
            <h1>Create Account</h1>
            <div>
              <input id="Name" name="Name" type="text" class="form-control" placeholder="Name" required="required" />
            </div>
            <div>
              <input id="Mobile" name="Mobile" type="text" class="form-control" placeholder="Mobile"
                required="required" />
            </div>

            <div>
              <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-secondary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" name="Gender_id" value="1" class="join-btn"> &nbsp; Male &nbsp;
                </label>
                <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" name="Gender_id" value="2" class="join-btn"> Female
                </label>
                <label class="btn btn-secondary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" name="Gender_id" value="3" class="join-btn"> Other
                </label>
              </div>
            </div>
            <br>
            <div>
              <select id="Dept_Id" name="Dept_Id" class="form-control" required="">
                <option value="0">-- Select Department --</option>
                <?php foreach($Department AS $items): ?>
                <option value="<?= $items['Dept_Id'] ?>"><?= $items['Dept_Name'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <br>
            <div>
              <select id="Desg_Id" name="Desg_Id" class="form-control" required="">
                <option value="0">-- Select Designation --</option>
                <?php foreach($Designation AS $items): ?>
                <option value="<?= $items['Desig_Id'] ?>"><?= $items['Desig_Name'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <br>
            <div>
              <select id="Dist_Id" name="Dist_Id" class="form-control" required="">
                <option value="0">-- Select District --</option>
                <option value="1">Press</option>
                <option value="2">Internet</option>
                <option value="3">Word of mouth</option>
              </select>
            </div>
            <br>
            <div>
              <select id="City_Id" name="City_Id" class="form-control" required="">
                <option value="0">-- Select City --</option>
                <option value="1">Press</option>
                <option value="2">Internet</option>
                <option value="3">Word of mouth</option>
              </select>
            </div>
            <br>
            <div>
              <textarea id="Address" name="Address" required="required" class="form-control"
                placeholder="Enter address here..." name="message" data-parsley-trigger="keyup"
                data-parsley-minlength="20" data-parsley-maxlength="100"
                data-parsley-minlength-message="Write the complaint reason"
                data-parsley-validation-threshold="10"></textarea>
            </div>
            <br>
            <div>
              <input type="submit" class="form-control btn btn-primary" style="margin-left:0;" value="Submit">
              <!-- <a class="btn btn-primary submit" href="index.html">Submit</a> -->
            </div>

            <div class="clearfix"></div>

            <div class="separator">
              <p class="change_link">Already a member ?
                <a href="#signin" class="to_register"> Log in </a>
              </p>

              <div class="clearfix"></div>
              <br />

              <div>
                <h1> Grievance System </h1>
                <p>©2020 All Rights Reserved. ChiPS</p>
              </div>
            </div>
          </form>
        </section>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="<?php echo base_url('assets/vendors/jquery/dist/jquery.min.js');?>"></script>
  <!-- Bootstrap -->
  <script src="<?php echo base_url('assets/vendors/bootstrap/dist/js/bootstrap.bundle.min.js');?>"></script>
  <!-- FastClick -->
  <script src="<?php echo base_url('assets/vendors/fastclick/lib/fastclick.js');?>"></script>
  <!-- NProgress -->
  <script src="<?php echo base_url('assets/vendors/nprogress/nprogress.js');?>"></script>
  <!-- bootstrap-progressbar -->
  <script src="<?php echo base_url('assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js');?>"></script>
  <!-- iCheck -->
  <script src="<?php echo base_url('assets/vendors/iCheck/icheck.min.js');?>"></script>
  <!-- bootstrap-daterangepicker -->
  <script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
  <script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js');?>"></script>
  <!-- bootstrap-wysiwyg -->
  <script src="<?php echo base_url('assets/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js');?>"></script>
  <script src="<?php echo base_url('assets/vendors/jquery.hotkeys/jquery.hotkeys.js');?>"></script>
  <script src="<?php echo base_url('assets/vendors/google-code-prettify/src/prettify.js');?>"></script>
  <!-- jQuery Tags Input -->
  <script src="<?php echo base_url('assets/vendors/jquery.tagsinput/src/jquery.tagsinput.js');?>"></script>
  <!-- Switchery -->
  <script src="<?php echo base_url('assets/vendors/switchery/dist/switchery.min.js');?>"></script>
  <!-- Select2 -->
  <script src="<?php echo base_url('assets/vendors/select2/dist/js/select2.full.min.js');?>"></script>
  <!-- Parsley -->
  <script src="<?php echo base_url('assets/vendors/parsleyjs/dist/parsley.min.js');?>"></script>
  <!-- Autosize -->
  <script src="<?php echo base_url('assets/vendors/autosize/dist/autosize.min.js');?>"></script>
  <!-- jQuery autocomplete -->
  <script src="<?php echo base_url('assets/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js');?>">
  </script>
  <!-- starrr -->
  <script src="<?php echo base_url('assets/vendors/starrr/dist/starrr.js');?>"></script>
  <!-- Custom Theme Scripts -->
  <script src="<?php echo base_url('assets/build/js/custom.min.js');?>"></script>

  <script>
    $(document).ready(function () {
      $("#Confirm_Password").keyup(function () {
        var pass = $("#Password").val();
        var cpass = $("#Confirm_Password").val();
        if (pass != cpass) {
          $("#error_msg").show();
        } else {
          $("#error_msg").hide();
        }
      })
    });
  </script>
</body>

</html>