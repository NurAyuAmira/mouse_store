<?php 

if(!empty($_GET['tx'])){

$amount = $_GET['amt'];

$product_title = $_GET['item_name'];

$item_number = $_GET['item_number'];

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
  
  $select_cart = mysqli_query($con,"select quantity, product_price from cart where ip_address='$ip' and product_id='$item_number' ");
  
  $fetch_cart = mysqli_fetch_array($select_cart);
  
  $quantity = $fetch_cart['quantity'];
  
  $date = date("F/d/Y");
  
  $invoice_id = mt_rand();
  
  // Insert payment data transer to database
  
  $insert_payment = mysqli_query($con,"insert into payments (tx_id, product_id, product_price, buyer_id, invoice_id, currency_code, payment_status, payer_email, quantity, amount, date, type, payment_type) values ('$transaction_id', '$item_number', '$fetch_cart[product_price]', '$_SESSION[user_id]', '$invoice_id', '$currency_code', '$payment_status', '$_SESSION[email]', '$quantity', '$amount', '$date', 'single_item', 'Paypal') ");
  
  // Deleting products from the cart 
  $remove_cart = mysqli_query($con,"delete from cart where product_id='$item_number' and ip_address='$ip' ");
  
    
}

 // Check if paypal payment was successful
 
  $payment_result = mysqli_query($con,"select * from payments where tx_id='$transaction_id' ");
  
  if(mysqli_num_rows($payment_result) > 0){
  
  $fetch_payment = mysqli_fetch_array($payment_result);
  
  $product_price = '$'.$fetch_payment['product_price'];
  
  $total_paid = '$'.$fetch_payment['product_price'] * $fetch_payment['quantity'];
?>

<div class="container_success">
<h2>Thank you!</h2><br />

<div style="background:rgba(24,204,93,1);color:green;padding:10px">
You have purchased successfully.
</div>

<p>Your Email: <?php if(isset($_SESSION['email'])){echo $_SESSION['email'];}?></p>

<a href="http://localhost/mouse_store/index.php">Go back to shop</a>

</div>



<?php   } ?>

<?php }else{ ?>
    
 <h1>Your payment has failed.</h1>
 
 <a href="http://localhost/mouse_store/index.php">Back to products</a>
    
<?php } ?>