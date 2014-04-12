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
		
		function select($tabel){
			global $db;
			$query = "SELECT * FROM $tabel";
			$result = $db->query($query);
			foreach($result as $r){
				$tab[] = $r;
			}
			return $tab;
		}

		function search($arr, $verdy){
			$i=0;
			foreach($arr as $a){
				if ($a['Eiendel_ID'] == $verdy) {
					return TRUE;
				}
				$i++;
			}
			return FALSE;
		}
		
		function beskrivelse($eiendel_id){
			$beskrivelse = '';
			if (search(select('tog'), $eiendel_id)) 			$beskrivelse = 'Tog';
			if (search(select('skinner'), $eiendel_id))		$beskrivelse = 'Skinner';
			if (search(select('miniatyrer'), $eiendel_id))	$beskrivelse = 'Miniatyrer';
			return $beskrivelse;
		}
		
		/* EIENDEL */
		$eiendel = array();
		//$query = "SELECT * FROM oppbevares 
		//			INNER JOIN eiendel ON eiendel.ID = oppbevares.Eiendel_ID
		//			INNER JOIN har_tilgang ON har_tilgang.Sted_Adress = oppbevares.Sted_Adress
		//			INNER JOIN person ON person.PersonNR = har_tilgang.Medlem_Person_personNR";
					
		$query = "SELECT * FROM eiendel 
					INNER JOIN oppbevares ON eiendel.ID = oppbevares.Eiendel_ID
					INNER JOIN har_tilgang ON har_tilgang.Sted_Adress = oppbevares.Sted_Adress
					INNER JOIN person ON person.PersonNR = har_tilgang.Medlem_Person_personNR";
					
		$result = $db->query($query);
		
		foreach($result as $r){
			$eiendel[] = $r;
		//print_r ($r);	
		//echo('</br>');
		}
	
		//print_r ($r);	
		echo('</br>');
		
		echo('eiendel_ID' . "................beskrivelse: ................ Oppbevares ................Har tilgang (personNr)................Har tilgang (Navn)</br>");
		foreach($eiendel as $e){
			$beskrivelse = beskrivelse($e['ID']);

			echo(	$e['ID'] . "................" . 
					$beskrivelse . "................" .
					$e['Sted_Adress'] . "................" . 
					$e['Navn'] . "................" .
					$e['Medlem_Person_personNR']."</br>");
		}
		
	?>
</body>
</html>