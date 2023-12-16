<?php  
include("includes/conn.php");
include("includes/head.php");
$id=$_GET['id'];
$zmap=$_GET['zmap'];
$cargoType=$_GET['cargoType'];
$account=$_GET['account'];
if(isset($_REQUEST['update'])){
	$zone=$_GET['zone'];
	$msg=""; $error="";
	if($zone!="" ){
		//
		$zmap=$_GET['zmap'];
		$id=$_GET['id'];
		
		if($zmap=="dhlexport") {
			$query = "UPDATE `".TB_pre."dhl_export_zone_mapping` SET `zone`='$zone' WHERE id=".$id;
			
		}elseif($zmap=="dhlimport") {
			$query = "UPDATE `".TB_pre."dhl_import_zone_mapping` SET `zone`='$zone' WHERE id=".$id;
			
		}elseif($zmap=="fedexport949") {
			$query = "UPDATE `".TB_pre."fedex_export_949_zone_mapping` SET `zone`='$zone' WHERE id=".$id;
			
		}elseif($zmap=="fedexexportge"){
			$query = "UPDATE `".TB_pre."fedex_export_zone_mapping` SET `zone`='$zone' WHERE id=".$id;
		}elseif($zmap=="fedimp497390508"){
			$query = "UPDATE `".TB_pre."fedex_import_497390508_zone_mapping` SET `zone`='$zone' WHERE id=".$id;
		}elseif($zmap=="tntexp"){
			$query = "UPDATE `".TB_pre."tnt_export_zone_mapping` SET `zone`='$zone' WHERE id=".$id;
			
		}elseif($zmap=="upsexp") {
			$query = "UPDATE `".TB_pre."ups_export_zone_mapping` SET `zone`='$zone' WHERE id=".$id;
		}
		  
		 $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  $msg.= "Zone Successfully updated";
		  }
		  else {
			  $error.= "Failed: Error occured";
		  }
	  
	}
	else {
			  $error.= "Failed: Fill all the required fields";
		  }
}
if($zmap=="dhlexport") {
	$zone_q=mysqli_query($url,"SELECT * FROM `".TB_pre."dhl_export_zone_mapping` WHERE `id`='$id'");
	$company="DHL";
}elseif($zmap=="dhlimport") {
	$zone_q=mysqli_query($url,"SELECT * FROM `".TB_pre."dhl_import_zone_mapping` WHERE `id`='$id'");
	$company="DHL";
}elseif($zmap=="fedexport949") {
	$zone_q=mysqli_query($url,"SELECT * FROM `".TB_pre."fedex_export_949_zone_mapping` WHERE `id`='$id'");
	$company="Fedex";
}elseif($zmap=="fedexexportge"){
	$zone_q=mysqli_query($url,"SELECT * FROM `".TB_pre."fedex_export_zone_mapping` WHERE `id`='$id'");
	$company="Fedex";
}elseif($zmap=="fedimp497390508"){
	$zone_q=mysqli_query($url,"SELECT * FROM `".TB_pre."fedex_import_497390508_zone_mapping` WHERE `id`='$id'");
	$company="Fedex";
}elseif($zmap=="tntexp"){
	$zone_q=mysqli_query($url,"SELECT * FROM `".TB_pre."tnt_export_zone_mapping` WHERE `id`='$id'");
	$company="TNT";
}elseif($zmap=="upsexp"){
	$zone_q=mysqli_query($url,"SELECT * FROM `".TB_pre."ups_export_zone_mapping` WHERE `id`='$id'");
	$company="UPS";
}
$zone_r=mysqli_fetch_object($zone_q);

?>

<?php include("includes/header.php"); ?>
        	<h3>Update Zone</h3>
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
                            <label for="company">Service Provider</label>
                            <input type="text" name="ccompany" id="ccompany" value="<?php echo($company); ?>" readonly />
                            
                        </div>
						<div class="col-md-4 col-sm-12">
                            <label for="account">Account</label>
                            <input id="account" name="account" value="<?php echo $account; ?>" readonly />
                        </div>
						<div class="col-md-4 col-sm-12">
                            <label for="cargoType">Import/Export</label>
							<input id="cargoType" name="cargoType" value="<?php if($cargoType="1"){echo"Export";}else{echo"Import";} ?>" readonly />
                        </div>
						
                        
                    </div>
                    <div class="row">
						<div class="col-md-4 col-sm-12">
                            <label class="couriert" for="courierType">Country</label>
							<input id="courierType" name="courierType" value="<?php echo($zone_r->country);  ?>" readonly />
							
                        </div>
						<div class="col-md-4 col-sm-12">
                            <label for="zone">Zone</label>
                            <input id="zone" name="zone" value="<?php echo $zone_r->zone; ?>" />
                        </div>
						<div class="col-md-4 col-sm-12">
							<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
							<input type="hidden" name="zmap" value="<?php echo $zmap; ?>" />
                            <input type="submit" name="update" value="Update Zone" id="updateZone" >
						</div>
						
                    </div>
					<div class="row">
						
						
						
					</div>
                    
            </form>
           

            
        </div></div>
        <div class="col-xl-2 col-md-2 col-lg-3 col-sm-3"></div><strong></strong>
    </div>
</div>
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
	function removeItem(id){
		var c= confirm("Do you want to remove this item?");
		if(c){
			location = "edit-rate.php?remove_bn="+id;
		}
	}
	
	
	
</script>
</body>
</html>