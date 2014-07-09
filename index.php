<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Upload page</title>
<style type="text/css">
body {
	background: #E3F4FC;
	font: normal 14px/30px Helvetica, Arial, sans-serif;
	color: #2b2b2b;
}
a {
	color:#898989;
	font-size:14px;
	font-weight:bold;
	text-decoration:none;
}
a:hover {
	color:#CC0033;
}

h1 {
	font: bold 14px Helvetica, Arial, sans-serif;
	color: #CC0033;
}
h2 {
	font: bold 14px Helvetica, Arial, sans-serif;
	color: #898989;
}
#container {
	background: #CCC;
	margin: 100px auto;
	width: 945px;
}

#form 			{padding: 20px 150px;}
#form input     {margin-bottom: 20px;}
</style>
</head>
<body>
<div id="container">
<div id="form">
<?php
				if(isset($_GET['remarks'])){
				$remarks=$_GET['remarks'];
				if ($remarks=='unsuccess')
				{
				?>
				<h1><?php echo 'Only CSV files accepted!';?></h1>
				<?php
				}				
				}
				?>
<?php

include "db_connect.php"; //Connect to Database

$deleterecords = "TRUNCATE TABLE cvsss"; //empty the table of its current records
mysql_query($deleterecords);

//Upload File
if (isset($_POST['submit'])) {
	function get_file_extension($file_name) {
		//print "enter into get file extension";
		//echo $file_name;
		return end(explode('.',$file_name));
	}
	if(get_file_extension($_FILES["filename"]["name"])!= 'csv'){
		
		header("location: index.php?remarks=unsuccess");
	}
	if (!$error){
	if (is_uploaded_file($_FILES['filename']['tmp_name'])) {
		echo "<h1>" . "File ". $_FILES['filename']['name'] ." uploaded successfully." . "</h1>";
		//echo "<h2>Displaying contents:</h2>";
		//readfile($_FILES['filename']['tmp_name']);
	}

	//Import uploaded file to Database	
		//open file in read mode
	$handle = fopen($_FILES['filename']['tmp_name'], "r");
				
	//fgetcsv have file length of the string and separator
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		$import="INSERT into cvsss(keyword,tag) values('$data[0]','$data[1]')";

		mysql_query($import) or die(mysql_error());
	}

	fclose($handle);

	print "Import done";
	}
	
	

	//view upload form
}else {

	print "Upload new csv by browsing to file and clicking on Upload<br />\n";

	print "<form enctype='multipart/form-data' action='#' method='post'>";

	print "File name to import:<br />\n";

	print "<input size='50' type='file' name='filename'><br />\n";

	print "<input type='submit' name='submit' value='Upload'></form>";

}

?>

</div>
</div>
</body>
</html>
