<?php 

session_start();



include("includes/db.php");

include("functions/functions.php");


?>

<!DOCTYPE html><!-- HTML5 Declaration -->
<html>

<head>
<meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1" /><!---- This is a responsive tag 
which will set the viewport of your page. The viewport varies with the device will be smaller on a mmobile phone than on a computer screen and give the browser instructions on how to control the
page's dimension and scaling ------>

<title>GM STORE </title>

<link rel="stylesheet" href="styles/desktop.css" media="all" />

<link rel="stylesheet" href="styles/tablet.css" media="all" />

<link rel="stylesheet" href="styles/mobile.css" media="all" />

<link rel="stylesheet" href="styles/side_navigation_bar.css" media="all" />

<link rel="stylesheet" href="styles/cart_navigation.css" media="all" />

<!---<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">---->

<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">

<script src="js/jquery-3.4.1.js"></script>

</head>

<body>

<!-- Main container starts here -->
<div class="main_wrapper">
  
  <div class="header_wrapper">
  
  <!-------- Side Navigation Bar Starts ----------------->
  <div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()" >&times;</a>
  <ul id="side_navigation_bar">
  
  <!-------- User profile on mobile device -------------------->
  <li class="user_profile_box">
  
  <?php if(!isset($_SESSION['user_id'])){ ?>
  
  <div class="register_login_mobile">
  
  <div><a href="register.php">Register / Login</a></div>
  </div><!-- /.register_login --> 
  
  <?php }else{ ?>
  
  <?php 
  $select_user = mysqli_query($con,"select * from users where id='$_SESSION[user_id] '");
  $data_user = mysqli_fetch_array($select_user);
  ?>
  
  <div id="profile" class="profile_mobile">
    
	<ul>
	  <li class="dropdown_header">
	   <a>
	   
	   <?php if($data_user['image'] !=''){ ?>
	   
	    <span><img src="upload-files/<?php echo $data_user['image']; ?>"><span class="user_profile_name">Hi, <?php echo $data_user['name'];?></span></span> 
		 
	   <?php }else{ ?>
	   
	   <span><img src="images/profile-icon.png"><span class="user_profile_name">Hi, <?php echo $data_user['name'];?></span></span>
	   
	   <?php } ?>
	   
	   </a>
	   
	   <ul class="dropdown_menu_header">
	     <li><a href="my_account.php?action=edit_account">Account Setting</a></li>
	     <li><a href="my_account.php?action=purchase_history">Purchase History</a></li>
		 <li><a href="logout.php">Logout</a></li>
	   </ul>
	   
	  </li>
	</ul>
  </div>
  
  <?php } ?>
  
  </li>
  
  <!-------- End user profile on mobile device ----------------->
  
	  <li><a href="index.php">Home</a></li>
	  <li><a href="all_products.php">All Products</a></li>
	  <li><a href="my_account.php?action=edit_account">My Account</a></li>
	  <li><a href="cart.php">Shopping Cart</a></li>
	  <li><a href="contact.php">Contact Us</a></li>
	  <li><a href="logout.php">Logout</a></li>
	</ul>
</div>

<span class="three_line_button" style="font-size:20px;cursor:pointer;top:10px;left:10px" onclick="openNav()">&#9776;</span>

<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "300px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>
  
  <!-------- Side Navigation Bar Ends --------------------->
  
  <div class="header_logo">
  <a href="index.php">
  <img id="logo" src="images/logo_gmstore.png" style="width:100px;height:40px" />
  </a>
  </div><!--/.header_logo-->
  
  <div class="search_container">
  
  <div class="search_mobile_box">
    <span class="fa fa-search search_mobile"></span>
	
  </div><!--/.search_mobile_box-->
  
  <div id="form_mobile">
     <form method="get" action="results.php" enctype="multipart/form-data">
	  <input type="text" name="user_query" placeholder="Search a Product" />
	  <input type="submit" name="search" value="Search" />
	 </form>
  </div> 
  
  <div id="form">
     <form method="get" action="results.php" enctype="multipart/form-data">
	  <input type="text" name="user_query" placeholder="Search a Product" />
	  <input type="submit" name="search" value="Search" />
	 </form>
  </div>  
  
  </div><!------/.search_container-->
  
  <!--------- Cart Navigation Starts -------------------------->
  
  <?php include 'cart/cart_navigation.php'; ?>
  
  <!--------- Cart Navigation Ends -------------------------->
  
  
  <?php if(!isset($_SESSION['user_id'])){ ?>
  
  <div class="register_login register_login_desktop">
  <div class="login"><a href="index.php?action=login">Login</a></div>
  &nbsp;&nbsp;
  <div class="register"><a href="register.php">Register</a></div>
  </div><!-- /.register_login --> 
  
  <?php }else{ ?>
  
  <?php 
  $select_user = mysqli_query($con,"select * from users where id='$_SESSION[user_id] '");
  $data_user = mysqli_fetch_array($select_user);
  ?>
  
  <div id="profile" class="profile_desktop">
    
	<ul>
	  <li class="dropdown_header">
	   <a>
	   
	   <?php if($data_user['image'] !=''){ ?>
	   
	    <span><img src="upload-files/<?php echo $data_user['image']; ?>"></span> 
		 
	   <?php }else{ ?>
	   
	   <span><img src="images/profile-icon.png"></span>
	   
	   <?php } ?>
	   
	   </a>
	   
	   <ul class="dropdown_menu_header">
	     <li><a href="my_account.php?action=edit_account">Account Setting</a></li>
	     <li><a href="my_account.php?action=purchase_history">Purchase History</a></li>
		 <li><a href="logout.php">Logout</a></li>
	   </ul>
	   
	  </li>
	</ul>
  </div>
  
  <?php } ?>
  
  </div><!-- /.header_wrapper --> 

<!------------ Navigation Bar starts ------------->
  <div class="menubar">
    <ul id="menu">
	  <li><a href="index.php">Home</a></li>
	  <li><a href="all_products.php">All Products</a></li>
	  <li><a href="my_account.php?action=edit_account">My Account</a></li>
	  <li><a href="cart.php">Shopping Cart</a></li>
	  <li><a href="contact.php">Contact Us</a></li>
	  <li><a href="logout.php">Logout</a></li>
	</ul>
  </div><!-- /.menubar --->
  
 

 
 <?php include('js/drop_down_menu.php'); ?>
  
  
  
  
  
  