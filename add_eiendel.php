<!DOCTYPE html>
<html>
<head>
	<title>Togsamleforeningen</title>
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
		
		$s = '&nbsp';
		$l = "$s$s$s";
		
		$dager ='';
		for($i=1;$i<32;$i++){
			$dager .= "<option value='$i'>$i</options>";
		}
		
		$m = array('Januar','Februar','Mars','April','Mai','Juni','Juli','August','September','Oktober','November','Desember');
		
		$maneder = '';
		foreach($m as $m2){
			$maneder .= "<option value='$m2'>$m2</options>";
		}

		$aar ='';
		for($i=1999;$i<2021;$i++){
			$aar .= "<option value='$i'>$i</options>";
		}
		
		$query = "SELECT Adress FROM sted";
		$result = $db->query($query);
		
		$steder = '';
		foreach($result as $key){
						$key2 = $key['Adress'];
						$steder .= "<option value='$key2'>$key2</options>";
		}
		
		$query = "SELECT Navn, personNR FROM person";
		$result = $db->query($query);
		
		$personer = '';
		foreach($result as $key){
						$key2 = $key['Navn'];
						$personer .= "<option value='$key2'>$key2</options>";
		}
		
		$query = "SELECT * FROM medlem
					INNER JOIN person ON person.personNR = medlem.Person_personNR";
		$result = $db->query($query);
		
		$medlemmer = '';
		foreach($result as $key){
						$key2 = $key['Navn'];
						$medlemmer .= "<option value='$key2'>$key2</options>";
		}
		
		
		echo"</br><h3><b> Legg inn ny eiendel </b></h3>
			<form action='' method='post'>
                Ansk. dato$s$s$s$s$s Dag <select name='a_dag' id='a_dag'>
					$dager
				</select>
				Måned <select name='a_mnd' id='a_mnd'>
					$maneder
				</select>
				År <select name='a_aar' id='a_aar'>
					$aar
				</select><br><br>				
				Verdi $l$l$l$l$l$l$s <input type='text' name='verdi' size='5'/>,- NOK <br><br>
				Kategori $l$l$l$l$s$s <select name='kategori' id='kategori'>
					<option value='tog'> Tog</option>
					<option value='skinner'> Skinner</option> 
					<option value='miniatyrer'> Miniatyrer</option>
				</select><br><br>
				Detaljer<br>
				$l Tog-Modell / Skinne-Type $s$s$s$s$s/ Miniatyr-Høyde $s$s$s<input type='text' name='detalj1' size='5'/><br>
				$l Tog-Årgang / Skinne-Lengde / Miniatyr-Lengde $s$s <input type='text' name='detalj2' size='5'/><br><br>
				Oppbevaringssted $s<select name='sted' id='sted'>
					<option value='ukjent'> Ukjent</option>
					$steder
				</select>
				$l$l <br><br>Innlånt fra medlem/ikke-medlem <select name='fra' id='fra'>
					<option selected value='nei'> nei</option>
					$personer
				</select>
				$l$l Utlånt til medlem <select name='til' id='til'>
					<option selected value='nei'> nei</option>
					$medlemmer
				</select><br><br>
				Lånedato $s$s$s$s$s$s Dag <select name='l_dag' id='l_dag'>
					$dager
				</select>
				Måned <select name='l_mnd' id='l_mnd'>
					$maneder
				</select>
				År <select name='l_aar' id='l_aar'>
					$aar
				</select><br><br>
				Lånevarighet $l$l$s$s<select name='varighet' id='varighet'>
					<option value='ingen'> Ingen</option>
					<option value='15'> 15 dager</option>
					<option value='30'> 30 dager</option>
					<option value='60'> 60 dager</option>
					<option value='180'> 120 dager</option>
				</select><br><br>
				<input type='submit' name='submission' value='Legg inn' /><br>
            </form>
		";
		
		
	?>
</body>
</html>