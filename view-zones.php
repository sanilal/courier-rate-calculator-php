<?php  
include("includes/conn.php"); 
include("includes/head.php"); 
/*if(isset($_GET['remove_bn'])){
	$id = $_GET['remove_bn'];
	$query = "DELETE FROM `".TB_pre."courier_rates` WHERE `rid`='$id'";
	$r = mysqli_query($url, $query) or die(mysqli_error($url));
	
	if($r){
		$msg = "The selected rate deleted successfully.";
	}
}*/
?>

<?php include("includes/header.php"); ?>
        	<h3>View Zones</h3>
        	
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
                            <label for="account">Account</label>
                            <select id="account" name="account">
								<option value="">Select Courier Type First</option>
                                
                            </select>
                        </div>
						
                        
                    </div>
                    <div class="row">
						<div class="col-md-4 col-sm-12">
							<label></label>
                            <input type="submit" name="submit" value="Get Zones" id="getZones" >
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
			 $account=preg_replace('/\s+/', ' ', $_GET['account']);
			 if($companyId==1 && $cargoType==1) {
				$zone_q=mysqli_query($url,"SELECT * FROM `".TB_pre."dhl_export_zone_mapping`");
				 $zmap="dhlexport";
			  }elseif($companyId==1 && $cargoType==2){
				 $zone_q=mysqli_query($url,"SELECT * FROM `".TB_pre."dhl_import_zone_mapping`");
				 $zmap="dhlimport";
			 }
			  elseif($companyId==2 && $cargoType==1) {
				 
				  if($account==949) {
					  $zone_q=mysqli_query($url,"SELECT * FROM `".TB_pre."fedex_export_949_zone_mapping`");
					  $zmap="fedexport949";
				
				  } else {
					  $zone_q=mysqli_query($url,"SELECT * FROM `".TB_pre."fedex_export_zone_mapping`");
					  $zmap="fedexexportge";
		
				  }
				 
			 } elseif($companyId==2 && $cargoType==2) {
				 $zone_q=mysqli_query($url,"SELECT * FROM `".TB_pre."fedex_import_497390508_zone_mapping`");
				  $zmap="fedimp497390508";
				
			 } elseif($companyId==3 && ($cargoType==1 OR $cargoType=2)) {
				 $zone_q=mysqli_query($url,"SELECT * FROM `".TB_pre."tnt_export_zone_mapping`");
				  $zmap="tntexp";
			
			 } elseif($companyId==4 && ($cargoType==1 OR $cargoType==2)) {
				 $zone_q=mysqli_query($url,"SELECT * FROM `".TB_pre."ups_export_zone_mapping`");
				 $zmap="upsexp";
				
			 }
			  //$zoneid=preg_replace('/\s+/', ' ', $zone);
			   

			
 ?>
<table class="table mt-4" id="editRateTable">
  <thead class="thead-dark">
    <tr class="redHead">
	 <th scope="col" class="">Courier Company</th>
	 <th scope="col" class="">Account</th>
	 <th scope="col" class="">Export/Import</th>
	  </tr>
	</thead>
	<tbody>
		<tr>
			<td><?php if($companyId==1) {echo"DHL"; } elseif($companyId==2) {echo"FEDEX"; } elseif($companyId==3) {echo"TNT" ;} else{ echo "UPS"; }  ?></td>
			<td><?php echo($account); ?></td>
			<td><?php if ($cargoType==1) {echo "Export"; }else{ echo "Import"; } ?></td>
		</tr>
	</tbody>
</table>
			<h4 class="clearfilter"><a href="view-zones.php">Clear Filter <i>X</i></a></h4>
	<table class="table mt-4" id="editRateTable" >
	  <thead class="thead-dark">
		<tr class="redHead">
		  <th scope="col" class="">Country</th>
		  <th scope="col" class="">Code</th>
		  <th scope="col" class="">Zone</th>
		  <th scope="col" class="">Edit</th>
		</tr>
	  </thead>
	  <tbody>
	  <!--FEDEX starts-->
		  <?php 
			if($zone_q->num_rows > 0){	  

			while($zone_r=mysqli_fetch_object($zone_q)){
				$zone=preg_replace('/\s+/', ' ', $zone_r->zone);
				$zone= json_decode( json_encode($zone), true);
		  ?>
		<tr>
			<td class=""><?php echo($zone_r->country); ?></td>
		   <td class=""><?php echo($zone_r->code); ?></td>
		   <td class=""><?php echo $zone; ?></td>
			<td class=""><a href="edit-zones.php?id=<?php echo $zone_r->id; ?>&amp;zmap=<?php echo $zmap; ?>&amp;cargoType=<?php echo $cargoType; ?>&amp;account=<?php echo $account; ?>" class="btn btn-primary">Edit</a></td>
		</tr>
		  <?php } } ?>

		<!--FEDEX ENDS-->

	  </tbody>
	</table>
<?php } ?>

            
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
					url: 'ajax-zones.php',
					data: 'cid='+companyId,
					success:function(html){
						$('#cargoType').html(html)
					}
				});
			}else{
				$('#cargoType').html('<option value="">Select Service provider First</option>');
				$('#account').html('<option value="">Select Import/Export First</option>');
				$('#country').html('<option value="">Select Account First</option>');
			}
		})
		$('#cargoType').on('change', function(){
			var company_Id = $('#company').val();
			var cargoId = $('#cargoType').val();
			if(cargoId){
				$.ajax({
					type: 'POST',
					url: 'ajax-zones.php',
					data: {compaid : company_Id, crgid : cargoId},
					success:function(html){
						$('#account').html(html)
					}
				});
			}else{
				$('#account').html('<option value="">Select Import/Export First</option>');
				$('#country').html('<option value="">Select Account Type First</option>');
			}
		})
	

		
		$('.checkanother').click(function(){
			window.location.href = "index.php";

		})
	})
	
</script>
</body>
</html>