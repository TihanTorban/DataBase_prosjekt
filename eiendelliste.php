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
	<a href="index.html">Oppgaver</a>
	<?php
		include_once("mysql.php");
		db_connnect();
		
		$query = "SELECT * FROM eiendel";
		$result1 = $db->query($query);
		// echo('<br/>');
		foreach($result1 as $r){
			$eiendel[] = $r;
		}
		
		$query = "SELECT * FROM tog";
		$result2 = $db->query($query);
		// echo('<br/>');
		foreach($result2 as $r){
			$tog[] = $r;
		}
		
		$query = "SELECT * FROM skinner";
		$result3 = $db->query($query);
		// echo('<br/>');
		foreach($result3 as $r){
			$skinner[] = $r;
		}
		
		$query = "SELECT * FROM miniatyrer";
		$result4 = $db->query($query);
		// echo('<br/>');
		foreach($result4 as $r){
			$miniatyrer[] = $r;
		}
		
		function searchAdress($id){
			global $db;
			$query = "SELECT * FROM oppbevares INNER JOIN sted ON oppbevares.Sted_Adress = sted.Adress WHERE oppbevares.Eiendel_ID = '$id'";
			// echo $query;
			$result5 = $db->query($query);
			// echo('<br/>');
			$sted = '';
			foreach($result5 as $r){
				return $r;
			}
			return '';
		}
		
		function search($arr, $verdy){
		// print_r($arr);
			$i=0;
			foreach($arr as $a){
				if ($a['Eiendel_ID'] == $verdy) {
					// echo ($a['Eiendel_ID'].'----->'.$verdy.'</br>')	;
					return TRUE;
				}
				$i++;
			}
			return FALSE;
		}
		echo('</br>');
		echo('ID' . "................beskrivelse: ................ sted	</br>");
		foreach($eiendel as $e){
			$beskrivelse = '';
			if (search($tog, $e['ID'])) 		$beskrivelse = 'Tog';
			if (search($skinner, $e['ID']))		$beskrivelse = 'Skinner';
			if (search($miniatyrer, $e['ID']))	$beskrivelse = 'Miniatyrer';
			$stedsvar = searchAdress($e['ID']);
			
			if (isset($stedsvar['Adress'])){
				$sted = $stedsvar['Adress'];
			}else{
				$sted = '';
			}
			
			echo($e['ID'] . "................" . $beskrivelse . "................" . $sted . "</br>");
		}
		
	?>
</body>
</html>