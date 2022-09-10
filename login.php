
<div class="login_box">

  <form method = "post" action="">
    
	<table align="left" width="70%">
	
	  <tr align="left">	   
	   <td colspan="4">
	   <h2>Login.</h2><br />
	   <span>
	     Don't have account? <a href="register.php">Register Here</a><br /><br />
	   </span>
	   </td>	   
	  </tr>
	  
	  <tr>
	   <td width="15%"><b>Email:</b></td>
	   <td colspan="3"><input type="email" name="email" required placeholder="Email" /></td>
	  </tr>
	  
	  <tr>
	   <td width="15%"><b>Password:</b></td>
	   <td colspan="3"><input type="password" name="password" required placeholder="Password" /></td>
	  </tr>
	  
	  <tr align="left">
	   <td></td>
	   <td colspan="4">
	   <a href="checkout.php?forgot_pass">
	     Forgot Password
	   </a>
	   <br /><br />
	   </td>
	  </tr>
	  
	  <tr align="left">
	   <td></td>
	   <td colspan="4">
	   <input type="submit" name="login" value="Login" />
	   </td>
	  </tr>
	
	</table>
	
	
  </form>

</div>

<?php 
if(isset($_POST['login'])){
  
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  $password = md5($password);
  
  $run_login = mysqli_query($con, "select * from users where password='$password' AND email='$email' " );
  
  $check_login = mysqli_num_rows($run_login);
   
  
  $row_login = mysqli_fetch_array($run_login);
  
  $user_role = $row_login['role'];
  
  if($check_login == 0 ){
   echo "<script>alert('Password or email is incorrect, please try again!')</script>";
   exit();
  }elseif($check_login == 1 AND $user_role=="admin"){
        echo "<script>window.open('admin_area/index.php?logged_in=You have successfully Logged In!','_self')</script>";
  }
    
  $ip = get_ip();
  
  $run_cart = mysqli_query($con, "select * from cart where ip_address='$ip'");
  
  $check_cart = mysqli_num_rows($run_cart);
    

  
  if($check_cart==0 AND $user_role=="guest"){
  
  $_SESSION['user_id'] = $row_login['id'];
  
  $_SESSION['role'] = $user_role;
  
  $_SESSION['email'] = $email;
  echo "<script>alert('You have logged in successfully !')</script>";
  echo "<script>window.open('index.php','_self')</script>";
  echo "<script>window.open('index.php','_self')</script>";
  
  }else{
  $_SESSION['user_id'] = $row_login['id'];
  
  $_SESSION['role'] = $row_login['role'];
  
  $_SESSION['email'] = $email;
  echo "<script>alert('You have logged in successfully !')</script>";
  echo "<script>window.open('checkout.php?payment=process','_self')</script>";
  }
    
  
}

?>





