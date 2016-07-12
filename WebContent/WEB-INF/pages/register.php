<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Longines - Register</title>


	 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
    
	
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="../js/script.js"></script>

</head>
<body>

<?php


if(!isset($_SESSION)){
	session_start();
}



if(isset($_POST['submit']))
{
	
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'rootpassword';
// $conn = mysql_connect($dbhost, $dbuser, $dbpass);
$conn = mysqli_connect("localhost", "root", "", "longines");
mysqli_select_db($conn,"longines");
if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}


$firstname = $_POST['firstName'];
$lastname = $_POST['lastName'];
$email = $_POST['email'];
$mobile = $_POST['mobileNumber'];
$person_id = rand(1000,9999);
$user_id = $_POST['userName'];
$password = $_POST['password'];
$dateOfBirth = $_POST['dateOfBirth'];


$stmt2 = $conn->prepare("SELECT USER_ID FROM USER_ACCOUNT WHERE USER_ID=?");
$stmt2->bind_param("s", $user_id);
$stmt2->execute();

$res = $stmt2->get_result();
$row = $res->fetch_assoc();
if (empty($row['USER_ID'])) {
	$stmt = $conn->prepare("INSERT INTO PERSON set FIRST_NAME=?, LAST_NAME=?, email_id=?, mobile=?, person_id=?, date_of_birth=?");
	$stmt->bind_param("ssssss", $firstname, $lastname,  $email, $mobile, $person_id, $dateOfBirth );
	
	
	$stmt1 = $conn->prepare("INSERT INTO USER_ACCOUNT set user_id=?, password=?, person_id=?");
	$stmt1->bind_param("sss", $user_id, $password, $person_id);
	
	
	$stmt->execute();
	$stmt1->execute();
	
	/* close statement and connection */
	$stmt->close();
	$stmt1->close();
	
	$_SESSION["user_id"] = $user_id;
	
// // 	$to      = 'nobody@example.com';
// 	$subject = 'Registration success';
// 	$message = 'You have been successfully registered';
// 	$headers = 'From: Srikanth.shah@gmail.com' . "\r\n" .
// 			'Reply-To: webmaster@example.com' . "\r\n" .
// 			'X-Mailer: PHP/' . phpversion();
	
// 	$from = "srikanth.shah@gmail.com"	;
// 	$to = $email;
// 	$subject = "Registration success";
// 	$body = "You have been successfully registered";
	
// 	$host = "ssl://smtp.gmail.com";
// 	$username = "srikanth.shah@gmail.com";
// 	$password = "";
	
// 	$headers = array('From' => $from, 'To' => $email, 'Subject' => $subject);
// 	$smtp = Mail::factory('smtp', array ('host' => $host,
// 			'auth' => true,
// 			'username' => $username,
// 			'password' => $password));
	
// 	$mail = $smtp->send($to, $headers, $body);
	
// 	if ( PEAR::isError($mail) ) {
// 		echo("<p>Error sending mail:<br/>" . $mail->getMessage() . "</p>");
// 	} else {
// 		echo("<p>Message sent.</p>");
// 	}
	
	
//  	mail($email, $subject, $message, $headers);
	
}else{
	displayForm("User id already exists");
}

/* close connection */
$conn->close();

displaySuccess();
}
else
{ 
	displayForm("");
}

function displaySuccess(){
	include 'header.php';
	?>
				<div class="container">
                	<div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                    
                    	<h2> Successfully  Registered!! </h2>
                    	<a href="home.php" class="btn btn-success btn-lg">Continue Shopping</a>
                    </div>
                    </div>
                </div>
	<?php 
}

