<?php
if(!isset($_SESSION)){
	session_start();
}

if(isset($_POST['buy'])){
	
	$conn = mysqli_connect("localhost", "root", "", "longines");
	mysqli_select_db($conn,"longines");
	if(! $conn )
	{
		die('Could not connect: ' . mysql_error());
	}
	
	$prod_id = $_POST['product_id'];
	$quantity = $_POST['quantity'];
// 	$order_string = $prod_id."+".$quantity;
	if(isset($_SESSION['user_id'])){
		$user_id = $_SESSION["user_id"];
	
// 	$stmt = $conn->prepare("SELECT USER_ID FROM USER_ACCOUNT WHERE USER_ID=? AND PASSWORD=?");
	$stmt3 = $conn->prepare("SELECT * FROM ORDER1 WHERE USER_ID=? and status='PENDING'");
	$stmt3->bind_param("s", $user_id);
	$stmt3->execute();
	
	$res = $stmt3->get_result();
	$row = $res->fetch_assoc();
	if (empty($row['USER_ID'])|| count($row['USER_ID']) == 0) {
		$order_id = rand(10000,99999);
		$status = "PENDING";
		
		$stmt1 = $conn->prepare("INSERT INTO ORDER1 (STATUS, ORDER_ID, USER_ID) VALUES (?,?,?)");
		$stmt1->bind_param("sss",$status , $order_id, $user_id);
		$stmt1->execute();
		
		$stmt2 = $conn->prepare("INSERT INTO ORDER_ITEM (ORDER_ID, PRODUCT_ID, QUANTITY) VALUES (?,?,?)");
		$stmt2->bind_param("ssi", $order_id, $prod_id, $quantity);
		$stmt2->execute();
		
		
		/* close statement and connection */
		$stmt1->close();
		$stmt2->close();
	
	}else{
		$order_id = $row['ORDER_ID'];
		
		$stmt3 = $conn->prepare("SELECT * FROM ORDER_ITEM WHERE ORDER_ID=?");
		$stmt3->bind_param("s", $order_id);
		$stmt3->execute();
		
		$res_order = $stmt3->get_result();
		
		$i=0;
		$found = false;
		while($row_order = $res_order->fetch_assoc()){
			$row_2[$i] = $row_order;
			if($prod_id == $row_2[$i]['PRODUCT_ID']){
				
				$found = true;
				$old_quantity = $row_2[$i]['QUANTITY'];
				$new_qty= $old_quantity + $quantity;
					
				$stmt = $conn->prepare("UPDATE ORDER_ITEM SET QUANTITY=? WHERE PRODUCT_ID=?");
				$stmt->bind_param("is", $new_qty,$prod_id);
				$stmt->execute();
				
				/* close statement and connection */
				$stmt->close();
				break;
			}
			$i++;
		}
		if(!$found){
			echo "there";
			$stmt2 = $conn->prepare("INSERT INTO ORDER_ITEM (ORDER_ID, PRODUCT_ID, QUANTITY) VALUES (?,?,?)");
			$stmt2->bind_param("ssi", $order_id, $prod_id, $quantity);
			$stmt2->execute();
			$stmt2->close();
		}
	}
	
	/* close statement and connection */
	$conn->close();
	$_POST['product_id']= "";
	$_POST['quantity'] = "";
	}
	unset($_POST);
	header('location:cart.php');
}

if(isset($_POST['login']))
{
	$conn = mysqli_connect("localhost", "root", "", "longines");
	mysqli_select_db($conn,"longines");
	if(! $conn )
	{
		die('Could not connect: ' . mysql_error());
	}
	
	$user_id = stripslashes($_POST['username']);
	$password = stripslashes($_POST['password']);
	$encryptedpass = md5($password);
	
	$stmt = $conn->prepare("SELECT USER_ID FROM USER_ACCOUNT WHERE USER_ID=? AND PASSWORD=?");
	$stmt->bind_param("ss", $user_id, $password);
	$stmt->execute();
	
	$res = $stmt->get_result();
	$row = $res->fetch_assoc();
	
	
	if (isset($row['USER_ID'])) {
// 		printf("Select returned %d rows.\n", $result->num_rows);
// 		$row=mysqli_fetch_array($result,MYSQLI_NUM);
// 		session_start();
		$_SESSION["user_id"] = $user_id;
// 		$_SESSION["rows"] = $row;
		/* free result set */
// 		$result->close();
	}else{
		
		?>
		<script>
		$(document).ready(function() {
			$("#login_error").show();
			$("#portfolioModal1").modal('show');
			return false;
		});</script>
		
<!-- 		<div class="row  login-error-panel"> -->
<!-- 			<div class="container"> -->
<!-- 				<div class="col-lg-12"> -->
<!-- 					<h2 class="text-center">No such record exists.Please try again.</h2> -->
<!-- 					<button data-dismiss="modal" class="btn btn-default btn-lg" type="button"><i class="fa fa-times"></i> Close</button> -->
<!-- 				</div> -->
			
<!-- 			</div> -->
			<?php 
	}
	
	$conn->close();
}

