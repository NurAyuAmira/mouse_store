<div class="cart">
    <ul>
	  <li class="dropdown_header_cart">
	   <div id="notification_total_cart" class="shopping-cart">
	     <!--<img src="images/cart_icon.png" id="cart_image">-->
		 <i class="fa fa-shopping-cart" style="font-size:30px"></i>
          <div class="noti_cart_number">
            <?php total_items();?>
          </div><!-- /.noti_cart_number -->		  
	   </div><!--/.shopping-cart ------------>
	   
	   <ul class="sub_dropdown_cart">
	     <li>
           <div style="padding:10px">Shopping Cart</div>
           
           <div id="over_flow">
           <?php
           $ip = get_ip();
           
           $sel_cart = mysqli_query($con,"select * from cart where ip_address='$ip' ");
           
           while($row_c = mysqli_fetch_array($sel_cart)){
             $get_pro_id = $row_c['product_id']; 
             
             $product_purchase = mysqli_query($con,"select * from products where product_id = '$get_pro_id' ");
             
             while($row_product = mysqli_fetch_array($product_purchase)){
            
            ?>
            
            <div class="cart_item_box">
                
             <div class="cart_item_image">
              <img src="admin_area/product_images/<?php echo $row_product['product_image']; ?>">    
             </div><!----/.cart_item_image -->
             
             <div class="cart_item_text_box">
                 
              <div class="cart_item_title">
                <p>
                 <a href="details.php?pro_id=<?php echo $get_pro_id;?>"><?php echo $row_product['product_title']; ?></a>
                </p>  
              </div><!--/.cart_item_title--->
              
              <div class="cart_item_price">
                <p style="color:#009c77">
                RM<?php echo $row_c['product_price']; ?>
                </p>  
              </div><!--/.cart_item_price -->
              
             </div><!---/.cart_item_text_box ----->
             
            </div><!--------/.cart_item_box -------------->
            
            <?php } } // End While Loop  ?>  
            
           </div><!--- /#over_flow ---->
	       
	       <div class="cart_item_border"></div>
	       
	       <div style="height:35px;line-height:35px;text-align:right;padding-right:30px">Your Total: <span style="color:orange"><?php total_price(); ?></span></div>
	        
	        <?php if(mysqli_num_rows($sel_cart) > 0) { ?>
	        
	        <div class="go_to_cart_btn_box" align="center">
	         <a href="cart.php"><button id="btn_go_to_cart">Go to Cart</button></a>    
	        </div>
	        <?php } ?>
	           
	     </li>
	   </ul>
	   
	  </li>
	</ul>
  </div>   