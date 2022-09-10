

<!------------ Header starts --------------------->
<?php include('includes/header.php'); ?>
<!------------ Header ends ----------------------->
<link href="styles/checkout.css" rel="stylesheet" type="text/css" />
<!------------ Content wrapper starts -------------->

<?php if($_GET['payment'] != 'payment-successful'){ ?>

  <div class="content_wrapper">	  
	    
	  <?php 	  
      if(!isset($_SESSION['user_id'])){
	     include('login.php');
	  }else{
	  
	  $invoice_number = mt_rand();
	  
	  $ip = get_ip();
	  
	  $update_cart = mysqli_query($con,"update cart set buyer_id='$_SESSION[user_id]', invoice_number='$invoice_number' where ip_address='$ip' ");
	  ?>
	  
	  
	  
	  <div class="checkout_container">
	  
	  <div class="checkout_header">
	  
	  <div class="checkout_header_box">
	  <h1><i class="fa fa-shopping-cart"></i> Checkout</h1>
	  </div><!-- /.checkout_header_box -->
	  
	  </div><!---/.checkout_header -->
	  
	  <div class="checkout_left">
	  
	  <div class="checkout_left_box">
	  <h3>Your Item (<?php total_items();?>)</h3>
	  
	  <div class="checkout_left_item_border_bottom"></div>
	  
	  <?php 
	  $checkout_ip = get_ip();
	  
	  $sel_cart = mysqli_query($con,"select * from cart where ip_address='$checkout_ip' ");
	  
	  while($fetch_cart = mysqli_fetch_array($sel_cart)){
	  
	  $sel_product = mysqli_query($con,"select * from products where product_id='$fetch_cart[product_id]'");
	  
	  while($fetch_product = mysqli_fetch_array($sel_product)){
	  
	  ?>
	  
	  <div class="checkout_left_product_box">
	  <img src="admin_area/product_images/<?php echo $fetch_product['product_image']; ?>">
	  
	  <p class="checkout_left_title"><?php echo $fetch_product['product_title']; ?></p>
	  
	  <p style="color:green">RM <?php echo $fetch_product['product_price']; ?></p>
	  </div><!-- /.checkout_left_product_box -->
	  
	  <?php } } ?>
	  </div><!--/.checkout_left_box -->
	  
	  </div><!-- /.checkout_left -->
	  
	  <div class="checkout_right">
	  
	  <div class="checkout_right_box">
	  
	  <div class="checkout_total_price">
	  <p>Total: <?php total_price(); ?></p>   
	  </div>
	  
	  <h4 style="margin:10px 0">Please choose your preferred method of payment.</h4>
	  
	  <div class="payment_method_container">
	  <div class="payment_method_box">
	    
		<div class="payment_method_header accordion-toggle payment_method_paypal">
		<input type="radio" id="paypal_radio" name="paypal_radio" value="paypal" checked><img src="images/pp-logo-100px.png">
		
		</div><!---/.payment_method_header-->
		
		<div class="payment_method_body payment_method_body_paypal accordion-content">
		 
		 <p>In order to complete your transaction, we will transfer you over to Paypal's secure servers.</p>
		 
		 <div class="payment_gateway_box">
	     <?php include('payment.php'); ?>
	     </div>
		 
		 <div class="paypal_text_box">
		  <div class="paypal__text">
		   <p>By completing your purchase, you agree to these <a href="https://www.metrixcode.com/info/terms" target="_blank" style="text-decoration:none">Terms of Service.</a></p>
		  </div>
		  
		  <div class="paypal__lock">
		   <i class="fa fa-lock"></i><span> Secure Conection</span>
		  </div>
		  
		 </div><!--/.paypal_text_box-->
		 
		</div><!--/.payment_method_body-->
		
	  </div><!--/.payment_method_box------->
	  </div><!---/.payment_method_container------------->
	  
	  
	   <div class="payment_method_container">
	  <div class="payment_method_box">
	    
		<div class="payment_method_header accordion-toggle payment_method_offline">
		<input type="radio" id="offline_payment_radio" name="offline_payment_radio" value="offline_payment"><span>Offline Payment Methods (Cash on Delivery)</span>
		
		</div><!---/.payment_method_header-->
		
		<div class="payment_method_body payment_method_body_offline accordion-content" style="display:none">
		 
		 <div class="payment_gateway_box">
	     
		 <div class="payment_offline_form_box">
		  <div class="payment_offline_btn_box">
		   <button id="payment_offline_btn">Complete Order <i class="fa fa-arrow-circle-right"></i></button>
		  </div>
		  
		 </div>
		 
	     </div>
		 
		</div><!--/.payment_method_body-->
		
	  </div><!--/.payment_method_box------->
	  </div><!---/.payment_method_container------------->
	  
	  </div><!-- /.checkout_right_box -->
	  
	  </div><!-- /.checkout_right -->
	  
	  <div class="load_checkout_message"></div><!--/.load_checkout_message-->
	  
	  <div class="load_billing_address"></div><!--/.load_billing_address-->
	  
	  </div><!-----/.checkout_container -->
	  
	  <?php   } ?>
  </div><!-- /.content_wrapper-->
  <!------------ Content wrapper ends -------------->
  
  <?php include ('includes/footer.php'); ?>
  
  <input type="hidden" id="checked_on_page_reload" value="<?php echo $_SESSION['checked_on_page_reload'];?>">
  
  <input type="hidden" id="get_user_id" value="<?php echo $_SESSION['user_id']; ?>">
  <input type="hidden" id="get_user_ip" value="<?php echo $ip; ?>">
  
  <input type="hidden" id="get_invoice_number" value="<?php echo $invoice_number; ?>">
  
  <div class="checkout_background_loading">
   <img src="images/spinner_loader.gif">
  </div>  
  
  <script>
  $(document).ready(function(){
  
    insert_offline_payment_data();
	
	display_billing_address();
  });
  
  /////// Hide menubar /////////////////////////////////
  $(".menubar").hide();
  
  ////// On click auto check or uncheck radio button ///
  $(".payment_method_paypal").on('click',function(){
    $("#paypal_radio").prop("checked", true);
	$("#offline_payment_radio").prop("checked", false);
  });
  
  $(".payment_method_offline").on('click',function(){
    $("#paypal_radio").prop("checked", false);
	$("#offline_payment_radio").prop("checked", true);
  });
  
  //////// On click auto hide or show accordion content ///////
  $(document).on('click','.accordion-toggle',function(){
  
   if($(this).attr('class').indexOf('open') == -1){
     $(this).toggleClass('open').next().slideToggle('fast');
   }
   
   // Hide the other panels
   $(".accordion-toggle").not($(this)).removeClass("open");
   $(".accordion-content").not($(this).next()).slideUp('fast');
  });
  
  //////// On page reload keep radio button checked ////////
  
  $(document).on("click",".accordion-toggle", function(){
    
	if($(this).hasClass('payment_method_offline')){
	  var radio_name = 'payment_method_offline';
	}else if($(this).hasClass('payment_method_paypal')){
	  var radio_name = 'payment_method_paypal';
	}
	
	$.ajax({
	  url:'ajax/get_session_checked_ajax.php',
	  type:'post',
	  data:{get_radio_name:radio_name},
	  dataType:'html',
	  success: function(get_session_checked){
	      //alert(get_session_checked);
	  }	  
	});	
  });
  
  $(document).ready(function(){
    
	var radio_name_page_reload = $("#checked_on_page_reload").val();
	
	if(radio_name_page_reload == 'payment_method_offline'){
     
	 $(".payment_method_offline").addClass('open');
	 
	 $("#paypal_radio").prop("checked", false);
	 $("#offline_payment_radio").prop("checked", true);
	 
	 $(".payment_method_body_offline").slideDown("fast");
	 $(".payment_method_body_paypal").slideUp('fast');
	}
	
  });
  
  function send_mail_offline(tx_id){
      
     $.ajax({
      url:'ajax/send_mail_offline_ajax.php',
      type:'post',
      data:{tx_id:tx_id},
      dataType:'html',
      success: function(sendmail){
        /*if(sendmail ==1){
          alert('An email has been sent'+sendmail);
        }else{
          alert('An error occured while sending mail'+sendmail);
        }*/
        
      }
     });
  }
  
  function insert_offline_payment_data(){
    
	var user_id = $("#get_user_id").val();
	
	var user_ip = $("#get_user_ip").val();
	
	//alert(user_ip);
	
	$("#payment_offline_btn").on('click',function(){
	 
	  $.ajax({
	   url:'ajax/insert_offline_payment_data_ajax.php',
	   type:'post',
	   data:{userID:user_id,userIP:user_ip},
	   dataType:'json',
	   beforeSend: function(){
	    
		$(".checkout_background_loading img").css({"top":"30%"});
		
	    $(".checkout_background_loading").show();
		
	   },
	   success: function(insert_offline_payment){
	    
		//alert(insert_offline_payment[0]);		
		
		if(insert_offline_payment[0] == 'ok'){
		  //alert('You have purchased successfully !');
		  
		  setTimeout(function(){
		  
		  $(".load_checkout_message").html('<a href="checkout.php?payment=process"><div class="success_message"><i class="fa fa-check"></i> You have purchased successfully ! <i class="fa fa-close"></i></div></a>');
		  
		  close_message_box();
		  
		  $(".checkout_background_loading").hide();
		  
		  },1000);	  
		  
		  ////////// Mail Starts //////////////////////////
		  
		  var tx_id = insert_offline_payment[2];
		  
		  send_mail_offline(tx_id);
		  
		  ////////// Mail Ends ////////////////////////////
		  
		  setTimeout(function(){
		  window.open('checkout.php?payment=payment-successful&code='+insert_offline_payment[2],'_self');
		  
		  }, 5000);
		  
		  
		  
		}else{
		  if(insert_offline_payment[1] == 'empty'){
		    //alert('Your cart is empty !');
			
			setTimeout(function(){
			
			 $(".load_checkout_message").html('<div class="error_message"><i class="fa fa-shopping-cart"></i> Your cart is empty ! <i class="fa fa-close"></i></div>');
			 
			 $(".checkout_background_loading").hide();
			 
			 close_message_box();
			 
			}, 2000);
			
			
		  }
		  
		  if(insert_offline_payment[0] == 'logged out'){
		  
		    setTimeout(function(){
			
			 $(".load_checkout_message").html('<a href="checkout.php?payment=process"><div class="error_message"><i class="fa fa-sign-in"></i> You have logged out. Please log in to complete order ! <i class="fa fa-close"></i></div></a>');
			 
			 $(".checkout_background_loading").hide();
			 
			 close_message_box();
			 
			}, 2000);
		    
		  }
		}
		
	   }
	   
	  });
	  
	});
	
  }
  
  function display_billing_address(){
    var user_id = $("#get_user_id").val();
	
	var invoice_number = $("#get_invoice_number").val();
	//alert(user_id);
	
	$.ajax({
	  url:'ajax/display_billing_address_ajax.php',
	  type:'post',
	  data:{post_user_id:user_id, invoice_number:invoice_number},
	  dataType:'html',
	  success: function(buyer_billing_address){
	   //alert(buyer_billing_address);
	  $(".load_billing_address").html(buyer_billing_address); 
	  
	  edit_billing_address();
	  
	  }
	});
  }
  

  function close_message_box(){
    $(".load_checkout_message .fa-close").on('click',function(){
	  $(this).parents(".load_checkout_message").find("div").hide();
	});
	
  }
  </script>
  
<?php }else{ ?>

<?php include 'payment-gateway-successful.php'; ?>

<?php } ?>
  
  
  
  
  
  
