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

<?php include("includes/header.php");  ?>
        	<h3>View Countries</h3>
        	
        	
           
        <?php   
			 $country_q=mysqli_query($url,"SELECT * FROM `".TB_pre."countries`");
			
 ?>

	<table class="table mt-4" id="viewCountrytable" >
	  <thead class="thead-dark">
		<tr class="redHead">
		  <th scope="col" class="">Country</th>
		  <th scope="col" class="">Code</th>
		 <!-- <th scope="col" class="">Edit</th>-->
		</tr>
	  </thead>
	  <tbody>
	  <!--FEDEX starts-->
		  <?php 

			while($country_r=mysqli_fetch_object($country_q)){
		  ?>
		<tr>
			<td class=""><?php echo($country_r->name); ?></td>
		    <td class=""><?php echo($country_r->code); ?> </td>
			<!--<td class=""><a class="btn btn-primary" href="edit-country.php?cid=<?php echo $country_r->cid; ?>">Edit</a></td>-->
		</tr>
		  <?php } ?>

		<!--FEDEX ENDS-->

	  </tbody>
	</table>

            
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