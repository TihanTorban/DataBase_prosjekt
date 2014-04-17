<!DOCTYPE html>
<html>
<head>
	<title>Web Photo Gallery</title>
    <meta http-equiv="content-type" content="=text/html; charset=utf-8 without BOM"/>
	<link rel="shortcut icon" href="img/favicon.ico">
	<link rel="stylesheet" href="style.css">
	<style>table,th,td{border:1px solid black;border-collapse:collapse;}th,td{padding:5px;}</style>
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
		$query = "SELECT * FROM utlaant_til
						INNER JOIN eiendel ON eiendel.ID = utlaant_til.Eiendel_ID
						INNER JOIN person ON person.personNR = utlaant_til.Medlem_Person_PersonNR";
		$result = $db->query($query);

		foreach($result as $r){
			$eiendel[] = $r;
		}
		echo('</br>');
		
		//echo"<h3>Finn ut hvem som har lånt en bestemt eiendel. List opp navn og kontaktinformasjon</h3>";
		$html = '';
		foreach($eiendel as $key){
						$eId = $key['ID'];
						$html .= "<option value='$eId'>$eId</options>";
		}
		echo"
			<h3><b> Sjekk hvem som har lånt en bestemt eiendel </b></h3>
			<form action='' method='post'>
				Hvem som har lånt en bestemt eiendel 
				<select name='eiendel' id='eiendel'>
				<option selected value='id'> Eiendel nr</option>
					$html
				</select>?
				<input type='submit' name='submission' value='Sjekk' /><br>
            </form><br>
		";
		
		
		
		if(isset($_POST['submission'])){
			$resultTxt = "
			<table style='width:700px'>
				<tr>
					<th>Eiendel_Id</th>
					<th>Beskrivelse</th>
					<th>personNr</th>
					<th>Navn</th>
					<th>Telefon nr</th>
					<th>Adresse</th>
					<th>E-post</th>
				</tr>";
			foreach($eiendel as $e){ 	
					$id = $e['ID'];
					$beskrivelse = beskrivelse($e['ID']);
					$navn = $e['Navn'];
					$personnr = $e['Medlem_Person_PersonNR'];
					$telefon = $e['Telefon'];
					$adresse = $e['Adresse'];
					$epost = $e['E-post'];
					
					if(empty($adresse)){$adresse = 'Ukjent';}
					if(empty($navn)){$navn = 'Ukjent';}
					if(empty($personnr)){$personnr = 'Ukjent';}
					
				if($id==$_POST['eiendel']){
					$resultTxt .= "<tr>
									<td>$id</td>
									<td>$beskrivelse</td>
									<td>$personnr</td>
									<td>$navn</td>
									<td>$telefon</td>
									<td>$adresse</td>
									<td>$epost</td>
								</tr>";
				}
			
			}
			$resultTxt .= "</table>";
			echo($resultTxt);
		}
		
	?>
</body>
</html>