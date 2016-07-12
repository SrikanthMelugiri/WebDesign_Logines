<?php
if(!isset($_SESSION)){
	session_start();
}

if(isset($_POST['checkout'])){
	
	$conn = mysqli_connect("localhost", "root", "", "longines");
	mysqli_select_db($conn,"longines");
	if(! $conn )
	{
		die('Could not connect: ' . mysql_error());
	}
	
	$order_id = $_POST['order_id'];
	
	
	$stmt = $conn->prepare("UPDATE ORDER1 SET status='FINISHED' WHERE ORDER_ID=?");
	$stmt->bind_param("s", $order_id);
	$stmt->execute();
	
		
	$stmt3 = $conn->prepare("SELECT * FROM ORDER_ITEM WHERE ORDER_ID=?");
	$stmt3->bind_param("s", $order_id);
	$stmt3->execute();
	
	$res_order = $stmt3->get_result();
		
	
?>


<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>  Longines - Order Success</title>
	
    
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
<h1 class="col-lg-offset-1">Your order is Success. Order#: <?php echo $order_id;?></h1>
<hr/>
<div class="row hidden-sm hidden-xs">
<div class="col-lg-1 col-lg-offset-1">
<h3>Item</h3>
</div>
<div class="col-lg-4">
<h3>Description</h3>
</div>
<div class="col-lg-1">
<h3>Qty</h3>
</div>
<div class="col-lg-2">
<h3>Item Price</h3>
</div>
<div class="col-lg-2">
<h3>Item Total</h3>
</div>
</div>
<hr class="hidden-xs hidden-md"/>
<?php
	
	$items_count = 0;
	$order_total = 0;
		
		$stmt3 = $conn->prepare("SELECT * FROM ORDER_ITEM WHERE ORDER_ID=?");
		$stmt3->bind_param("s", $order_id);
		$stmt3->execute();
		
		$res_order = $stmt3->get_result();
		$i=0;
		while($row_order = $res_order->fetch_assoc()){
			$row_2[$i] = $row_order;
			$prod_id = $row_2[$i]['PRODUCT_ID'];
			

			$stmt = $conn->prepare("SELECT * FROM product WHERE PROD_ID=?");
			$stmt->bind_param("s", $prod_id);
			$stmt->execute();
			
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();
			
			$items_count += $row_2[$i]['QUANTITY'];
			$order_total += $row_2[$i]['QUANTITY'] * $row['price'];
			
// 			echo $row_2[$i]['PRODUCT_ID'];
?>
		<div class="row hidden-xs hidden-sm">
			<div class="col-lg-1 col-lg-offset-1">
				<img src="<?php echo $row['image'];?>" class="img-responsive"/>
			</div>
			<div class="col-lg-4">
				<a href="watchDetails.php?id=<?php echo $row['prod_id']?>"><h3><?php echo $row['prod_name'];?></h3></a>
				<p><?php echo $row['prod_desc'];?></p>
				<p> <a href="">Delete</a></p>
			</div>
			<div class="col-lg-1 hidden-xs hidden-sm">
				<h3><?php echo $row_2[$i]['QUANTITY'];?></h3>
				
			</div>
			<div class="col-lg-2">
				<h3>$<?php echo $row['price']; ?> </h3>
			</div>
			<div class="col-lg-2">
				<h3>$<?php  echo $row_2[$i]['QUANTITY'] * $row['price']; ?> </h3>
			</div>
			
		</div>
		<hr class="hidden-xs hidden-md"/>
		
		<div class="row hidden-lg hidden-md">
			<div class="col-xs-offset-1 col-xs-1 col-md-1"> <h2><?php echo "Item"; echo $i+1;?></h2></div>
			<img src="<?php echo $row['image'];?>" class="img-responsive"/>
		</div>
		<div class="row hidden-lg hidden-md">
			<a class="col-xs-offset-1 col-md-offset-1 col-xs-1 col-md-1" href="watchDetails.php?id=<?php echo $row['prod_id']?>"><h3><?php echo $row['prod_name'];?></h3></a>
		</div>
		<div class="row hidden-lg hidden-md">
			<div class="col-md-4 col-xs-4 col-xs-offset-1"><h3>Qty:</h3></div>
			<div class="col-md-4 col-xs-4">
				<h3><?php echo $row_2[$i]['QUANTITY'];?></h3>
			</div>
		</div>
		<div class="row hidden-lg hidden-md">
			<div class="col-md-4 col-xs-4 col-xs-offset-1"><h3>Price:</h3></div>
			<div class="col-md-4 col-xs-4">
				<h3>$<?php echo $row['price']; ?> </h3>
			</div>
		</div>
		<div class="row hidden-lg hidden-md">
			<div class="col-md-4 col-xs-4 col-xs-offset-1"><h3>Item Total:</h3></div>
			<div class="col-md-4 col-xs-4">
				<h3>$<?php  echo $row_2[$i]['QUANTITY'] * $row['price']; ?> </h3>
			</div>
		</div>
		<hr class="hidden-lg hidden-md"/>
		

	<?php 	$i++;
		}?>
		<div class="row hidden-xs hidden-sm">
			<div class="col-lg-3 col-lg-offset-6">
			<h3 class="right">Order total for <?php echo $items_count;?> items:</h3>
			</div>
			<div class="col-lg-2">
			<h3>$<?php echo $order_total;?></h3>
			</div>
		</div>
		<div class="row hidden-lg hidden-md">
			<div class="col-sm-4 col-xs-4 col-xs-offset-1 col-xs-offset-1">
			<h3 class="right">Order total for <?php echo $items_count;?> items:</h3>
			</div>
			<div class="col-xs-3">
			<h3>$<?php echo $order_total;?></h3>
			</div>
		</div>
		<hr/>
		<br/>
		<br/>
		<?php 	
	$conn->close();
	unset($_POST);
?>
</div>
</div>


<?php 
include 'footer.php';
}
?>
</body>
</html>
?>