function displayForm($message){
	include 'header.php';
?> 
   <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                            <h2>Register</h2>
                            <hr class="star-primary">

							<h5 class="error" id="error-message"><?php echo $message;?></h5>
							<div class="row">
				                <div class="col-lg-8 col-lg-offset-2">
				                    <form id="login-form" name="login-form" class="horizantal-form" action="<?php $_PHP_SELF ?>" method="POST">
				                        <div class="row control-group">
				                            <div class="form-group col-xs-12 floating-label-form-group controls">
				                                <label>First name:</label>
				                                <input type="text" data-validation-required-message="Please enter your first name." name="firstName" required="true" id="firstName" placeholder="First Name" class="form-control">
				                                <p class="help-block text-danger"></p>
				                            </div>
				                        </div>
				                        <div class="row control-group">
				                            <div class="form-group col-xs-12 floating-label-form-group controls">
				                                <label>Last name:</label>
				                                <input type="text" data-validation-required-message="Please enter your last name" required="true" id="lastName" name="lastName" placeholder="Last Name" class="form-control">
				                                <p class="help-block text-danger"></p>
				                            </div>
				                        </div>
				                        
				                        <div class="radio control-group">
				                        	<label>Gender:</label>
								          <label><input type="radio" name="gender" value="male" checked="checked">Male</label>
								          <label><input type="radio" name="gender" value="female" >Female</label>
								        </div>
				                        
				                        <div class="row control-group">
				                            <div class="form-group col-xs-12 floating-label-form-group controls">
				                                <label>Date of Birth:</label>
				                                <input type="date" data-validation-required-message="Please select your date of birth." required="" id="dateOfBirth" name="dateOfBirth" placeholder="Date of Birth" class="form-control">
				                                <p class="help-block text-danger"></p>
				                            </div>
				                        </div>
				                        
				                        <div class="row control-group">
				                            <div class="form-group col-xs-12 floating-label-form-group controls">
				                                <label>Mobile:</label>
				                                <input type="number" data-validation-required-message="Please enter your mobile number" required="" id="mobileNumber" name="mobileNumber" placeholder="10 digit Mobile number" class="col-lg-5 form-control">
				                                <p class="help-block text-danger"></p>
				                            </div>
				                        </div>
				                        
				                        <div class="row control-group">
				                            <div class="form-group col-xs-12 floating-label-form-group controls">
				                                <label>Email:</label>
				                                <input type="email" data-validation-required-message="Please enter your email address" required="" id="email" name="email" placeholder="Email address" class="form-control">
				                                <p class="help-block text-danger"></p>
				                            </div>
				                        </div>
				                        
				                        <div class="row control-group">
				                            <div class="form-group col-xs-12 floating-label-form-group controls">
				                                <label>User Name:</label>
				                                <input type="text" data-validation-required-message="Please enter your email address" required="" id="userName" name="userName" placeholder="Please select a user name" class="form-control">
				                                <p class="help-block text-danger"></p>
				                            </div>
				                        </div>
				                        
				                        <div class="row control-group">
				                            <div class="form-group col-xs-12 floating-label-form-group controls">
				                                <label>Password:</label>
				                                <input type="password" data-validation-required-message="Please enter your password." required="" id="passWord" name="password" placeholder="Password" class="form-control">
				                                <p class="help-block text-danger"></p>
				                            </div>
				                        </div>
				                        
				                        <div class="row control-group">
				                            <div class="form-group col-xs-12 floating-label-form-group controls">
				                                <label>Confirm Password:</label>
				                                <input type="password" data-validation-required-message="Please confirm your password." required="" id="confirmPassword" placeholder="Re-type your Password" class="form-control">
				                                <p class="help-block text-danger"></p>
				                            </div>
				                        </div>
				                        
				                        <div class="row control-group">
				                        	<div id="captcha" onload="captchaLoad()"></div>
					
											<label>
												To prove that you are not a robot
												<span class="glyphicon glyphicon-refresh" id="refresh_captcha"></span>
												<input type="text" name="captcha" id="captcha-value" class="form-control" data-validation-required-message="Please enter the captcha code." required="" placeholder="Text in the above image"/>
											</label>
										</div>
				                        
				                        
				                        <br>
				                        <div id="success"></div>
				                        <div class="row">
				                            <div class="form-group col-xs-12">
				                                <input  class="btn btn-success btn-lg disabled" type="submit" id="signup-button" name="submit" value="Submit"></button>
				                                <button class="btn btn-default btn-lg" type="reset"><i class="fa fa-times"></i>Cancel &amp; reset</button>
				                            </div>
				                        </div>
				                    </form>
				                </div>
				            </div>
            
                            
                    </div>
                </div>
            </div>
   
	<?php }?>
	<?php include 'footer.php';?>

</body>
</html>
