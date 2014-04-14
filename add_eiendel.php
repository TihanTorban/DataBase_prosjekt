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

		function getDato($dato, $mnd, $aar){
			$result = $aar.'-'.$mnd.'-'.$dato;
			if(($mnd<8 && ($mnd%2==0 && $dato>30)) ||($mnd>7 && ($mnd%2!=0 && $dato>30)) || ($mnd==2 && $dato>28)){
				return false;
			}
			return $result;
		}
		
		function checkValidInteger($tall){
			if(is_numeric($tall)){
				if(!strpos($tall,'.')){
					if(!strlen($tall)>11){
						return true;
					}
				}
			}
			else{
				return false;
				}
		}
		
		$s = '&nbsp';
		$l = "$s$s$s";
		
		$dager ='';
		for($i=1;$i<32;$i++){
			$dager .= "<option value='$i'>$i</options>";
		}
		
		$m = array('Januar','Februar','Mars','April','Mai','Juni','Juli','August','September','Oktober','November','Desember');
		
		$i = 1;
		$maneder = '';
		foreach($m as $m2){
			$maneder .= "<option value='$i'>$m2</options>";
			$i++;
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
					<option selected value='tog'> Tog</option>
					<option value='skinner'> Skinner</option> 
					<option value='miniatyrer'> Miniatyrer</option>
				</select><br><br>
				Detaljer<br>
				$l Tog-Modell / Skinne-Type $s$s$s$s$s/ Miniatyr-Høyde $s$s$s<input type='text' name='detalj1' size='5'/><br>
				$l Tog-Årgang / Skinne-Lengde / Miniatyr-Lengde $s$s <input type='text' name='detalj2' size='5'/><br><br>
				Oppbevaringssted $s<select name='sted' id='sted'>
					<option selected value='ukjent'> Ukjent</option>
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
					<option selected value='ingen'> Ingen</option>
					<option value='15'> 15 dager</option>
					<option value='30'> 30 dager</option>
					<option value='60'> 60 dager</option>
					<option value='180'> 120 dager</option>
				</select><br><br>
				<input type='submit' name='submission' value='Legg inn' /><br>
            </form>
		";
		
		if(isset($_POST['submission'])){
		
		if(!empty($_POST['a_dag']) && !empty($_POST['a_mnd']) && !empty($_POST['a_aar']) &&
		!empty($_POST['kategori']) && !empty($_POST['verdi']) && !empty($_POST['detalj1']) && !empty($_POST['detalj2'])){
		
//		&&		!empty($_POST['sted']) && !empty($_POST['fra'])&& !empty($_POST['til'])&& 
//		!empty($_POST['l_dag'])&& !empty($_POST['l_mnd'])&& !empty($_POST['l_aar'])&& !empty($_POST['varighet'])){	
		
//if(!empty($_POST['a_dag']) && !empty($_POST['a_mnd']) && !empty($_POST['a_aar'])){
			$f_a_dato = $_POST['a_dag'];
			$f_a_mnd = $_POST['a_mnd'];
			$f_a_aar = $_POST['a_aar'];
			$f_kategori = $_POST['kategori'];
			$f_verdi = $_POST['verdi'];
			$f_detalj1 = $_POST['detalj1'];
			$f_detalj2 = $_POST['detalj2'];
			$f_sted = $_POST['sted'];
			$f_fra = $_POST['fra'];
			$f_til = $_POST['til'];
			$f_l_dato = $_POST['l_dag'];
			$f_l_mnd = $_POST['l_mnd'];
			$f_l_aar = $_POST['l_aar'];
			$f_varighet = $_POST['varighet'];
			
			//echo"$f_a_dato $f_a_mnd $f_a_aar $f_kategori $f_verdi $f_detalj1 $f_detalj2 $f_sted $f_fra $f_til $f_l_dato $f_l_mnd $f_l_aar $f_varighet";
			
			$svar = getDato($f_a_dato, $f_a_mnd, $f_a_aar);
			$svar2 = getDato($f_l_dato, $f_l_mnd, $f_l_aar);
	
			if(!$svar || !$svar2){
				echo "<h2>Resultat</h2><i>Det er ikke så mange dager i den måneden!</i>";
				exit;
			}
			
			echo "<i>Great success!</i>";
		//	echo "$svar";
			
			$query1 = "INSERT INTO eiendel(Anskafelsesdato, Verdi) VALUES ('$svar', $f_verdi)";
			$result1 = $db->query($query1);
			
			if($f_kategori=='tog'){
				$d1 = 'Modell';
				$d2 = 'Aargang';
			}
			elseif($f_kategori=='skinner'){
				$d1 = 'Type';
				$d2 = 'Lengde';
			}
			elseif($f_kategori=='miniatyrer'){
				$d1 = 'Bredde';
				$d2 = 'Hoyde';
			}
			
			$query2 = "INSERT INTO $f_kategori(Eiendel_ID, $d1, $d2) VALUES(LAST_INSERT_ID(), '$f_detalj1', '$f_detalj2')";
			$result2 = $db->query($query2);
			
		}
		else{
		
		echo"<h3>Resultat</h3><i>Du må minst angi anskaffelsesdato, verdi, kategori og detaljer!<i>";
		
		}
		}
		
		
	?>
</body>
</html>