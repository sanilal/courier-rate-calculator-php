<?php  
error_reporting(0);
ob_start();
session_start();
if(!isset($_SESSION['user_id'])){
	header("Location: logout.php");
	echo "<script type='text/javascript'>window.top.location='logout.php';</script>";
	exit;
}
else if($_SESSION['user_id']=="" || $_SESSION['user_id']==NULL){
	header("Location: logout.php");
	echo "<script type='text/javascript'>window.top.location='logout.php';</script>";
	exit;
}
include("includes/conn.php"); 
 if(isset($_REQUEST['btnadd'])){
	 
	$country=$_GET['country'];	
	$code=$_GET['country_code'];
	
	$msg=""; $error="";
	if($country!=""){
		//
		
		  $query = "INSERT INTO `".TB_pre."countries` (`name`,`code`) VALUES('$country','$code')";
		  //var_dump($query); exit;
		  $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  $msg.= "Country Successfully Added";
		  }
		  else {
			  $error.= "Failed: Error occured";
		  }
	  
	}
	else {
			  $error.= "Failed: Fill all the required fields";
		  }
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link href="css/style.css" rel="stylesheet" type="text/css">
<title>Meridian</title>

</head>

<body>

<div class="container-fluid">
	<div class="row">
    	<div class="col-xl-2 col-md-2 col-lg-3 col-sm-3">
        	<?php include("includes/side-bar.php"); ?>
        </div>
        
        <div class="col-xl-10 col-md-10 col-sm-10">
        <div class="card-header mainhead">
            <img src="images/nav.jpg" width="26" height="60" alt=""/> 
            <?php echo date("l jS \of F Y"); ?>
            <img src="images/right-icon.jpg" width="85" height="64" alt="" class="float-right mr-0"/> </div>
        <div class="col-xl-9 col-md-9 col-lg-9 col-sm-11">
        	
            <div class="toast-header">
            </div>
        	<h3>Edit Country</h3>
        	<div class="box-header with-border">
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
        	<form method="get" action="<?php echo $_SERVER['PHP_SELF']?>" id="editrate">
          			<div class="row">
						<div class="col-md-4 col-sm-12">
                            <label for="country">Country</label>
                            <input type="text" name="country" id="country" placeholder="Enter Country Name: Example Afghanistan" />
                            <div id="errorMessageCountry"></div>
                        </div>
						<div class="col-md-4 col-sm-12">
                            <label for="country_code">Country Code</label>
                            <input type="text" name="country_code" id="country_code" placeholder="Enter Country Code: Example AF" />
							<div id="errorMessage"></div>
                        </div>
						<div class="col-md-4 col-sm-12">
                            <input type="submit" name="btnadd" value="Add Country" id="addCountry" class="float-left" disabled >
						</div>
						
                        
                    </div>
					
			




            
        </div></div>
        <div class="col-xl-2 col-md-2 col-lg-3 col-sm-3"></div>
    </div>
</div>
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
	$(document).ready(function(){
		
		  var ajaxRequest;
		  $('#country_code').keyup(function() {
			var value = $(this).val();
			clearTimeout(ajaxRequest);
			ajaxRequest = setTimeout(function(sn) {
			  $.ajax({
				type: 'post',
				url: 'ajax-country-check.php',
				data: 'code=' + value,
				success: function(r) {
				  $('#errorMessage').html(r);
				  $('#addCountry').removeAttr("disabled");
				}
			  });
			}, 500, value);
		  });

		$('.checkanother').click(function(){
			window.location.href = "index.php";

		})
	})
	
</script>
</body>
</html>