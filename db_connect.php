<?php 
error_reporting(E_ALL & ~E_NOTICE);
 $servername="localhost";
 $dbusername="root";
 $dbpassword="";
 $dbname="Project5";

 mysql_connect($servername,$dbusername,$dbpassword) or die('database Connection Issue');
 mysql_select_db($dbname);
 ?>
