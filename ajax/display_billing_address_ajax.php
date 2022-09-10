

<?php 
session_start();

if(isset($_SESSION['user_id'])){

include '../includes/db.php';

$user_id = $_POST['post_user_id'];

$invoice_number = $_POST['invoice_number'];

$select_user = mysqli_query($con,"select * from users where id='$user_id' ");

$fetch_user = mysqli_fetch_array($select_user);

//echo $fetch_user['user_address'];

$select_note = mysqli_query($con,"select * from additional_notes where user_id='$user_id' ");

if(mysqli_num_rows($select_note) > 0){

  $update = mysqli_query($con,"update additional_notes set invoice_number='$invoice_number' where user_id='$user_id' ");
  
}else{
  $insert_note = mysqli_query($con,"insert into additional_notes (invoice_number, user_id, type, payment_type) values ('$invoice_number', '$user_id', 'offline', 'Offline Payment' ) ");
}

$fetch_note = mysqli_fetch_array($select_note);
?>

<div class="billing_address_box">
 <div class="billing_address_header">
  <h3>Billing Address</h3> 
  <div class="billing_address_border_header"></div>
 </div>
 
 <div class="billing_address_content">
	 <p><strong><?php echo $fetch_user['name'];?></strong></p>
	 <p><?php echo $fetch_user['user_address']; ?></p>
	 <p>City: <?php echo $fetch_user['city']; ?></p>
	 <p>Country: <?php echo $fetch_user['state']; ?></p>
	 <p>Contact: <?php echo $fetch_user['contact']; ?></p>
 

 
 </div>
</div>


<div class="billing_address_form_box" style="display:none">
 <div class="billing_address_header">
 
  
  <div class="billing_address_border_header"></div>
 </div>
 
 <div class="billing_address_content">
	 <p><input type="text" id="edit_name" value="<?php echo $fetch_user['name'];?>"></p>
	 <p><textarea id="edit_user_address"><?php echo $fetch_user['user_address']; ?></textarea></p>
	 <p><input type="text" id="edit_city" value="<?php echo $fetch_user['city']; ?>"></p>
	 <p><input type="text" id="edit_state" value="<?php echo $fetch_user['state']; ?>"></p>
	 <p><input type="text" id="edit_contact" value="<?php echo $fetch_user['contact']; ?>"></p>
 
	
     
	
 </div>
</div>

<?php } ?>

