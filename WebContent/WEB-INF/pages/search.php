<?php

if(isset($_POST['search'])){
	
	$conn = mysqli_connect("localhost", "root", "", "longines");
	mysqli_select_db($conn,"longines");
	if(! $conn )
	{
		die('Could not connect: ' . mysql_error());
	}

	$search_name = $_POST['search_id'];
		
	$stmt2 = $conn->prepare("SELECT PROD_ID FROM PRODUCT WHERE PROD_NAME=?");
	$stmt2->bind_param("s", $search_name);
	$stmt2->execute();

	$res = $stmt2->get_result();
	$row = $res->fetch_assoc();
	echo $row['PROD_ID'];
	$stmt2->close();
	$conn->close();

}
?>