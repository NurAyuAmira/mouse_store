
<?php include 'includes/header.php'; ?>

<link href="styles/checkout.css" rel="stylesheet">

<style>
.menubar{display:none !important;}
</style>



<?php if(isset($_GET['item_name']) && isset($_GET['item_number'])){ ?>

<!------------- Single item payment starts --------------------------------->
  <?php include 'payment_single_item.php'; ?>
  
<!------------- Single item payment ends ------------------------------------>


<?php }else{ ?>

<!------------- Multiple items payment starts --------------------------------->
  <?php include 'payment_multiple_items.php'; ?>
  
<!------------ Multiple items payment ends ------------------------------------>

<?php } ?>

