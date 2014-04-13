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
		$query = "SELECT * FROM innlaant_fra 
					INNER JOIN eiendel ON eiendel.ID = innlaant_fra.Eiendel_ID
					INNER JOIN person ON person.personNR = innlaant_fra.Person_PersonNR";
		$result = $db->query($query);
		// echo('<br/>');
		foreach($result as $r){
			$eiendel[] = $r;
		}
		
		echo('</br>');
		
		echo"<h3>Liste over eiendeler som organisasjonen har lånt med id, beskrivelse, eier og leveringsdato</h3>";
		
		$result = 
		"<head><style>table,th,td{border:1px solid black;border-collapse:collapse;}th,td{padding:5px;}</style></head>
		<table style='width:700px'><tr><th>Eiendel_Id</th><th>Beskrivelse</th><th>Eier (personNr)</th><th> Eier (Navn)</th><th>Leveringsdato</th></tr>";

		//echo('eiendel_ID' . "................beskrivelse: ................ eierNR ................eierNavn ................leveringsdato</br>");
		
		foreach($eiendel as $e){
			$id = $e['ID'];
			$beskrivelse = beskrivelse($e['ID']);
			$personnr = $e['personNR'];
			$navn = $e['Navn'];
			$utlaansp = $e['Utlaansperiode'];
			$utlaansd = $e['Utlaansdato'];
			if(!empty($utlaansp) && !empty($utlaansd)){$levDato = 'Leveres '.$utlaansp.' dager fra '.$utlaansd;} else{$levDato = 'Ukjent';}
		
		//	echo(	$e['ID'] . "................" . 
		//			$beskrivelse . "................" . 
		//			$e['personNR']. "................" .
		//			$e['Navn']. "................" .
		//			$levDato."</br>");
		
		$result .= "<tr><td>$id</td><td>$beskrivelse</td><td>$personnr</td><td>$navn</td><td>$levDato</td></tr>";
		
		}
		
		$result .= "</table>";
		echo($result);
		
	?>
</body>
</html>