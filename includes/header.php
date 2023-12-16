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
        	<?php include_once("includes/side-bar.php"); ?>
        </div>
        <div class="col-xl-10 col-md-10 col-sm-10">
        <div class="card-header mainhead">
            <img src="images/nav.jpg" width="26" height="60" alt=""/> 
            <?php echo date("l jS \of F Y"); ?>
           <div class="profileWraper">
    			<img src="images/right-icon.jpg" width="85" height="64" alt="" class="float-right mr-0"/> 
				<ul class="profileNav">
					<li><a href="profile.php">Change Password</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</div> </div>
        <div class="col-xl-9 col-md-9 col-lg-9 col-sm-11">
        	
            <div class="toast-header">
            </div>