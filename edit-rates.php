<?php  
include("includes/conn.php"); 
include("includes/head.php");
if(isset($_GET['remove_bn'])){
	$id = $_GET['remove_bn'];
	$query = "DELETE FROM `".TB_pre."courier_rates` WHERE `rid`='$id'";
	$r = mysqli_query($url, $query) or die(mysqli_error($url));
	
	if($r){
		$msg = "The selected rate deleted successfully.";
	}
}
?>
<?php include("includes/header.php");  ?>

        	<h3>Edit Rates</h3>
        	
        	<form method="get" action="<?php echo $_SERVER['PHP_SELF']?>" id="pricecalculator" class="<?php if (isset($_GET['submit'])) { echo("hideMe"); } ?>">
                    <div class="row">
						<div class="col-md-4 col-sm-12">
                            <label for="company">Service Provider</label>
                            
                            <select id="company" name="company">
								<option value="">Select Service provider</option>
                            <?php
                           $company_q=mysqli_query($url,"SELECT * FROM `".TB_pre."courier_companies` ");
							if($company_q->num_rows > 0){
                           while($company=mysqli_fetch_object($company_q)){
                            ?>
                            <option value="<?php echo $company->cid; ?>"><?php echo $company->company_name; ?></option>
                            
                            <?php } 
							} else {
									echo '<option value="">Service provider not available</option>';
								}?>
                                
                            </select>
                        </div>
						<div class="col-md-4 col-sm-12">
                            <label for="cargoType">Import/Export</label>
                            <select id="cargoType" name="cargoType">
								<option value="">Select Service provider First</option>
                            </select>
                        </div>
						<div class="col-md-4 col-sm-12">
                            <label class="couriert" for="courierType">Courier Type</label>
							<select id="courierType" name="courierType">
								<option value="">Select Import/Export First</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="row">
						<div class="col-md-4 col-sm-12">
                            <label for="account">Account</label>
                            <select id="account" name="account">
								<option value="">Select Courier Type First</option>
                                
                            </select>
                        </div>
						<div class="col-md-4 col-sm-12">
                           
                         
                            <label for="country">Country</label>
                            
                            <select id="country" name="country">
								<option value="">Select Account First</option>
                                
                            </select>
                        </div>
						 <div class="col-md-4 col-sm-12">
                            <label for="weight">Parcel Weight</label>
                            
							  <select id="weight" name="weight">
							 	<option value="">Select Country First</option>
                          
                                
                            </select>
                        </div>
                        
                       
                      
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="submit" name="submit" value="Get Price" id="getPrice" >
                            <div class="returntodash">Return to Dashboard</div>
                        </div>
                    </div>
            </form>
           
        <?php   
          if (isset($_GET['submit'])) {
			 $companyId=preg_replace('/\s+/', ' ', $_GET['company']);
			 $company_q=mysqli_query($url,"SELECT * FROM `".TB_pre."courier_companies` WHERE `cid`='$companyId'");
			 $company=mysqli_fetch_object($company_q);
			 $cargoType=$_GET['cargoType'];
			 $courierType=$_GET['courierType'];
			 $account=preg_replace('/\s+/', ' ', $_GET['account']);
			 $country=preg_replace('/\s+/', ' ', $_GET['country']);
			 $weight=preg_replace('/\s+/', ' ', $_GET['weight']);
			 if($companyId==1 && $cargoType==1) {
				$zone_q=mysqli_query($url,"SELECT * FROM `".TB_pre."dhl_export_zone_mapping` WHERE `code`='$country'");
				 $zone=mysqli_fetch_object($zone_q);
			  }elseif($companyId==1 && $cargoType==2) {
				 $zone_q=mysqli_query($url,"SELECT * FROM `".TB_pre."dhl_import_zone_mapping` WHERE `code`='$country'");
				 $zone=mysqli_fetch_object($zone_q);
			 }
			  elseif($companyId==2 && $cargoType==1) {
				  if($account==949) {
					  $zone_q=mysqli_query($url,"SELECT * FROM `".TB_pre."fedex_export_949_zone_mapping` WHERE `code`='$country'");
				 	  $zone=mysqli_fetch_object($zone_q);
				  } else {
					  echo("FEDEX EXPORT GENERAL");
					  $zone_q=mysqli_query($url,"SELECT * FROM `".TB_pre."fedex_export_zone_mapping` WHERE `code`='$country'");
				 	  $zone=mysqli_fetch_object($zone_q);
				  }
				 
			 } elseif($companyId==2 && $cargoType==2) {
				 $zone_q=mysqli_query($url,"SELECT * FROM `".TB_pre."fedex_import_497390508_zone_mapping` WHERE `code`='$country'");
				 $zone=mysqli_fetch_object($zone_q);
			 } elseif($companyId==3 && $cargoType==1) {
				 $zone_q=mysqli_query($url,"SELECT * FROM `".TB_pre."tnt_export_zone_mapping` WHERE `code`='$country'");
				 $zone=mysqli_fetch_object($zone_q);
			 } elseif($companyId==3 && $cargoType==2) {
				 $zone_q=mysqli_query($url,"SELECT * FROM `".TB_pre."tnt_export_zone_mapping` WHERE `code`='$country'");
				 $zone=mysqli_fetch_object($zone_q);
			 } elseif($companyId==4 && $cargoType==1) {
				 $zone_q=mysqli_query($url,"SELECT * FROM `".TB_pre."ups_export_zone_mapping` WHERE `code`='$country'");
				 $zone=mysqli_fetch_object($zone_q);
			 } elseif($companyId==4 && $cargoType==2) {
				 $zone_q=mysqli_query($url,"SELECT * FROM `".TB_pre."ups_export_zone_mapping` WHERE `code`='$country'");
				  
				 $zone=mysqli_fetch_object($zone_q);
			 }
			  $czone=$zone->zone;
			  $zoneid=preg_replace('/\s+/', ' ', $czone);
			  $zoneid= json_decode( json_encode($zoneid), true);

			  
			  //$rate_q=mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE `weight`='$weight' AND `courier_company`='$companyId' AND `zone`='$zone'");
			  $rate_q=mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE `weight`='$weight' AND `courier_company`='$companyId' AND `zone`='$zoneid' AND `cargo_type`='$cargoType' AND `courier_type`='$courierType'");
			
			 
			  
			
 ?>
<h4 class="clearfilter"><a href="edit-rates.php">Clear Filter <i>X</i></a></h4>
<table class="table mt-4" id="editRateTable">
  <thead class="thead-dark">
    <tr class="redHead">
	  <th scope="col" class="">Courier Company</th>
      <th scope="col" class="">Account No</th>
	  <th scope="col" class="">Export/Import</th>
      <th scope="col" class="">Document/Non Document</th>
      <th scope="col" class="">Zone</th>
	  <th scope="col" class="">weight</th>
	  <th scope="col" class="">Express/economy</th>
	  <th scope="col" class="">Rate</th>
	  <th scope="col" class="">Edit</th>
	  <th scope="col" class="">Remove</th>
    </tr>
  </thead>
  <tbody>
  <!--FEDEX starts-->
	  <?php 
		if($rate_q->num_rows > 0){	  
	  	while($rate=mysqli_fetch_object($rate_q)){
	  ?>
    <tr>
       <td class=""><?php if($rate->courier_company ==1) {echo"DHL"; } elseif($rate->courier_company ==2) {echo"FEDEX"; } elseif($rate->courier_company ==3) {echo"TNT" ;} else{ echo "UPS"; }  ?></td>
	   <td class=""><?php if($rate->account_no==0) {echo "General"; } else { echo($rate->account_no); } ?></td>
       <td class=""><?php if ($cargoType==1) {echo "Export"; }else{ echo "Import"; } ?></td>
      <td class=""><?php if ($courierType==1) {echo "Document"; }else{ echo "Non Document"; } ?></td>
      <td class=""><?php echo $rate->zone; ?></td>
	  <td class=""><?php echo $rate->weight; ?></td>
	  <td class=""><?php if($rate->rate_categories==2) {echo "Express"; } else {echo "Economy"; } ?></td>
	  <td class=""><?php echo $rate->rate; ?></td>
	  <td class=""><a class="btn btn-primary" href="edit-rate.php?rid=<?php echo $rate->rid; ?>">Edit</a></td>
	  <td class=""><a class="btn btn-danger" href="javascript:removeItem(<?php echo $rate->rid; ?>);">Delete</a></
    </tr>
	  <?php } } else { ?>

    <!--FEDEX ENDS-->
  
  </tbody>
</table>
<h3>Rate not available</h3>
			
<?php } }?>

            
        </div></div>
        <div class="col-xl-2 col-md-2 col-lg-3 col-sm-3"></div>
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
	
	$(document).ready(function(){
		
		$('#company').on('change', function(){
			var companyId = $('#company').val();
			if(companyId){
				$.ajax({
					type: 'POST',
					url: 'ajaxData.php',
					data: 'cid='+companyId,
					success:function(html){
						$('#cargoType').html(html)
					}
				});
			}else{
				$('#cargoType').html('<option value="">Select Service provider First</option>');
				$('#courierType').html('<option value="">Select Import/Export First</option>');
				$('#country').html('<option value="">Select Courier Type First</option>');
			}
		})
		$('#cargoType').on('change', function(){
			var cargoId = $('#cargoType').val();
			if(cargoId){
				$.ajax({
					type: 'POST',
					url: 'ajaxData.php',
					data: 'cargo_id='+cargoId,
					success:function(html){
						$('#courierType').html(html)
					}
				});
			}else{
				$('#courierType').html('<option value="">Select Import/Export First</option>');
				$('#country').html('<option value="">Select Courier Type First</option>');
			}
		})
		$('#courierType').on('change', function(){
			var company_Id = $('#company').val();
			var cargo_Id = $('#cargoType').val();
			var courierType = $('#courierType').val();
			if(courierType){
				$.ajax({
					type: 'POST',
					url: 'ajaxData.php',
					data: {compaid : company_Id, crgid : cargo_Id, parcel : courierType},
					//data: {doc_id: courierType, cargo_id: cargo_Id, cid: company_Id},
					success:function(html){
						$('#account').html(html)
					}
				});
			}else{
				$('#account').html('<option value="">Select Courier Type First</option>');
			}
		})
		$('#account').on('change', function(){
			var company_Id = $('#company').val();
			var cargo_Id = $('#cargoType').val();
			var courierType = $('#courierType').val();
			var accountvalue = $('#account').val();
			if(courierType){
				$.ajax({
					type: 'POST',
					url: 'ajaxData.php',
					data: {doc_id : courierType, compid : company_Id, crid : cargo_Id, acco : accountvalue},//'doc_id='+courierType,
					//data: {doc_id: courierType, cargo_id: cargo_Id, cid: company_Id},
					success:function(html){
						$('#country').html(html)
					}
				});
			}else{
				
				$('#country').html('<option value="">Select Account First</option>');
			}
		})
		$('#country').on('change', function(){
			var company_Id = $('#company').val();
			var cargo_Id = $('#cargoType').val();
			var courierType = $('#courierType').val();
			var country = $('#country').val();
			var account = $('#account').val();
			if(country){
				$.ajax({
					type: 'POST',
					url: 'ajaxData.php',
					data: {companid : company_Id, cargod : cargo_Id, couTy : courierType, zcountry : country, ac : account},//'doc_id='+courierType,
					dataType: "html",
					//data: {doc_id: courierType, cargo_id: cargo_Id, cid: company_Id},
					success:function(html){
						$('#weight').html(html)
					}
				});
			}else{
				$('#weight').html('<option value="">Select Country First</option>');
			}
		})
		$('.checkanother').click(function(){
			window.location.href = "index.php";

		})
	})
	
</script>
</body>
</html>