if(isset($_POST['logout']))
{
// 	session_start();
	unset($_SESSION);
	session_destroy();
}


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Insert title here</title>


<link rel="icon" href="../images/longines-favicon.jpg" type="image/x-icon">

	<!-- Loading Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

    <link href="../css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />

</head>
<body>
<header>

<div class="row page-header">
<div class="container ">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="dropdown col-xs-1 hidden-lg hidden-md">
            	<a href="#" class="dropdown-toggle" style="color:black;" data-toggle="dropdown" role="button" aria-expanded="true">
				  	<h2><span class="glyphicon glyphicon-align-justify" id="toogle_bar"></span></h2>
				 </a>
            	<ul class="dropdown-menu" role="presentation" aria-labelledby="dLabel">
            	<?php if(empty($_SESSION["user_id"])){ ?>
				    <li><h2><a tabindex="-1" href="home.php" id="login-button-mobile" style="color:black;">Login </a></h2></li>
				    <li><h2><a tabindex="-1" href="register.php" style="color:black;">Register </a></h2></li>
				    <?php }else{?>
				    <li><h2>Welcome <?php echo $_SESSION["user_id"];?></h2></li>
				    <li>
					    <a tabindex="-1" href="#">
					    	<form name="logoutForm" action="<?php $_PHP_SELF?>" method="post">
								<input name="logout" type="submit" value="Logout" id="logout_button_mobile" class="btn btn_big btn_default">
							</form>
					    </a>
				    </li>
				    <?php }?>
				    <li>
				    <form name="search" action="#" method="post" id="serachForm"> 
							<div class="input-group col-xs-10">
								<input type="text" class="form-control" id="search-input-mobile"/> 
								<span class="input-group-addon">
									<a href="" id="searchButton_mobile"><span class="glyphicon glyphicon-search" aria-hidden="true" ></span></a>
								</span>
							</div>
						</form>
					</li>
				    <li class="divider"></li>
				    <li><a href="home.php" tabindex="-1" style="color:black;"><h2>Home</h2></a></li>
				    <li><a href="about.php" tabindex="-1" style="color:black;"><h2>About</h2></a></li>
				    <li><a href="watches.php" tabindex="-1" style="color:black;"><h2>Watches</h2></a></li>
				    <li
				  </ul>
            </div>
            <div class="col-sm-10 col-xs-8 col-xs-offset-1 hidden-md hidden-lg">
            	<h2><a href="home.php" ><img  class="img-responsive " src="../images/longines-logo.png"></a></h2>
            </div>
            <div class="col-lg-3 hidden-xs hidden-sm">
            	<a href="home.php" ><img  class="img-responsive " src="../images/longines-logo.png"></a>
            </div>
            <div class="col-xs-1 hidden-lg hidden-md">
            	<h2><a href="cart.php" style="color: black"><span class="glyphicon glyphicon-shopping-cart"></span></a></h2>
            </div>
            <div class="col-lg-offset-4 col-lg-5 hidden-xs hidden-sm">
            <div class="row">
            
            <?php if(isset($_SESSION["user_id"])){ ?>
            
            <div class="dropdown col-lg-7">
				  <a href="#" class="dropdown-toggle" style="color:black;" data-toggle="dropdown" role="button" aria-expanded="true">
				  	<h2>Welcome <?php echo $_SESSION["user_id"];?><span class="caret"></span></h2>
				  </a>
				  <ul class="dropdown-menu" role="presentation" aria-labelledby="dLabel">
				    <li><a tabindex="-1" href="#">View Profile</a></li>
				    <li><a tabindex="-1" href="#">View Orders</a></li>
				    <li class="divider"></li>
				    <li>
					    <a tabindex="-1" href="#">
					    	<form name="logoutForm" action="<?php $_PHP_SELF?>" method="post">
								<input name="logout" type="submit" value="Logout" id="logout_button" class="btn btn_big btn_default">
							</form>
					    </a>
				    </li>
				  </ul>
				</div>
           	 	<div class="col-lg-2">
					<h2><a href="cart.php" style="color:black;">
	                   	<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
					<!--    <span class="badge">42</span> -->
					</a></h2>
		         </div>
			<?php }else{ ?>
				 <div class="col-lg-3 col-lg-offset-1">
						<h2><a href="home.php" id="login-button" style="color:black;">Login </a></h2>
				</div>
				 <div class="col-lg-4">
						<h2><a href="register.php" style="color:black;">Register </a></h2>
				</div>
				 <div class="col-lg-2">
						<h2><a href="cart.php" style="color:black;">
		                   	<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
						<!--    <span class="badge">42</span> -->
						</a></h2>
		          </div>
			<?php }?>
            
            </div>
					<div class="row">
						<form name="search" action="#" method="post" id="serachForm"> 
							<div class="input-group hidden-xs hidden-md col-lg-8 col-lg-offset-1">
								<input type="text" class="form-control" id="search-input"/> 
								<span class="input-group-addon">
									<a href="" id="searchButton"><span class="glyphicon glyphicon-search" aria-hidden="true" ></span></a>
								</span>
							</div>
						</form>
				      </div>
	                   	
                    </div>
                </div>
                

        </div>
        </div>
        

        
        <div class="row navbar-custom">
        <div class="container">
        	<div class="col-lg-offset-3 col-lg-2 hidden-xs hidden-md">
        		<a href="home.php"><h2>Home</h2></a>
        	</div>
        	<div class="col-lg-2 hidden-xs hidden-md">
        		<a href="about.php" ><h2>About</h2></a>
        	</div>
        	<div class="col-lg-2 hidden-xs hidden-md">
        		<a href="watches.php" ><h2>Watches</h2></a>
        	</div>
        </div>
        </div>
