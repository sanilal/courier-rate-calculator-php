<?php  
include("includes/conn.php"); 
include("includes/head.php");
include("includes/header.php");
?>

        	<h3>Parcel details</h3>
        	
        	<form method="get" action="<?php echo $_SERVER['PHP_SELF']?>" id="pricecalculator" class="<?php if (isset($_GET['submit'])) { echo("hideMe"); } ?>">
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <label for="weight">Parcel Weight</label>
                            <input type="number" placeholder="Parcel Weight" id="weight" name="weight" step="0.01" required/>
                        </div>
                        <div class="col-md-4 col-sm-12">
                           
                         
                            <label for="country">Country</label>
                            
                            <select id="country" name="country">
                            <?php
                           $country_q=mysqli_query($url,"SELECT * FROM `".TB_pre."countries` ");
							
                           while($country=mysqli_fetch_object($country_q)){
                            ?>
                            <option value="<?php echo $country->code; ?>"><?php echo $country->name; ?></option>
                            
                            <?php } ?>
                                
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="cargoType">Import/Export</label>
                            <select id="cargoType" name="cargoType">
                                <option value="2">Import</option>
                                <option value="1">Export</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <label class="couriert" for="courierType">Courier Type</label>
                            <input type="radio" name="courierType" value="document"> <span>Document</span>
                            <input type="radio" name="courierType" value="nondocument"> <span>Non Document</span>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="fuelcharge">Fuel Charges</label>
                            <input type="number" name="fuelcharge" id="fuelcharge" step="0.001" >
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="profit">Profit %</label>
                            <input type="number" name="profit" id="profit" step="0.001" >
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
			  $actualweight = $_GET['weight'];
			 $weight = $_GET['weight'];
			 $profit = $_GET['profit'];
			 $courierType=$_GET['courierType'];
			 $destination = $_GET['country'];
			
			 if (is_numeric( $weight ) && floor( $weight ) != $weight) {
				 $whole = floor($weight);      // 1
				 $fraction = $weight - $whole; 
				 if($fraction > 0.5) {
					 $weight = $whole+1;
				 } else {
				 	$weight = $whole+0.5;
				 }
			 }
			 $countryCode = /*$_GET['country'];*/ preg_replace('/\s+/', ' ', $_GET['country']);
			 //$country_q = mysqli_query($url,"SELECT * FROM `".TB_pre."countries` WHERE code = '$countryCode'");
			 //$country_r=mysqli_fetch_object($country_q);
			 //$cid = $country_r->cid; 
			 //$countryId = preg_replace('/\s+/', ' ', $cid);
			 $country_query=mysqli_query($url,"SELECT * FROM `".TB_pre."countries` WHERE code = '$countryCode'");
			 $country_result=mysqli_fetch_object($country_query);
			 $country=$country_result->name;
			 $fed_ex_country_q=mysqli_query($url,"SELECT * FROM `".TB_pre."fedex_export_zone_mapping` WHERE code = '$countryCode'");
			 $fed_ex_country_r=mysqli_fetch_object($fed_ex_country_q);
			 $fed_ex_country=$fed_ex_country_r->country;
			 $fed_ex_zone = preg_replace('/\s+/', ' ', $fed_ex_country_r->zone);
			 $dhl_ex_country_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."dhl_export_zone_mapping` WHERE code = '$countryCode'");
			 $dhl_ex_country_r=mysqli_fetch_object($dhl_ex_country_q);
			 $dhl_ex_country = $dhl_ex_country_r->country;
			 $dhl_ex_zone = $dhl_ex_country_r->zone;//preg_replace('/\s+/', ' ', $dhl_ex_country_r->zone);
			 
			 $tnt_ex_country_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."tnt_export_zone_mapping` WHERE code = '$countryCode'");
			 $tnt_ex_country_r=mysqli_fetch_object($tnt_ex_country_q);
			 $tnt_ex_country = $tnt_ex_country_r->country;
			 $tnt_ex_zone = preg_replace('/\s+/', ' ', $tnt_ex_country_r->zone); //$tnt_ex_country_r->zone;
			 
			 $ups_ex_country_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."ups_export_zone_mapping` WHERE code = '$countryCode'");
			 $ups_ex_country_r=mysqli_fetch_object($ups_ex_country_q);
			 $ups_ex_country = $ups_ex_country_r->country;
			 $ups_ex_zone = preg_replace('/\s+/', ' ', $ups_ex_country_r->zone); //$ups_ex_country_r->zone;
			 
			 $cargoType = $_GET['cargoType'];
			 //$courierType = $_GET['courierType'];
			 if(!empty($_POST['courierType'])) {
				$courierType=$_POST['courierType'];
				echo $courierType;
			}
			 $fuelcharge = $_GET['fuelcharge']; 
			 // FEDEX Export 341800960
			 if($cargoType==1) {
				 if($courierType =="document" ) {
			 		$fedex_express_rate_341800960_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight ='$weight' AND zone='$fed_ex_zone' AND rate_categories=2 AND account_no=341800960 AND cargo_type=1 AND `courier_type`=1"  );
					$fedex_economy_rate_341800960_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$fed_ex_zone' AND rate_categories =1 AND account_no=341800960 AND cargo_type=1 AND `courier_type`=1"  );
				 } else {
					 $fedex_express_rate_341800960_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight ='$weight' AND zone='$fed_ex_zone' AND rate_categories=2 AND account_no=341800960 AND cargo_type=1 AND `courier_type`=2"  );
					$fedex_economy_rate_341800960_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$fed_ex_zone' AND rate_categories =1 AND account_no=341800960 AND cargo_type=1 AND `courier_type`=2"  );
				 }	
			 } else {
				 if($courierType =="document" ) {
				  	$fedex_express_rate_341800960_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight ='$weight' AND zone='$fed_ex_zone' AND rate_categories=2 AND account_no=497390508 AND cargo_type=2 AND `courier_type`=1"  );
				  	$fedex_economy_rate_341800960_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$fed_ex_zone' AND rate_categories =1 AND account_no=497390508 AND cargo_type=2 AND `courier_type`=1"  );
				 } else {
					$fedex_express_rate_341800960_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight ='$weight' AND zone='$fed_ex_zone' AND rate_categories=2 AND account_no=497390508 AND cargo_type=2 AND `courier_type`=2"  );
				  	$fedex_economy_rate_341800960_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$fed_ex_zone' AND rate_categories =1 AND account_no=497390508 AND cargo_type=2 AND `courier_type`=2"  );
				 }
			 }
			 $fedex_express_341800960_rate_r=mysqli_fetch_object($fedex_express_rate_341800960_q);
			 $fedex_express_341800960_rate = $fedex_express_341800960_rate_r->rate;
			 $fedex_economy_rate_341800960_r=mysqli_fetch_object($fedex_economy_rate_341800960_q);
			 $fedex_economy_341800960_rate = $fedex_economy_rate_341800960_r->rate;
			 $percentage_fedex_economy_341800960_rate = ($profit/100) * $fedex_economy_341800960_rate;
			 $percentage_fedex_express_341800960_rate = ($profit/100) * $fedex_express_341800960_rate;
			 $fedex_economy_341800960_Total = $percentage_fedex_economy_341800960_rate + $fedex_economy_341800960_rate + $fuelcharge ;
			 $fedex_express_341800960_Total = $percentage_fedex_express_341800960_rate + $fedex_express_341800960_rate + $fuelcharge ;
			 
			 /*DHL Query */
			 /*DHL Export*/
			 if($cargoType==1) {
				 if($courierType =="document" ) {
					 $dhl_express_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$dhl_ex_zone' AND rate_categories =2 AND `courier_type`=1 AND cargo_type=1");
					 $dhl_economy_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$dhl_ex_zone' AND rate_categories =1 AND `courier_type`=1 AND cargo_type=1" );
				 } else {
					 $dhl_express_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$dhl_ex_zone' AND rate_categories =2 AND `courier_type`=2 AND cargo_type=1"  );
					 $dhl_economy_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$dhl_ex_zone' AND rate_categories =2 AND `courier_type`=2 AND cargo_type=1" );
				 }
		  	 } else {
				 if($courierType =="document" ) {
					 $dhl_express_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$dhl_ex_zone' AND rate_categories =2 AND `courier_type`=1 AND cargo_type=2");
					 $dhl_economy_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$dhl_ex_zone' AND rate_categories =1 AND `courier_type`=1 AND cargo_type=2" );
				 } else {
					 $dhl_express_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$dhl_ex_zone' AND rate_categories =2 AND `courier_type`=2 AND cargo_type=2"  );
					 $dhl_economy_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$dhl_ex_zone' AND rate_categories =2 AND `courier_type`=2 AND cargo_type=2" );
				 }
			 }
			 $dhl_express_rate_r=mysqli_fetch_object($dhl_express_rate_q);
			 $dhl_express_rate = $dhl_express_rate_r->rate;
			 $dhl_economy_rate_r=mysqli_fetch_object($dhl_economy_rate_q);
			 $dhl_economy_rate = $dhl_economy_rate_r->rate;
			 $percentage_dhl_economy_rate = ($profit/100)*$dhl_economy_rate;
			 $percentage_dhl_express_rate = ($profit/100)*$dhl_express_rate;
			 $dhl_economy_Total = $percentage_dhl_economy_rate+$dhl_economy_rate+$fuelcharge ;
			 $dhl_express_Total = $percentage_dhl_express_rate+$dhl_express_rate+$fuelcharge ;
			 
			 
			 /*TNT Query */
			 /*TNT Export*/
			 if($cargoType==1) {
				 if($courierType =="document" ) {
					 $tnt_express_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$tnt_ex_zone' AND rate_categories =2 AND `courier_type`=1 AND cargo_type=1");
					 $tnt_economy_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$tnt_ex_zone' AND rate_categories =1 AND `courier_type`=1 AND cargo_type=1" );
				 } else {
					 $tnt_express_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$tnt_ex_zone' AND rate_categories =2 AND `courier_type`=2 AND cargo_type=1"  );
					 $tnt_economy_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$tnt_ex_zone' AND rate_categories =2 AND `courier_type`=2 AND cargo_type=1" );
				 }
		  	 } 
			 /*TNT IMPORT*/
			 else {
				 if($courierType =="document" ) {
					 $tnt_express_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$tnt_ex_zone' AND rate_categories =2 AND `courier_type`=1 AND cargo_type=2");
					 $tnt_economy_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$tnt_ex_zone' AND rate_categories =1 AND `courier_type`=1 AND cargo_type=2" );
				 } else {
					 $tnt_express_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$tnt_ex_zone' AND rate_categories =2 AND `courier_type`=2 AND cargo_type=2"  );
					 $tnt_economy_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$tnt_ex_zone' AND rate_categories =2 AND `courier_type`=2 AND cargo_type=2" );
				 }
			 }
			 $tnt_express_rate_r=mysqli_fetch_object($tnt_express_rate_q);
			 $tnt_express_rate = $tnt_express_rate_r->rate;
			 $tnt_economy_rate_r=mysqli_fetch_object($tnt_economy_rate_q);
			 $tnt_economy_rate = $tnt_economy_rate_r->rate;
			 $percentage_tnt_economy_rate = ($profit/100)*$tnt_economy_rate;
			 $percentage_tnt_express_rate = ($profit/100)*$tnt_express_rate;
			 $tnt_economy_Total = $percentage_tnt_economy_rate+$tnt_economy_rate+$fuelcharge ;
			 $tnt_express_Total = $percentage_tnt_express_rate+$tnt_express_rate+$fuelcharge ;
			 
			 
			  /*UPS Query */
			 /*UPS Export*/
			 if($cargoType==1) {
				 if($courierType =="document" ) {
					 $ups_express_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$ups_ex_zone' AND rate_categories =2 AND `courier_type`=1 AND cargo_type=1");
					 $ups_economy_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$ups_ex_zone' AND rate_categories =1 AND `courier_type`=1 AND cargo_type=1" );
				 } else {
					 $ups_express_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$ups_ex_zone' AND rate_categories =2 AND `courier_type`=2 AND cargo_type=1"  );
					 $ups_economy_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$ups_ex_zone' AND rate_categories =2 AND `courier_type`=2 AND cargo_type=1" );
				 }
		  	 } 
			 /*UPS IMPORT*/
			 else {
				 if($courierType =="document" ) {
					 $ups_express_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$ups_ex_zone' AND rate_categories =2 AND `courier_type`=1 AND cargo_type=2");
					 $ups_economy_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$ups_ex_zone' AND rate_categories =1 AND `courier_type`=1 AND cargo_type=2" );
				 } else {
					 $ups_express_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$ups_ex_zone' AND rate_categories =2 AND `courier_type`=2 AND cargo_type=2"  );
					 $ups_economy_rate_q =  mysqli_query($url,"SELECT * FROM `".TB_pre."courier_rates` WHERE weight = '$weight' AND zone = '$ups_ex_zone' AND rate_categories =2 AND `courier_type`=2 AND cargo_type=2" );
				 }
			 }
			 $ups_express_rate_r=mysqli_fetch_object($ups_express_rate_q);
			 $ups_express_rate = $ups_express_rate_r->rate;
			 $ups_economy_rate_r=mysqli_fetch_object($ups_economy_rate_q);
			 $ups_economy_rate = $ups_economy_rate_r->rate;
			 $percentage_ups_economy_rate = ($profit/100)*$ups_economy_rate;
			 $percentage_ups_express_rate = ($profit/100)*$ups_express_rate;
			 $ups_economy_Total = $percentage_ups_economy_rate+$ups_economy_rate+$fuelcharge ;
			 $ups_express_Total = $percentage_ups_express_rate+$ups_express_rate+$fuelcharge ;

 ?>

