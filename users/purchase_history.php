
<link href="users/css/purchase_history.css" rel="stylesheet" />

<div class="purchase_history_container">

<table>
    
 <thead>
   <tr>
     <th colspan="2"><h2>Purchase History</h2></th>
     <th>Invoice</th>
     <th>Date</th>
     <th>Price</th>
     <th>Payment Type</th>
     <th>Status</th>
     <th>Receipt</th>
   </tr>
 </thead> 
 
 <tr><th colspan="8"><div class="border_bottom"></div></th></tr>
 
 <?php 
 $purchase_result = mysqli_query($con,"select * from payments where buyer_id='$_SESSION[user_id]' ");
 
 while($fetch_payment = mysqli_fetch_array($purchase_result)){
  $select_product = mysqli_query($con, "select * from products where product_id='$fetch_payment[product_id]' ");
  
  $fetch_product = mysqli_fetch_array($select_product);
 ?>
 
 <tbody>
  <tr>
    <td colspan="2" width="35%">
     <div class="image_title_box">
       <div class="purchase_image">
        <img src="admin_area/product_images/<?php echo $fetch_product['product_image']; ?>" width="100" height="70" />  
       </div> 
       
       <div class="purchase_name">
        <p><a href="details.php?pro_id=<?php echo $fetch_product['product_id'];?>"> <?php echo $fetch_product['product_title']; ?></a></p>   
       </div>
     </div>    
        
    </td>   
    <td><?php echo $fetch_payment['invoice_id']; ?></td>
    <td><?php echo $fetch_payment['date']; ?></td>
    <td>RM <?php echo $fetch_payment['product_price']; ?></td>
    <td><?php echo $fetch_payment['payment_type']; ?></td>
    <td><?php echo $fetch_payment['payment_status']; ?></td>
    <td><a href="my_account.php?action=view_receipt&invoice_id=<?php echo $fetch_payment['invoice_id']; ?>">Receipt</a></td>
  </tr>   
 
  <tr><td colspan="8"><div class="border_bottom"></div></td></tr>
 </tbody>
 
 <?php } ?>
 
</table>
</div><!-- /.purchase_history_container -->
