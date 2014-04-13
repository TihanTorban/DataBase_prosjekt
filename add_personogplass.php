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

		/* EIENDEL */
		$eiendel = array();
					
		$query = "SELECT ID FROM eiendel";
		
		$result = $db->query($query);
		
		$html = '';
		foreach($result as $key){
						$key2 = $key['ID'];
						$html .= "<option value='$key2'>$key2</options>";
		}

		echo"</br><h3><b> Legg inn nytt medlem og eier </b></h3>
			<form action='' method='post'>
                Person NR <input type='text' name='personNr' size='20'/>
				Navn .. <input type='text' name='navn' size='20'/> </br><br>
				Telefon .... <input type='text' name='telefon' size='20'/> 
				Epost .. <input type='text' name='epost' size='20'/>
				Addresse <input type='text' name='addresse' size='30'/> </br><br>
				Eier av eiendel nr. <select name='ownership' id='ownership'>
					<option selected value='ingen'> Ingen</option>
					$html
				</select><br><br>
				Medlem ... <select name='membership' id='membership'>
					<option selected value='ja'> Ja</option>
					<option value='nei'> Nei</option>
				</select><br><br>				
				<input type='submit' name='submission' value='Legg inn' /><br>
            </form>
		";
		
	echo'
		</br><h3><b> Legg inn ny plassering </b></h3>
			<form action="" method="post">
                Adresse ..... <input type="text" name="adresse" size="20"/><br><br>
				Beskrivelse <input type="text" name="plassering" size="20"/> </br><br>
				<input type="submit" name="submission2" value="Legg inn" /><br>
            </form>
	';
	
	//$ja = is_numeric('4.4');
	//$ja = is_int(4);
	//echo"$ja";
	
	if(isset($_POST['submission'])){

	echo '<br><h3>Resultat</h3><b>(Registrering av nytt medlem og eier)</b><br><br>';
	
	if(!empty($_POST['personNr']) && !empty($_POST['navn']) && !empty($_POST['telefon']) && !empty($_POST['epost']) && !empty($_POST['addresse'])){
		$personNr = $_POST['personNr'];
		$navn = $_POST['navn'];
		$telefon = $_POST['telefon'];
		$epost = $_POST['epost'];
		$addresse = $_POST['addresse'];
		$membership = $_POST['membership'];
		$ownership = $_POST['ownership'];
		
		if(!is_numeric($telefon) || !is_numeric($personNr)){
			echo '<i>Både PersonNR og Telefon må være tall!<i><br>';
			exit;
		}
		if(strpos($telefon,'.') || strpos($personNr,'.')){
			echo '<i>Både PersonNR og Telefon må være ett integer!<i><br>';
			exit;
		}
		
		if(strlen($telefon)>11 || strlen($personNr)>11){
			echo '<i>Både PersonNR og Telefon må være 11 siffer eller kortere!<i><br>';
			exit;
		}
		
		echo"Setter inn: Personnummer: $personNr, Navn: $navn, Telefonnr: $telefon, E-post: $epost, Addresse: $addresse<br>";
		$query2 = "INSERT INTO person(`personNR`, `Navn`, `Telefon`, `E-post`, `Adresse`) VALUES ($personNr, '$navn', $telefon, '$epost', '$addresse')";
		//echo"<br>$query2<br>";
		$result2 = $db->query($query2);

		if($ownership!='ingen'){
			echo"Registreres som eier av eiendel nr. $ownership<br>";
			$query5 = "INSERT INTO innlaant_fra(`Person_PersonNR`, `Eiendel_ID`) VALUES ($personNr, $ownership)";
			$result4 = $db->query($query5);
		}
		
		if($membership=='ja'){
			echo"Registreres som medlem i medlemsregister<br>";
			$query3 = "INSERT INTO medlem(`Person_personNR`) VALUES ($personNr)";
			$result3 = $db->query($query3);
		}
		else
		{
			echo"Registreres som ikke-medlem<br>";
			$query4 = "INSERT INTO `ikke_medlem`(`Person_personNR`) VALUES ($personNr)";
			$result4 = $db->query($query4);
		}
		
		echo '<i>Great success!<i><br>';
	}
	else
	{
	echo '<i>Du må legge inn verdier i alle kolonnene!<i><br>';
	}
	
	}
	
	if(isset($_POST['submission2'])){
	
	echo '<br><h3>Resultat</h3><b>(Registrering av ny plassering med beskrivelse)</b><br><br>';
	
		if(!empty($_POST['adresse']) && !empty($_POST['plassering'])){
			$addresse = $_POST['adresse'];
			$plassering = $_POST['plassering'];
		
			echo"Setter inn: Adresse: $addresse, Beskrivelse: $plassering<br>";
			$query5 = "INSERT INTO sted(`Adress`, `Beskrivelse`) VALUES ('$addresse', '$plassering')";
			$result5 = $db->query($query5);
		
			echo '<i>Great success!<i><br>';
		}
		else
		{
			echo '<i>Du må legge inn verdier i alle kolonnene!<i><br>';	
		}
	}
	
	?>
</body>
</html>