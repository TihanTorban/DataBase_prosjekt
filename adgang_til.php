<!DOCTYPE html>
<html>
<head>
	<title>Togsamlerforeningen</title>
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
//		$query = "SELECT * FROM oppbevares 
//					INNER JOIN eiendel ON eiendel.ID = oppbevares.Eiendel_ID
//					INNER JOIN har_tilgang ON har_tilgang.Sted_Adress = oppbevares.Sted_Adress
//					INNER JOIN person ON person.PersonNR = har_tilgang.Medlem_Person_personNR";

		$query = "SELECT * FROM eiendel 
					LEFT OUTER JOIN oppbevares ON oppbevares.Eiendel_ID = eiendel.ID
					LEFT OUTER JOIN sted ON sted.Adress = oppbevares.Sted_Adress
					LEFT OUTER JOIN har_tilgang ON har_tilgang.Sted_Adress = oppbevares.Sted_Adress
					LEFT OUTER JOIN person ON person.PersonNR = har_tilgang.Medlem_Person_personNR
					GROUP BY ID";


		$result = $db->query($query);
		
		foreach($result as $r){
			$eiendel[] = $r;
		}
		
		$html = '';
		$lastkey = '';
		
		foreach($result as $key){
						$key2 = $key['ID'];
						if($key2!=$lastkey){
							$html .= "<option value='$key2'>$key2</options>";
						}
						$lastkey = $key2;
		}
		
		echo"</br><h3><b> Sjekk hvem som har tilgang til en bestemt eiendel </b></h3>
			<form action='' method='post'>
				Hvem har tilgang til eiendel nr. 
				<select name='eiendel' id='eiendel'>
				<option selected value='id'> Eiendel nr</option>
				$html
				</select>?
				<input type='submit' name='submission' value='Sjekk' /><br>
            </form>
		";

			
		echo'<br>';
		
		$result = 
		"<head><style>table,th,td{border:1px solid black;border-collapse:collapse;}th,td{padding:5px;}</style></head>
		<table style='width:800px'><tr><th>Eiendel ID</th><th>Beskrivelse</th><th>Oppbevares</th><th>Stedsbeskrivelse</th><th>Har tilgang (personNr)</th><th>Har tilgang (Navn)</th></tr>";
	
		if(isset($_POST['submission'])){
		
			foreach($eiendel as $e){
		
					$id = $e['ID'];
					$beskrivelse = beskrivelse($e['ID']);;
					$adresse = $e['Sted_Adress'];
					$addb = $e['Beskrivelse'];
					$navn = $e['Navn'];
					$personnr = $e['Medlem_Person_personNR'];
					
					if(empty($adresse)){$adresse = 'Ukjent';}
					if(empty($navn)){$navn = 'Ukjent';}
					if(empty($personnr)){$personnr = 'Ukjent';}
					
				if($id==$_POST['eiendel']){
					$result .= "<tr><td>$id</td><td>$beskrivelse</td><td>$adresse</td><td>$addb</td><td>$personnr</td><td>$navn</td></tr>";
				}
			
			}
		
		$result .= "</table>";
		echo($result);
		
		}
		
	?>
</body>
</html>