<?php
   $Name = $_REQUEST['c_name'];
   $Email = $_REQUEST['c_mail'];
   $Subject = $_REQUEST['c_tema'];
   $Message = $_REQUEST['c_mess'];
   $link = mysqli_connect("localhost","root","","dbhosting");
   $result = mysqli_query($link, $sql);
   $sql = "INSERT INTO `contact`(`c_name`,`c_mail`,`c_tema`,`c_mess`) VALUES("'.$Name.','.$Email.','.$Subject.','.$Message.'");";
   header("Location: index.html");	
?>