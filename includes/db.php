
<?php 
// Don't forget to Config $base_url when website hosted

$base_url="http://$_SERVER[SERVER_NAME]/mouse_store/";

//$base_url="http://$_SERVER[SERVER_NAME]/";

//$base_url="https://$_SERVER[SERVER_NAME]/";
$con = mysqli_connect("localhost","root","","mouse_store");

if(mysqli_connect_errno()){
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

mysqli_query($con,"SET NAMES 'utf8' ");

?>