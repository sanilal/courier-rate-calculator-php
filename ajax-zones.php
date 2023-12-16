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
}

?>