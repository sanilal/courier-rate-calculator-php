<?php  
include("includes/conn.php"); 
include("includes/head.php"); 

?>
<?php 
	$rid=$_GET['rid'];
if(isset($_REQUEST['update'])){
	 
	$rate=$_GET['nrate'];
	$msg=""; $error="";
	if($rate!="" ){
		//
		$rid=$_GET['rid'];
		
		
		  $query = "UPDATE `".TB_pre."courier_rates` SET `rate`='$rate' WHERE rid=".$rid;
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
$rate_q=mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE `rid`='$rid'");
$rate=mysqli_fetch_object($rate_q);
?>
<?php include("includes/header.php");?>
        	<h3>Update Rate</h3>
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
                            <input type="text" name="ccompany" id="ccompany" value="<?php if($rate->courier_company==1) { echo "DHL"; }elseif($rate->courier_company==2) { echo "FEDEX";} elseif($rate->courier_company==3) {echo "TNT";} elseif($rate->courier_company==4){echo "UPS"; } ?>" readonly />
                            
                        </div>
						<div class="col-md-4 col-sm-12">
                            <label for="account">Account</label>
                            <input id="account" name="account" value="<?php echo $rate->account_no; ?>" readonly />
                        </div>
						<div class="col-md-4 col-sm-12">
                            <label for="cargoType">Import/Export</label>
							<input id="cargoType" name="cargoType" value="<?php if($rate->cargo_type==1) {echo "Export"; }else{ echo "Import"; } ?>" readonly />
                        </div>
						
                        
                    </div>
                    <div class="row">
						<div class="col-md-4 col-sm-12">
                            <label class="couriert" for="courierType">Courier Type</label>
							<input id="courierType" name="courierType" value="<?php if($rate->courier_type==1) { echo "Document"; } else { echo "Non Document";}  ?>" readonly />
							
                        </div>
						<div class="col-md-4 col-sm-12">
                            <label for="zone">Zone</label>
                            <input id="zone" name="zone" value="<?php echo $rate->zone; ?>" readonly />
                        </div>
						 <div class="col-md-4 col-sm-12">
                            <label for="weight">Parcel Weight</label>
							 <input id="weight" name="weight" value="<?php echo $rate->weight;  ?>" readonly />
							  
                        </div>
                    </div>
					<div class="row">
						<div class="col-md-4 col-sm-12">
                            <label for="rateCat">Rate category</label>
							 <input id="rateCat" name="rateCat" value="<?php if($rate->rate_categories==1) { echo "Economy";}else {echo "Express";} ?>" readonly />
							  
                        </div>
						<div class="col-md-4 col-sm-12">
                            <label for="nrate">Rate</label>
							 <input id="nrate" name="nrate" value="<?php echo $rate->rate; ?>" />
							  
                        </div>
						<div class="col-md-4 col-sm-12">
							<input type="hidden" name="rid" value="<?php echo $_GET['rid']; ?>" />
                            <input type="submit" name="update" value="Update Rate" id="updatePrice" >
							
						</div>
					</div>
                    
            </form>
           <button class="goBack" onclick="goBack()">Go Back</button>

            
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
	function goBack() {
	  window.history.back();
	}
	
	
	
</script>
</body>
</html>