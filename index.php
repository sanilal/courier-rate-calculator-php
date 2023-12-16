<?php  
error_reporting(0);
ob_start();
session_start();
include("includes/conn.php"); 
$msg = "";
//var_dump(tb_pre); exit;
if($_POST){
	$email = mysqli_real_escape_string($url, $_POST['email']);
	$pass = mysqli_real_escape_string($url, $_POST['password']);
	$pass=md5($pass);
	if($email && $pass){
		$query = "SELECT * FROM `".TB_pre."admin` WHERE `email`='$email' AND `password`='$pass'";
		$r = mysqli_query($url, $query) or die(mysqli_error($url));
		if(mysqli_num_rows($r) == 1){
			$_SESSION["logged"] = "true";
			$res=mysqli_fetch_object($r);
			$_SESSION['user_id']=$res->id;
            $_SESSION['admin_role']=$res->admin_role;
			$_SESSION['last_login']=$res->last_login;
			mysqli_query($url, "UPDATE `".TB_pre."admin` SET last_login='".date("Y-m-d H:i:s")."' WHERE id=".$_SESSION['user_id']);
			header("location:home.php");
		}
		else{
			$msg = "Invalid Email or Password";
		}
	}
	else{
		$msg = "Please enter email and password";
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="plugins/iCheck/square/blue.css">
<title>Meridian</title>
</head>
<body>
<div class="container-fluid">
  <div class="login-box">
      <div class="login-logo">
	    <img src="images/logo.jpg" class="img-fluid adminLogo" alt=""/>
<!--<a href="#"><b>Meridian </b> Admin</a>-->
    </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in</p>
          <?php if($msg){ ?>
                 	<p class="alert alert-danger"><?php echo $msg; ?></p>
                 <?php } ?>
        <form action="index.php" method="post">
          <div class="form-group has-feedback">
            <input type="text" name="email" class="form-control" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>

        
        <?php /*?><a href="#">I forgot my password</a><br><?php */?>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
</div>
<script src="js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="js/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
</body>
</html>
<?php ob_end_flush(); ?>