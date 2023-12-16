<?php  
include("includes/conn.php"); 
include("includes/head.php"); 
if(isset($_GET['cid'])){
	if(isset($_REQUEST['update'])){
	 
	$countryname=$_GET['country'];
	$countrycode=$_GET['country_code'];
		
	$fedex_country_export_949_q=mysqli_query($url,"SELECT * FROM `".TB_pre."fedex_export_949_zone_mapping` WHERE `code`='$countrycode'");
	$dhl_export_zone_mapping_q=mysqli_query($url,"SELECT * FROM `".TB_pre."dhl_export_zone_mapping` WHERE `code`='$countrycode'");
	if($fedex_country_export_949_q>0) {
		$zone_maping_query="UPDATE `".TB_pre."fedex_export_949_zone_mapping` SET `country`='$countryname', `code`='$countryname' WHERE code=".$countrycode;
	}elseif($dhl_export_zone_mapping_q>0) {
		$zone_maping_query="UPDATE `".TB_pre."dhl_export_zone_mapping` SET `country`='$countryname', `code`='$countryname' WHERE code=".$countrycode;
	}
		$zr = mysqli_query($url, $zone_maping_query) or die(mysqli_error($url));
		
	$msg=""; $error="";
	if($countryname!="" ){
		//
		$cid=$_GET['cid'];
		
		
		  $query = "UPDATE `".TB_pre."countries` SET `name`='$countryname', `code`='$countryname' WHERE cid=".$cid;
		  $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  $msg.= "Rate Successfully updated";
		  }
		  else {
			  $error.= "Failed: Error occured";
		  }
	  
	}
	else {
			  $error.= "Failed: Fill all the required fields";
		  }
}
	$id = $_GET['cid'];
	 $country_q=mysqli_query($url,"SELECT * FROM `".TB_pre."countries` WHERE `cid`='$id'");
	 $country_r=mysqli_fetch_object($country_q);
}
?>
<?php include("includes/header.php"); ?>

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
                            <input type="text" name="country" id="country" value="<?php  echo $country_r->name;  ?>" readonly />
                            
                        </div>
						<div class="col-md-4 col-sm-12">
                            <label for="country_code">Country Code</label>
                            <input type="text" name="country_code" id="country_code" value="<?php  echo $country_r->code;  ?>" readonly />
                            
                        </div>
						
						
                        
                    </div>
					<div class="row">
						<div class="col-md-4 col-sm-12">
							<input type="hidden" name="cid" value="<?php echo $_GET['cid']; ?>" />
                            <input type="submit" name="update" value="Update Country" id="updateCountry" >
						</div>
					</div>
			</form>
			




            
        </div></div>
        <div class="col-xl-2 col-md-2 col-lg-3 col-sm-3"></div>
    </div>
</div>
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
	$(document).ready(function(){

		$('.checkanother').click(function(){
			window.location.href = "index.php";

		})
	})
	
</script>
</body>
</html>