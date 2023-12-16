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
}elseif(!empty($_POST['crgid'])){
	 $account_q=mysqli_query($url,"SELECT * FROM `".TB_pre."accounts` WHERE `courier_company`=".$_POST['compaid']." AND `account_type`=".$_POST['crgid']." ");
	print_r($account_q);
	if($account_q->num_rows > 0){
		echo('<option value="">Select Account </option>');
		while($account=mysqli_fetch_object($account_q)){
			echo("<option value='$account->account_name'> $account->account_name</option>");
		}
	} else {
			echo '<option value="0">Accounts not available</option>';
			}
	// country
}elseif(!empty($_POST['acco'])){
	 if($_POST['company_Id']==1 && $_POST['crid']==1) {
		$country_q=mysqli_query($url,"SELECT DISTINCT `zone` FROM `".TB_pre."dhl_export_zone_mapping` ORDER BY `zone`+0 ");
		if($country_q->num_rows > 0){
			echo('<option value="">Select Zone</option>');
			while($country=mysqli_fetch_object($country_q)){
			echo("<option value='$country->zone'> $country->zone</option>");
		}
		} else {
				echo '<option value="">Zone not available</option>';
			   }
	} elseif($_POST['company_Id']==1 && $_POST['crid']==2) {
		 $country_q=mysqli_query($url,"SELECT DISTINCT `zone` FROM `".TB_pre."dhl_import_zone_mapping` ORDER BY `zone`+0 ");
		 if($country_q->num_rows > 0){
			echo('<option value="">Select Zone</option>');
			while($country=mysqli_fetch_object($country_q)){
			echo("<option value='$country->zone'> $country->zone</option>");
		}
		} else {
				echo '<option value="">Zone not available</option>';
			   }
	 } elseif($_POST['company_Id']==2 && $_POST['crid']==1) {
		 if($_POST['acco']==949){
			 $country_q=mysqli_query($url,"SELECT DISTINCT `zone` FROM `".TB_pre."fedex_export_949_zone_mapping` ORDER BY `zone` ASC ");
			 if($country_q->num_rows > 0){
				echo('<option value="">Select Zone</option>');
				while($country=mysqli_fetch_object($country_q)){
				echo("<option value='$country->zone'> $country->zone</option>");
			}
			} else {
					echo '<option value="">Zone not available</option>';
				 }
		} else {
			 $country_q=mysqli_query($url,"SELECT DISTINCT `zone` FROM `".TB_pre."fedex_export_zone_mapping` ORDER BY `zone` ASC ");
			 if($country_q->num_rows > 0){
				echo('<option value="">Select Zone</option>');
				while($country=mysqli_fetch_object($country_q)){
				echo("<option value='$country->zone'> $country->zone</option>");
			}
			} else {
					echo '<option value="">Zone not available</option>';
				 }
		 }
	 } elseif($_POST['company_Id']==2 && $_POST['crid']==2) {
		 $country_q=mysqli_query($url,"SELECT DISTINCT `zone` FROM `".TB_pre."fedex_import_497390508_zone_mapping` ORDER BY `zone` ASC ");
		 if($country_q->num_rows > 0){
			echo('<option value="">Select Zone</option>');
			while($country=mysqli_fetch_object($country_q)){
			echo("<option value='$country->zone'> $country->zone</option>");
		}
		} else {
				echo '<option value="">Zone not available</option>';
			   }
	 } elseif($_POST['company_Id']==3) {
		 $country_q=mysqli_query($url,"SELECT DISTINCT `zone` FROM `".TB_pre."tnt_export_zone_mapping` ORDER BY `zone` ASC ");
		 if($country_q->num_rows > 0){
			echo('<option value="">Select Zone</option>');
			while($country=mysqli_fetch_object($country_q)){
			echo("<option value='$country->zone'> $country->zone</option>");
		}
		} else {
				echo '<option value="">Zone not available</option>';
			   }
	 } elseif($_POST['company_Id']==4) {
		 $country_q=mysqli_query($url,"SELECT DISTINCT `zone` FROM `".TB_pre."ups_export_zone_mapping` ORDER BY `zone`+0 ");
		 if($country_q->num_rows > 0){
			echo('<option value="">Select Zone</option>');
			while($country=mysqli_fetch_object($country_q)){
			echo("<option value='$country->zone'> $country->zone</option>");
		}
		} else {
				echo '<option value="">Zone not available</option>';
			   }
	 } 
}

?>