</header>



<div aria-hidden="true" role="dialog" tabindex="-1" id="portfolioModal1" class="portfolio-modal modal fade in" style="display: none;">
<!-- <div class="modal-backdrop fade"></div> -->

        <div class="modal-content">
            <div data-dismiss="modal" class="close-modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                        
                            <h2>Login</h2>
                            <p id="login_error" class="error" style="display: none;">No such record exists. Please try again.</p>
                            <hr class="star-primary">

							
							<div class="row">
				                <div class="col-lg-8 col-lg-offset-2">
				                    <form id="login-form" name="login-form" action="<?php $_PHP_SELF ?>" method="post">
				                        <div class="row control-group">
				                            <div class="form-group col-xs-12 floating-label-form-group controls">
				                                <label>User Name:</label>
				                                <input type="text" data-validation-required-message="Please enter your user name." name="username" required="" id="name" placeholder="User Name" class="form-control">
				                                <p class="help-block text-danger"></p>
				                            </div>
				                        </div>
				                        <div class="row control-group">
				                            <div class="form-group col-xs-12 floating-label-form-group controls">
				                                <label>Password:</label>
				                                <input type="password" data-validation-required-message="Please enter your password." name="password" required="" id="password" placeholder="Password" class="form-control">
				                                <p class="help-block text-danger"></p>
				                            </div>
				                        </div>
				                        <br>
				                        <div id="success"></div>
				                        <div class="row">
				                            <div class="form-group col-xs-12">
				                                <input name="login" value="Login" class="btn btn-success btn-lg" type="submit"></button>
				                                <button data-dismiss="modal" class="btn btn-default btn-lg" type="button"><i class="fa fa-times"></i> Close</button>
				                            </div>
				                        </div>
				                    </form>
				                </div>
				            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<!--     <div id="search_form_validate" > -->
    
    
    
    </div>


</body>
</html>