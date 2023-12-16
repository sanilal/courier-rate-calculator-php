<?php
 //$url = mysqli_connect("localhost","uaeresta_comoluc","comoluc","uaeresta_comolucia")  or die("Connection failed");
 $url = mysqli_connect("localhost","root","","test")  or die("Connection failed");
 //$url = mysqli_connect("localhost","safinaas_sfdbusr","czsKFo.k[;Ma","safinaas_safinat")  or die("Connection failed");
 //$basepath="http://localhost/jewellery/";
 //define('TB_pre','me-');
//$basepath="http://restaurantmobileapp.net/watt/";
 ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php 
	$country_q =  mysqli_query($url,"SELECT * FROM `countries`");
	while($country_r=mysqli_fetch_object($country_q)) {?>
	
	<table>
    	<tr>
        	<td><?php $code = $country_r->country; 
				//$newstring = substr($code, -4); 
				//$newstring = trim($newstring, '()');
				$newstring = substr_replace($code ,"", -4);
				echo $newstring;
			?>
            
            </td>
        </tr>
    </table>

<?php } ?>

</body>
</html>