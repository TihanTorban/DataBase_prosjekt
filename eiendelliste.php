<!DOCTYPE html>
<html>
<head>
	<title>Web Photo Gallery</title>
    <meta http-equiv="content-type" content="=text/html; charset=utf-8 without BOM"/>
	<link rel="shortcut icon" href="img/favicon.ico">
	<link rel="stylesheet" href="style.css">
</head>
<!-------------------------------------------------------------------------------------->
<body>
	<a href="Oppgaver.html">Oppgaver</a>
	<?php
		include_once("mysql.php");
		db_connnect();
		$query = "SELECT * FROM eiendel";
		$result = $db->query($query);
		echo('<br/>');
		foreach($result as $r){
			print_r(implode(" ------ ",$r));echo('<br/>');
		}
	?>
</body>
</html>