<table class="table mt-4">
  <thead class="thead-dark">
    <tr class="redHead">
	  <th scope="col" class="border-right">Ship From/To</th>
      <th scope="col" class="border-right">Weight</th>
	  <th scope="col" class="border-right">Document/Non Document</th>
      <th scope="col" class="border-right">Fuel</th>
      <th scope="col" class="border-right">Profit %</th>
    </tr>
  </thead>
  <tbody>
  <!--FEDEX starts-->
    <tr class="yellowBg">
       
       <td class="border-top-0 border-right"><?php if($cargoType==2) {echo('To:'.$country.'') ;} else {echo('From: '.$country.'');}  ?></td>
	   <td class="border-top-0 border-right"><?php echo $actualweight;?></td>
       <td class="border-top-0 border-right"><?php if($courierType=="nondocument") {echo("Non Document") ;} else {echo("Document");}?></td>
      <td class="border-top-0 border-right"><?php echo $fuelcharge; ?></td>
      <td class="border-top-0 border-right"><?php echo $profit; ?></td>
    </tr>

    <!--FEDEX ENDS-->
  
  </tbody>
</table>
			
<table class="table mt-4 <?php if(!isset($fedex_express_341800960_rate) && !isset($fedex_economy_341800960_rate) && !isset($dhl_express_rate) && !isset($dhl_economy_rate) && !isset($tnt_express_rate) && !isset($tnt_economy_rate) && !isset($ups_express_rate) && !isset($ups_economy_rate)) { echo("hideMe"); } ?>">
  <thead class="thead-dark">
    <tr class="redHead">
      <th scope="col" class="border-right">Service</th>
      <th scope="col" class="border-right">Service Type</th>
      <th scope="col" class="border-right">Rate</th>
      <th scope="col" class="border-right">Fuel</th>
      <th scope="col" class="border-right">Profit % <?php echo $profit; ?></th>
      <th scope="col">Total</th>
    </tr>
  

  </thead>
  <tbody>
  <!--FEDEX starts-->
    <tr class="yellowBg <?php if(!isset($fedex_express_341800960_rate)) { echo("hideMe"); } ?>">
      <th scope="row" class="border-right">
      FEDEX <?php if(isset($fedex_express_341800960_rate)) {if($cargoType==1) {echo 341800960; echo " Export"; } else {echo 497390508; echo " Import";}} else {echo "";} ?>
      </th>
       <td class="border-top-0 border-right">Express</td>
       <td class="border-top-0 border-right"><?php if(isset($fedex_express_341800960_rate)) { echo $fedex_express_341800960_rate; } else { echo "Not Available";}?></td>
      <td class="border-top-0 border-right"><?php if(isset($fedex_express_341800960_rate)) { echo $fuelcharge; } else { echo 0;} ?></td>
      <td class="border-top-0 border-right"><?php if(isset($fedex_express_341800960_rate)) { echo $percentage_fedex_express_341800960_rate; } else { echo 0;} ?></td>
      <td class="no-border"><strong><?php if(isset($fedex_express_341800960_rate)) {echo $fedex_express_341800960_Total; } else { echo 0;} ?></strong></td>
    </tr>
    <tr class="lightGray <?php if(!isset($fedex_economy_341800960_rate)) { echo("hideMe"); } ?>">
      <th scope="row"  class="border-right">
      FEDEX <?php if(isset($fedex_economy_341800960_rate)) {if($cargoType==1) {echo 341800960; echo " Export"; } else {echo 497390508; echo " Import";}}{echo "";} ?>
      </th>
      <td class="border-top-0 border-right">Economy</td>
      <td class="border-top-0 border-right"><?php if(isset($fedex_economy_341800960_rate)) { echo $fedex_economy_341800960_rate; } else { echo "Not Available";}?></td>
      <td class="border-top-0 border-right"><?php if(isset($fedex_economy_341800960_rate)) { echo $fuelcharge; } else { echo 0; } ?></td>
      <td class="border-top-0 border-right"><?php if(isset($fedex_economy_341800960_rate)) { echo $percentage_fedex_economy_341800960_rate; } else { echo 0;}?></td>
      <td class="no-border"><strong><?php if(isset($fedex_economy_341800960_rate)) { echo $fedex_economy_341800960_Total; } else { echo 0; } ?></strong></td>
    </tr>
    <!--FEDEX ENDS-->
    <!--DHL STARTS-->
    <tr class="yellowBg <?php if(!isset($dhl_express_rate)) { echo("hideMe"); } ?>">
      <th scope="row" class="border-right">
      DHL
      </th>
       <td class="border-top-0 border-right">Express</td>
       <td class="border-top-0 border-right"><?php if(isset($dhl_express_rate)) {  echo $dhl_express_rate; } else { echo "Not Available"; } ?></td>
      <td class="border-top-0 border-right"><?php  if(isset($dhl_express_rate)) {  echo $fuelcharge; } else { echo 0;}?></td>
      <td class="border-top-0 border-right"><?php  if(isset($dhl_express_rate)) {  echo $percentage_dhl_express_rate; } else {echo 0;}?></td>
      <td class="no-border"><strong><?php   if(isset($dhl_express_rate)) {  echo $dhl_express_Total;} else { echo 0;} ?></strong></td>
    </tr>
    <tr class="lightGray <?php if(!isset($dhl_economy_rate)) { echo("hideMe"); } ?>">
      <th scope="row"  class="border-right">
      DHL
      </th>
      <td class="border-top-0 border-right">Economy</td>
      <td class="border-top-0 border-right"><?php if(isset($dhl_economy_rate)) { echo $dhl_economy_rate; } else { echo "Not Available"; }?></td>
      <td class="border-top-0 border-right"><?php if(isset($dhl_economy_rate)) { echo $fuelcharge; } {echo 0;} ?></td>
      <td class="border-top-0 border-right"><?php if(isset($dhl_economy_rate)) { echo $percentage_dhl_economy_rate; } else {echo 0;} ?></td>
      <td class="no-border"><strong><?php if(isset($dhl_economy_rate)) { echo $dhl_economy_Total; } else {echo 0;} ?></strong></td>
    </tr>
    <tr class="yellowBg <?php if(!isset($tnt_express_rate)) { echo("hideMe"); } ?>">
      <th scope="row" class="border-right">
      TNT
      </th>
       <td class="border-top-0 border-right">Express</td>
       <td class="border-top-0 border-right"><?php if(isset($tnt_express_rate)) {  echo $tnt_express_rate; } else { echo "Not Available"; } ?></td>
      <td class="border-top-0 border-right"><?php  if(isset($tnt_express_rate)) {  echo $fuelcharge; } else { echo 0;}?></td>
      <td class="border-top-0 border-right"><?php  if(isset($tnt_express_rate)) {  echo $percentage_tnt_express_rate; } else {echo 0;}?></td>
      <td class="no-border"><strong><?php   if(isset($tnt_express_rate)) {  echo $tnt_express_Total;} else { echo 0;} ?></strong></td>
    </tr>
    <tr class="lightGray <?php if(!isset($tnt_economy_rate)) { echo("hideMe"); } ?>">
      <th scope="row"  class="border-right">
      TNT
      </th>
      <td class="border-top-0 border-right">Economy</td>
      <td class="border-top-0 border-right"><?php if(isset($tnt_economy_rate)) { echo $tnt_economy_rate; } else { echo "Not Available"; }?></td>
      <td class="border-top-0 border-right"><?php if(isset($tnt_economy_rate)) { echo $fuelcharge; } {echo 0;} ?></td>
      <td class="border-top-0 border-right"><?php if(isset($tnt_economy_rate)) { echo $percentage_tnt_economy_rate; } else {echo 0;} ?></td>
      <td class="no-border"><strong><?php if(isset($tnt_economy_rate)) { echo $tnt_economy_Total; } else {echo 0;} ?></strong></td>
    </tr>
    <tr class="yellowBg <?php if(!isset($ups_express_rate)) { echo("hideMe"); } ?>">
      <th scope="row" class="border-right">
      UPS
      </th>
       <td class="border-top-0 border-right">Express</td>
       <td class="border-top-0 border-right"><?php if(isset($ups_express_rate)) {  echo $ups_express_rate; } else { echo "Not Available"; } ?></td>
      <td class="border-top-0 border-right"><?php  if(isset($ups_express_rate)) {  echo $fuelcharge; } else { echo 0;}?></td>
      <td class="border-top-0 border-right"><?php  if(isset($ups_express_rate)) {  echo $percentage_ups_express_rate; } else {echo 0;}?></td>
      <td class="no-border"><strong><?php   if(isset($ups_express_rate)) {  echo $ups_express_Total;} else { echo 0;} ?></strong></td>
    </tr>
    <tr class="lightGray <?php if(!isset($ups_economy_rate)) { echo("hideMe"); } ?>">
      <th scope="row"  class="border-right">
      UPS
      </th>
      <td class="border-top-0 border-right">Economy</td>
      <td class="border-top-0 border-right"><?php if(isset($ups_economy_rate)) { echo $ups_economy_rate; } else { echo "Not Available"; }?></td>
      <td class="border-top-0 border-right"><?php if(isset($ups_economy_rate)) { echo $fuelcharge; } {echo 0;} ?></td>
      <td class="border-top-0 border-right"><?php if(isset($ups_economy_rate)) { echo $percentage_ups_economy_rate; } else {echo 0;} ?></td>
      <td class="no-border"><strong><?php if(isset($ups_economy_rate)) { echo $ups_economy_Total; } else {echo 0;} ?></strong></td>
    </tr>
  </tbody>
</table>
			<h2 class="notAvailable <?php if(!isset($fedex_express_341800960_rate) && !isset($fedex_economy_341800960_rate) && !isset($dhl_express_rate) && !isset($dhl_economy_rate) && !isset($tnt_express_rate) && !isset($tnt_economy_rate) && !isset($ups_express_rate) && !isset($ups_economy_rate)) 
 { echo("showMe"); } ?>"> Service not available. Please try later.  </h2>
	<button class="checkanother">Check another rate</</button>
<?php } ?>

            
        </div></div>
        <div class="col-xl-2 col-md-2 col-lg-3 col-sm-3"></div>
    </div>
</div>
<script src="js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="js/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
	$(document).ready(function(){
		/*$('#getPrice').click(function({
			if($('.checkanother').hasClass('hideMe')) {
				$('.checkanother').removeClass('hideMe');
		}
		}))*/
		$('.checkanother').click(function(){
			window.location.href = "index.php";

		})
	})
	
</script>
</body>
</html>