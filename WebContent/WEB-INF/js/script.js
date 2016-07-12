$(document).ready(function() {
	
	console.log("in dom");
	captchaLoad();
	
	$(function() {
	    var availableTags = [
	      "HydroConquest-Blue",
	      "HydroConQuest-Black",
	      "SAINT IMIER",
	      "Saint IMIER LEAR"
	    ];
	    $( "#search-input, #search-input-mobile" ).autocomplete({
	      source: availableTags
	    });
	  });
	
	register_submit_enable();
	$("#item_quantity").change(buy_submit_enable);
		
	function buy_submit_enable(){
		var quantity = $("#item_quantity").val();
		if(quantity != ""){
			$("#buy-button").removeClass("disabled");
		}else{
			$("#buy-button").addClass("disabled");
		}
	}
	
	$("#firstName, #lastName, #email, #passWord, #confirmPassword, #mobileNumber, #captcha-value").keyup(register_submit_enable);	
	function register_submit_enable(){
		
		var firstName = $("#firstName").val();
		var lastName = $("#lastName").val();
		var email = $("#email").val();
		var password = $("#passWord").val();
		var userName = $("#userName").val();
		var confirmPassword = $("#confirmPassword").val();
		var mobileNumber = $("#mobileNumber").val();
		var captcha = $("#captcha-value").val();
		
		
		if(firstName != "" && lastName != "" && email != "" && password != "" && userName != "" && confirmPassword != "" && captcha!= ""){
			$("#signup-button").removeClass("disabled");
		}else{
			$("#signup-button").addClass("disabled");
		}
	}
	
	
	function captchaLoad(){
		$("#captcha").html("");
		var images = ['../captchas/captcha1.jpg', '../captchas/captcha2.jpg', '../captchas/captcha3.jpg'];
		$('<img src="' + images[Math.floor(Math.random() * images.length)] + '" class="img-responsive">').appendTo('#captcha');
	}
	
	$("#refresh_captcha").click(function(){
		captchaLoad();
	});
	
	$("#searchButton, #searchButton_mobile").click(function(event){
		searchForm();
		event.preventDefault();
	});
	
	$("#serachForm").submit(function(event){
		searchForm();
		event.preventDefault();
	});
	
	
	function searchForm(){
		var searchName = $("#search-input").val();
		var data="search=search&search_id="+searchName;
		$.ajax({
			type:"post",
			url:"../pages/search.php",
			data:data,
			success: function(response){
				window.location.href = "/project/WebContent/WEB-INF/pages/watchDetails.php?id="+response;
				return false;
			}
		});
	}
	$("#signup-button").click(function(){
		var firstName = $("#firstName").val();
		var lastName = $("#lastName").val();
		var email = $("#email").val();
		var password = $("#passWord").val();
		var userName = $("#userName").val();
		
		var confirmPassword = $("#confirmPassword").val();
		var mobileNumber = $("#mobileNumber").val();
		var captchaImage = $("#captcha img").attr("src");
		var captcha = $("#captcha-value").val();
		if(firstName != null && lastName != null && email != null && password != null && userName!= null && confirmPassword != null && mobileNumber != null && captcha!= null){
			if(password !== confirmPassword){
				register_error("Both the password should match");
			}
			else if( (captchaImage !== '/captchas/captcha1.jpg' && captcha!=='no23sdf') || (captchaImage !== '/captchas/captcha2.jpg' && captcha!=='Ur3UX') ||
					(captchaImage !== '/captchas/captcha3.jpg' && captcha!=='F62PB') ){
				
				register_error("The entered captcha code is not correct");
				
			}
			else{
				if(!$("#error-message[class*='hide']")){
					$("#error-message").addClass("hide");
				}
			}
		}else{
			register_error("There are errors in the page");
		}
		
	});
	function register_error(error_message){
		$("#error-message").html(error_message);
		$("#error-message").removeClass("hide");
		return false;
	}
	
	$("#login-button, #login-button-mobile").click(function(){
		$("#portfolioModal1").modal('show');
		return false;
	});
	
	
	$("#delete-item").click(function(){
		var prod_id = $("#delete-item").data("prod-id");
		var data="delete=delete&delete_prod_id="+prod_id;
		$.ajax({
			type:"post",
			url:"../pages/cart.php #cart-main?name=delete",
			data:data,
			success: function(data){
				$("#refresh-div").replaceWith(data);
				return false;
			}
		});
		
	});
//	var script = document.createElement('script');
//	script.type = 'text/javascript';
//	script.src = 'http://maps.googleapis.com/maps/api/js?callback=initialize&v=3.exp&sensor=false&language=nl'; //add you api key later
//	document.body.appendChild(script);
//
//	function initialize(element_id, lat, lng, zoom) 
//	{
//	    zoom = 10;
//
//	    var mapLocation = new google.maps.LatLng(lat, lng);
//	    var mapOptions = 
//	    {
//	        center: mapLocation,
//	        zoom: zoom
//	    };
//
//	    var map = new google.maps.Map(document.getElementById(element_id), mapOptions);
//	}
	
});



     
