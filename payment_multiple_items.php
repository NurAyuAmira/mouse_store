

<?php 

if(!empty($_GET['tx'])){

$amount = $_GET['amt'];

$transaction_id = $_GET['tx'];

$currency_code = $_GET['cc'];

$payment_status = $_GET['st'];

// Getting user information
$select_customer = mysqli_query($con,"select * from users where id='$_SESSION[user_id]' ");

$fetch_customer = mysqli_fetch_array($select_customer);

$customer_name = $fetch_customer['name'];

// Check if payment data exists with the same transaction ID

$check_previous_payment = mysqli_query($con,"select payment_id from payments where tx_id='$transaction_id' ");

if(mysqli_num_rows($check_previous_payment) > 0){
    
}else{
  
  $ip = get_ip();  
  
  $select_cart = mysqli_query($con,"select * from cart where ip_address='$ip' and buyer_id='$_SESSION[user_id]' ");
  
  while($fetch_cart = mysqli_fetch_array($select_cart)){
  
  $quantity = $fetch_cart['quantity'];
  
  $date = date("F/d/Y");
  
  $invoice_id = $fetch_cart['invoice_number'];
  
  // Insert payment data transer to database
  
  $insert_payment = mysqli_query($con,"insert into payments (tx_id, product_id, product_price, buyer_id, invoice_id, currency_code, payment_status, payer_email, quantity, amount, date, type, payment_type) values ('$transaction_id', '$fetch_cart[product_id]', '$fetch_cart[product_price]', '$fetch_cart[buyer_id]', '$invoice_id', '$currency_code', '$payment_status', '$_SESSION[email]', '$quantity', '$fetch_cart[product_price]', '$date', 'multiple_items', 'Paypal') ");
  }
  // Deleting products from the cart 
  $remove_cart = mysqli_query($con,"delete from cart where buyer_id='$_SESSION[user_id]' and ip_address='$ip' ");
  
?>



<?php } // End else ?>

<?php 

 // Check if paypal payment was successful
 
  $payment_result = mysqli_query($con,"select * from payments where tx_id='$transaction_id' ");
  
  if(mysqli_num_rows($payment_result) > 0){
  
  $fetch_payment = mysqli_fetch_array($payment_result);
  
  $product_price = '$'.$fetch_payment['product_price'];
  
  $total_paid = '$'.$fetch_payment['product_price'] * $fetch_payment['quantity'];
?>

<!-------------- Details of order starts --------------------------------->

<?php 

$select_payment = mysqli_query($con,"select * from payments where tx_id='$_GET[tx]' ");

$fetch_invoice = mysqli_fetch_array($select_payment);

$checkout_invoice = $fetch_invoice['invoice_id'];

$select_user = mysqli_query($con,"select * from users where id='$fetch_invoice[buyer_id]'");

$fetch_user = mysqli_fetch_array($select_user);

?>

<div class="checkout_container">
	  
  <div class="checkout_header">
  
  <div class="checkout_header_box">
  <h1><i class="fa fa-check"></i> Checkout</h1>
  </div><!-- /.checkout_header_box -->
  
  </div><!---/.checkout_header -->
  
  <div class="payment_successful_container">
   <div class="payment_successful_box">
    
	<div class="payment_successful_left">
	 <div class="payment_successful_left_box">
	  <img src="images/payment_successful.png">
	</div><!--/.payment_successful_left_box------->
	</div><!--/.payment_successful_left------------->
	
	<div class="payment_successful_right">
	 <div class="payment_successful_right_box">
	  <div class="thank_you_box">
	   <i class="fa fa-check"></i> Thank you. Your order was completed successfully!
	  </div>
	  
	  <div class="checkout_invoice_box">
	  <?php echo $checkout_invoice; ?> <a href="my_account.php?action=view_receipt&invoice_id=<?php echo $checkout_invoice;?>" target="_blank"><i class="fa fa-angle-right"></i></a>
	  </div>
	  
	  <?php 
	  $select_payment_by_invoice = mysqli_query($con,"select * from payments where invoice_id='$checkout_invoice' ");
	  
	  while($row_payment = mysqli_fetch_array($select_payment_by_invoice)){
	   
	   $select_product = mysqli_query($con,"select * from products where product_id='$row_payment[product_id]' ");
	   
	   $row_product = mysqli_fetch_array($select_product);
	  ?>
	  
	  <p><?php echo $row_payment['quantity'];?> x <?php echo $row_product['product_title'];?></p>
	  
	  <?php } ?>
	  
	  
	  
	</div><!--/.payment_successful_right_box------->
	</div><!--/.payment_successful_right------------->
	
   </div><!--/.payment_successful_box------------------->
  </div><!--/.payment_successful_container----------------->
  
</div><!--/.checkout_container-------------------------------->

<!-------------- Details of order ends ----------------------------------->




<?php   } ?>

<?php }else{ ?>
    
 <h1>Your payment has failed.</h1>
 
 <a href="http://localhost/mouse_store/index.php">Back to products</a>
    
<?php } ?>