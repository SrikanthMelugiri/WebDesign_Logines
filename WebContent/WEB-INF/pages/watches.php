<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>  Longines - Products </title>
	
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
    
	
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="../js/script.js"></script>

</head>

<body>

<?php 
include 'header.php';
?>
<div class="row">
<div class="container">

<h2>Products:</h2>
<hr/>
<div class="container">







<?php 
$conn = mysqli_connect("localhost", "root", "", "longines");
mysqli_select_db($conn,"longines");
if(! $conn )
{
	die('Could not connect: ' . mysql_error());
}


$stmt3 = $conn->prepare("SELECT * FROM product");
$stmt3->execute();

$res_order = $stmt3->get_result();
$i=0;
while($row_order = $res_order->fetch_assoc()){
	$row_2[$i] = $row_order;
	?>
	
	<div class="col-lg-4 col-lg-offset-1">
	<h3 class="text-center"><?php echo $row_2[$i]['prod_name']?></h3>
	<hr/>
	<img src="<?php echo $row_2[$i]['image'];?>" class="img-responsive"/>
	<hr/>
	<h3 class="text-center">$<?php echo $row_2[$i]['price']?></h3>
	<div class="col-lg-10 col-lg-offset-1 col-xs-10 col-xs-offset-1 col-sm-1 col-sm-offset-1">
	<a href="watchDetails.php?id=<?php echo $row_2[$i]['prod_id']?>"
	class="btn btn-lg btn-success col-lg-12">View Details</a>
	<hr/>
	</div>
	
	
	
	
	</div>
	<?php 
	
	$i++;
}

	
	?>
	
	</div>
	</div>
<br/>
	<br/>
</div>
<?php  include 'footer.php';?>