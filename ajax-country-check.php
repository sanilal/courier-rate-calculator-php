<?php  
include("includes/conn.php"); 

if(!empty($_POST['code'])) {
	$code=$_POST['code'];	
	 $country_q=mysqli_query($url,"SELECT * FROM `".TB_pre."countries` WHERE `CODE`='$code'");
	if($country_q->num_rows > 0){
		
		echo('<p class="alert">Country exists, Please try another one</p>');
			
		  
	} else {
			if($code<2) {
				
				echo('<p class="success">Click Add Country button to proceed</p>');
			} else {
			echo '<p class="alert">Minimum 2 letters required</p>';
			} 
			} //Parcel / Document
}