<?php $active="home"; ?>


      <!-- =============================================== -->
<?php
ob_start();
include("includes/conn.php"); 
include("includes/head.php");
include("includes/header.php");
//
	if(isset($_POST['password'])){
		$msg=""; $error="";
		if($_POST['password']!=""){
			//
			if($_POST['password']!=""){
				$pass = mysqli_real_escape_string($url, $_POST['password']);
				$pass=md5($pass);
				$userId=$_SESSION['user_id'];
				$query = "UPDATE `".TB_pre."admin` SET `password` = '".$pass."' WHERE id=$userId";
				$r = mysqli_query($url, $query) or die(mysqli_error($url));
				if($r){
					  $msg.= "Login password updated successfully";
				 }
				 else {
					  $error.= "Failed: Error occured";
				 }
			}
		}
		else{
			$error="Error: Password can't be blank";
		}
	}
//
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Profile
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Update Password</h3>
              
              <?php if(isset($msg)){ if($msg!=""){ ?>
              	<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> <?php echo $msg; ?></h4>
                    
               	</div>
               <?php }} ?> 
               <?php if(isset($error)){ if($error!=""){ ?>
              	<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> <?php echo $error; ?></h4>
                    
               	</div>
               <?php } } ?> 
              
            </div>
            <form action="" method="post">
            <div class="box-body">
              
                <div class="form-group">
                      <label> Password</label>
                      <input type="password" name="password" value="password" required />
                    </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <input type="submit" name="submit" value="Update" class="btn btn-primary" />
            </div><!-- /.box-footer-->
            </form>
          </div><!-- /.box -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

 <?php include_once('includes/footer.php'); ?>
 </body>
</html>
<?php ob_end_flush(); ?>