<?php  
include("includes/conn.php"); 

if(!empty($_POST['cid'])) {
	
	 $cargoType_q=mysqli_query($url,"SELECT * FROM `".TB_pre."cargo_type` ");
	if($cargoType_q->num_rows > 0){
		
		echo('<option value="">Select Import/Export</option>');
		  while($cargoType=mysqli_fetch_object($cargoType_q)){
			  echo("<option value='$cargoType->id'> $cargoType->ctype</option>");
		  }
	} else {
			echo '<option value="">Cargo Type not available</option>';
			} //Parcel / Document
}elseif(!empty($_POST['cargo_id'])){
	 $courierType_q=mysqli_query($url,"SELECT * FROM `".TB_pre."document` ");
	if($courierType_q->num_rows > 0){
		echo('<option value="">Select Courier Type </option>');
		while($courierType=mysqli_fetch_object($courierType_q)){
			echo("<option value='$courierType->doc_id'> $courierType->document_non_document</option>");
		}
	} else {
			echo '<option value="">Courier Type not available</option>';
			}
	// account
}elseif(!empty($_POST['compaid'])){
	 $account_q=mysqli_query($url,"SELECT * FROM `".TB_pre."accounts` WHERE `courier_company`=".$_POST['compaid']." AND `account_type`=".$_POST['crgid']." ");
	if($account_q->num_rows > 0){
		echo('<option value="">Select Account </option>');
		while($account=mysqli_fetch_object($account_q)){
			echo("<option value='$account->account_name'> $account->account_name</option>");
		}
	} else {
			echo '<option value="0">Accounts not available</option>';
			}
	// Country
}elseif(!empty($_POST['acco'])){
	 if($_POST['compid']==1 && $_POST['crid']==1) {
		$country_q=mysqli_query($url,"SELECT * FROM `".TB_pre."dhl_export_zone_mapping` ");
		if($country_q->num_rows > 0){
			echo('<option value="">Select Country</option>');
			while($country=mysqli_fetch_object($country_q)){
			echo("<option value='$country->code'> $country->country</option>");
		}
		} else {
				echo '<option value="">Country not available</option>';
			   }
	} elseif($_POST['compid']==1 && $_POST['crid']==2) {
		 $country_q=mysqli_query($url,"SELECT * FROM `".TB_pre."dhl_import_zone_mapping` ");
		 if($country_q->num_rows > 0){
			echo('<option value="">Select Country</option>');
			while($country=mysqli_fetch_object($country_q)){
			echo("<option value='$country->code'> $country->country</option>");
		}
		} else {
				echo '<option value="">Country Type not available</option>';
			   }
	 } elseif($_POST['compid']==2 && $_POST['crid']==1) {
		 if($_POST['acco']==949){
			 $country_q=mysqli_query($url,"SELECT * FROM `".TB_pre."fedex_export_949_zone_mapping` ");
			 if($country_q->num_rows > 0){
				echo('<option value="">Select Country</option>');
				while($country=mysqli_fetch_object($country_q)){
				echo("<option value='$country->code'> $country->country</option>");
			}
			} else {
					echo '<option value="">Country not available</option>';
				 }
		} else {
			 $country_q=mysqli_query($url,"SELECT * FROM `".TB_pre."fedex_export_zone_mapping` ");
			 if($country_q->num_rows > 0){
				echo('<option value="">Select Country</option>');
				while($country=mysqli_fetch_object($country_q)){
				echo("<option value='$country->code'> $country->country</option>");
			}
			} else {
					echo '<option value="">Country not available</option>';
				 }
		 }
	 } elseif($_POST['compid']==2 && $_POST['crid']==2) {
		 $country_q=mysqli_query($url,"SELECT * FROM `".TB_pre."fedex_import_497390508_zone_mapping` ");
		 if($country_q->num_rows > 0){
			echo('<option value="">Select Country</option>');
			while($country=mysqli_fetch_object($country_q)){
			echo("<option value='$country->code'> $country->country</option>");
		}
		} else {
				echo '<option value="">Country Type not available</option>';
			   }
	 } elseif($_POST['compid']==3) {
		 $country_q=mysqli_query($url,"SELECT * FROM `".TB_pre."tnt_export_zone_mapping` ");
		 if($country_q->num_rows > 0){
			echo('<option value="">Select Country</option>');
			while($country=mysqli_fetch_object($country_q)){
			echo("<option value='$country->code'> $country->country</option>");
		}
		} else {
				echo '<option value="">Country not available</option>';
			   }
	 } elseif($_POST['compid']==4) {
		 $country_q=mysqli_query($url,"SELECT * FROM `".TB_pre."ups_export_zone_mapping` ");
		 if($country_q->num_rows > 0){
			echo('<option value="">Select Country</option>');
			while($country=mysqli_fetch_object($country_q)){
			echo("<option value='$country->code'> $country->country</option>");
		}
		} else {
				echo '<option value="">Country not available</option>';
			   }
	 } 
}elseif(!empty($_POST['zcountry'])){
	if($_POST['ac'] == "General") {
		$account=0; 
		
	} else {
		$account=$_POST['ac'];
		
	}
	 $weight_q=mysqli_query($url,"SELECT * FROM `".TB_pre."weight`");
	if($weight_q->num_rows > 0){
		echo('<option value="">Select Weight </option>');
		while($weight=mysqli_fetch_object($weight_q)){
			echo("<option value='$weight->weight'> $weight->weight</option>");
		}
	} else {
			echo '<option value="0">Weight not available</option>';
			}
}

?>