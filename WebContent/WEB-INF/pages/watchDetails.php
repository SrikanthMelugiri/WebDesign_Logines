
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>  Longines - Details </title>
	
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
    
	
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="../js/script.js"></script>

</head>

<body>

<?php 

$conn = mysqli_connect("localhost", "root", "", "longines");
mysqli_select_db($conn,"longines");
if(! $conn )
{
	die('Could not connect: ' . mysql_error());
}

$prod_id = stripslashes($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM product WHERE PROD_ID=?");
$stmt->bind_param("s", $prod_id);
$stmt->execute();

$res = $stmt->get_result();
$row = $res->fetch_assoc();


if (isset($row['prod_id'])) {
	$prod_name =  $row['prod_name'];
	$prod_desc =  $row['prod_desc'];
	$prod_price =  $row['price'];
	$prod_image =  $row['image'];
}else{
	echo "No such record exists. Please try again";
}


?>

<?php include 'header.php';?>

<form name="buy" method="post" action="cart.php">
<div class="row">
<div class="container">
	<div class="col-lg-5 col-md-4 col-sm-12 col-xs-12 col-lg-offset-1">
		<img src="<?php echo $prod_image?>" class="img-responsive"/>
	</div>
	<div class="col-lg-4 col-sm-12 col-xs-12">
		<h3 class="text-center"><?php echo $prod_name?></h3>
		<hr>
		<h4>Description</h4>
		<p><strong><?php echo $prod_desc?></strong></p>
		<hr>
		<label>Quantity:</label>
		&nbsp;
		<select name="quantity" id="item_quantity">
			<option value="">-- Select -- </option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
		</select>
		
		<br/>
		<label>Price: $<?php echo $prod_price;?></label>
		<br/>
		<br/>
		<input type="hidden" name="product_id" value="<?php echo $prod_id?>" />
		<div class="row">
			<input type="submit" name="buy" value="Buy" id="buy-button" class="disabled btn btn-success btn-lg col-lg-5 col-lg-offset-3 col-sm-offset-1 col-xs-offset-1 col-sm-10 col-xs-10"/>
		</div>
		<br/>
		<br/>
	</div>
	
</div>

</div>
</form>

<?php include 'footer.php';?>
</body>
</html>