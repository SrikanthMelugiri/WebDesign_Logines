
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>  Longines - Cart </title>
	
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
    
	
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="../js/script.js"></script>

</head>

<body>
<div id="refresh-div">
<?php
include 'header.php';
?>
<div class="row">
<div class="container" id="cart-main">
<h1 class="col-lg-offset-1">Shopping Cart</h1>
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
$conn = mysqli_connect("localhost", "root", "", "longines");
	mysqli_select_db($conn,"longines");
	if(! $conn )
	{
		die('Could not connect: ' . mysql_error());
	}
	
	

	
	$items_count = 0;
	$order_total = 0;
	if(isset($_SESSION["user_id"])){
		$user_id = $_SESSION["user_id"];
	}
	$stmt1 = $conn->prepare("SELECT * FROM ORDER1 WHERE USER_ID=? and status='PENDING'");
	$stmt1->bind_param("s", $user_id);
	$stmt1->execute();
	
	$res = $stmt1->get_result();
	$row = $res->fetch_assoc();
	if (!empty($row['USER_ID'])) {
		$order_id = $row['ORDER_ID'];
		
		if(isset($_POST['delete'])){
			$delete_prod_id = $_POST['delete_prod_id'];
			
			$stmt2 = $conn->prepare("DELETE FROM ORDER_ITEM WHERE ORDER_ID=? AND PRODUCT_ID=?");
			$stmt2->bind_param("ss", $order_id, $delete_prod_id);
			$stmt2->execute();
		
			$stmt2->close();
		}
		
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
				<p> <a href="#" id="delete-item" data-prod-id="<?php echo $row['prod_id'];?>">Delete</a></p>
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
		}
		
	}elseif(!isset($_SESSION["user_id"])){ 
		?>
		<div class="row">
		<div class="col-lg-8 col-lg-offset-1">
		<h3 class="text-center">Please login to add/view items in Cart.</h3>
		</div>
		</div>
		<hr/>
		<?php 
	}elseif(empty ($row['ORDER_ID'])){
		?>
				<div class="row">
				<div class="col-lg-8 col-lg-offset-1">
				<h3 class="text-center">No current pending orders in account.</h3>
				</div>
				</div>
				<hr/>
				<?php
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
		<div class="row ">
		<form name="checkout_form" action="success.php" method="post">
			<input type="hidden" name="order_id" value="<?php if(!empty($order_id)){echo $order_id;}?>"/>
			<input type="submit" name="checkout" value="Checkout &gt;" class="<?php if(empty($order_id)){ echo "disabled  ";}?>btn btn-success btn-lg col-lg-2 col-lg-offset-8 col-md-2 col-md-offset-8 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2"/>
		</form>
		</div>
		<br/>
		<br/>
		<?php 
	$conn->close();
?>
</div>
</div>


<?php 
include 'footer.php';
	?>
	</div>
</body>
</html>