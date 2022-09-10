<style>
.menubar{display:none !important;}
</style>

<!------------ Header starts --------------------->
<?php include('includes/header.php'); ?>
<!------------ Header ends ----------------------->

<link rel="stylesheet" href="styles/cart.css">

<!------------ Content wrapper starts -------------->
  <div class="content_wrapper">
	  
	  <div class="shopping_cart_container">
	  
	  <div class="cart_header">
	      
	  <div class="cart_header_box">
	    <h1><i class="fa fa-shopping-cart"></i> Shopping Cart</h1>  
	  </div><!-- /.cart_header_box -->
	      
	  </div><!---/.cart_header -------->
	  
	  <div class="cart_left">
	      
	    <div class="cart_left_box">
	  
	  <div id="shopping_cart">
	      
	  <div id="shopping_cart_box" style="color:green;font-weight:bold">   
	  
	  <?php 
	    if(isset($_SESSION['email'])){
		
		  echo "<b>Your Email: </b>" . $_SESSION['email'];
		
		}else{
		
		  echo "";
		}
	  
	  ?>
	  
	   <b style="color:green">Your Cart - </b> Total Items: <?php total_items();?> Total Price: <?php total_price(); ?>
	   
	   </div><!--/.shopping_cart_box-->
	   </div><!-- /.shopping_cart ------> 
	   
	   <form action="" method="post" enctype="multipart/form-data">
	   
	   <div class="cart_table">
	       
	   <table>
	   
	     <tr>
		   <th>Remove</th>
		   <th colspan="2">Product</th>
		   <th>Quantity</th>
		   <th>Price</th>
		 </tr>
		 
		 <tr><th colspan="5"><br></th></tr>
	<?php 
		 $total = 0;
   
   $ip = get_ip();
   
   $run_cart = mysqli_query($con, "select * from cart where ip_address='$ip' ");
   
   $count_cart = mysqli_num_rows($run_cart);
   
   if($count_cart > 1){
       $item_message = 'items';
   }else{
       $item_message = 'item';
   }
   
   
   while($fetch_cart = mysqli_fetch_array($run_cart)){
       
	   $product_id = $fetch_cart['product_id'];
	   
	   $qty = $fetch_cart['quantity'];
	   
	   $result_product = mysqli_query($con, "select * from products where product_id = '$product_id'");
	   	   
       while($fetch_product = mysqli_fetch_array($result_product)){
                
		$product_price = array($fetch_product['product_price']);

        $product_title = $fetch_product['product_title'];

        $product_image = $fetch_product['product_image'];
        
        $sing_price = $fetch_product['product_price'];
        
		$values = array_sum($product_price);
		
		$values_qty = $values * $qty;
		
		$total += $values_qty;
				
   
   ?>
		 <tr>
		   <td width="5%"><input type="checkbox" name="remove[]" value="<?php echo $product_id;?>" /></td>
		 
		 <td colspan="2">
		   
	   <div class="image_title_box">
       <div class="cart_image">
        <img src="admin_area/product_images/<?php echo $fetch_product['product_image']; ?>" width="100" height="70" />  
       </div> 
       
       <div class="cart_name">
        <p><a href="details.php?pro_id=<?php echo $fetch_product['product_id'];?>"> <?php echo $fetch_product['product_title']; ?></a></p>   
       </div>
     </div>    
		   </td>
		   <td><input class="qty_id" data-id="<?php echo $product_id; ?>" type="text" size="4" name="qty" value="<?php echo $qty; ?>" /></td>
		   <td><?php echo "RM " . $sing_price; ?></td>
		 </tr>
	   
	<?php } } // End While  ?> 
         
		<tr>
		   <td colspan="4" align="right"><b>Sub Total:</b></td>
		   <td><?php echo  total_price(); ?> </td>
		</tr>
	
	    <tr align="center">
		   <td colspan="2"><input type="submit" name="update_cart" value="Update Cart" /></td>
		   <td><input type="submit" name="continue" value="Continue Shopping" /></td>
		   
		</tr>
		
		<tr><th colspan="5"><br></th></tr>
		
	   </table>
	   
	   </div><!--/.cart_table--->
	   
	   </form>
	 
	 <input type="hidden" class="hidden_ip" value="<?php echo $ip; ?>">
	 
	 <div class="load_ajax"></div>
	   
	 <script>
	  $(document).ready(function(){
	    
	   $(".qty_id").on("keyup", function(){
	    
	    var pro_id = $(this).data("id");
	    
	    var qty = $(this).val();
	    
	    var ip = $(".hidden_ip").val();
	    
	    //alert(ip);
	    
	    // Update product quantity in ajax and php
	    $.ajax({
	    url:'cart/update_qty_ajax.php',
	    type:'post',
	    data:{id:pro_id,quantity:qty,ip:ip},
	    dataType:'html',
	    success:function(update_qty){
	     
	     //alert(update_qty);
	     
	     if(update_qty == 1){
	       $(".load_ajax").html('Your quantity was updated successfully!');
	     }
	        
	    }
	    
	    });
	    
	   });
	   
	  });   
	     
	 </script>  
	   
	   <?php 
	   if(isset($_POST['remove'])){
	     
		 foreach($_POST['remove'] as $remove_id){
		   
		  $run_delete = mysqli_query($con,"delete from cart where product_id = '$remove_id' AND ip_address='$ip' ");
		 
		 if($run_delete){
		    echo "<script>window.open('cart.php','_self')</script>";
		 }
		 }
		 
	   }
	   
	   if(isset($_POST['continue'])){
	     echo "<script>window.open('index.php','_self')</script>";
	   }
	   
	   ?>
	   
	   </div><!---- /.cart_left_box -->
	    
	  </div><!----- /.cart_left --------->
	  
	  <div class="cart_right">
	      
	    <div class="cart_right_box">
	     <h3>Total (<?php total_items(); echo ' ' . $item_message; ?>): <span style="color:orange"><?php total_price(); ?></span></h3>   
	    </div><!--/.cart_right_box-->
	    
	    <div class="checkout_button_box">
	    <a href="checkout.php?payment=process"><button>Checkout</button></a>
	    </div>
	    
	  </div><!--- /.cart_right ---------->
	  
	 </div><!-- /.shopping_cart_container-->
	
  </div><!-- /.content_wrapper-->
  <!------------ Content wrapper ends -------------->
  
  <?php include ('includes/footer.php'); ?>
  
  