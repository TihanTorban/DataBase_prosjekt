<!DOCTYPE html>
<html>
<head>
	<title>Togsamleforeningen</title>
    <meta http-equiv="content-type" content="=text/html; charset=utf-8 without BOM"/>
	<link rel="shortcut icon" href="img/favicon.ico">
	<link rel="stylesheet" href="style.css">
	<script language="javascript" type="text/javascript" src="datetimepick/datetimepicker.js">
		//Date Time Picker script- by TengYong Ng of http://www.rainforestnet.com
		//Script featured on JavaScript Kit (http://www.javascriptkit.com)
		//For this script, visit http://www.javascriptkit.com 
	</script>
</head>
<!-------------------------------------------------------------------------------------->
<body>
	<script type="text/javascript">
		function checkDag(moned){
			var moneds31 = ['1','3','5','7','8','10','12'];
			if (moneds31.indexOf(moned) == -1){
				if (moned == '2'){
					document.getElementById('dag31').style.visibility="hidden";
					document.getElementById('dag30').style.visibility="hidden";
					document.getElementById('dag29').style.visibility="hidden";
				}else{
					document.getElementById('dag31').style.visibility="hidden";
				}
			}else{
				document.getElementById('dag31').style.visibility="visible";
				document.getElementById('dag30').style.visibility="visible";
				document.getElementById('dag29').style.visibility="visible";
			}
		}
		
		// document.getElementById('a_dag').selectedIndex='10';
		
		function checkKategory(kategory){
			var s = '&nbsp';
			var ele1 = document.getElementById('besk1');
			var ele2 = document.getElementById('besk2');
			switch (kategory)
			{
			case 'tog':
				ele1.innerHTML = 'Tog-Modell';
				ele2.innerHTML = 'Tog-Årgang';
				break;
			case 'skinner':
				ele1.innerHTML = 'Skinne-Type'+s+s+s;
				ele2.innerHTML = 'Skinne-Lengde';
				break;
			case 'miniatyrer':
				ele1.innerHTML = 'Miniatyr-Høyde'+s;
				ele2.innerHTML = 'Miniatyr-Lengde';
				break;
			}
		}
		
		function checkLaan(id, value){
			if (id == 'fra'){
				document.getElementById('til').selectedIndex='0';
				if (value != 'nei'){
					document.getElementById('LaanD').style.display="list-item";
				}else if(document.getElementById('fra').value=='nei'){
					document.getElementById('LaanD').style.display="none";
					document.getElementById('laaneDato').value='';
					document.getElementById('varighet').selectedIndex='0';
				}
			}
			if (id == 'til'){
				document.getElementById('fra').selectedIndex='0';
				if (value != 'nei'){
					document.getElementById('LaanD').style.display="list-item";
				}else if(document.getElementById('til').value=='nei'){
					document.getElementById('LaanD').style.display="none";
					document.getElementById('laaneDato').value='';
					document.getElementById('varighet').selectedIndex='0';
				}
			}
		}
	</script>
	<a href="index.html">Oppgaver</a>
	<?php
		include_once("mysql.php");
		db_connnect();

		function getDato($dato){
			$pieces = explode("-", $dato);
			return $pieces[2].'-'.$pieces[1].'-'.$pieces[0];
		}
		
		function checkValidInteger($tall){
			if(is_numeric($tall)){
				if(!strpos($tall,'.')){
					if(!strlen($tall)<12){
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
				$dager .= "<option value='$i' id='dag$i'>$i</options>";
			}
		
		$m = array('Januar','Februar','Mars','April','Mai','Juni','Juli','August','September','Oktober','November','Desember');
		
		$maneder = '';
			$i = 1;
			foreach($m as $m2){
				$maneder .= "<option value='$i'>$m2</options>";
				$i++;
			}

		$aar ='';
			for($i=1999;$i<2021;$i++){
				$aar .= "<option value='$i'>$i</options>";
			}
		
		$steder = '';
			$query = "SELECT Adress FROM sted";
			$result = $db->query($query);
			foreach($result as $key){
							$key2 = $key['Adress'];
							$steder .= "<option value='$key2'>$key2</options>";
			}
		
		$personer = '';
			$query = "SELECT Navn, personNR FROM person";
			$result = $db->query($query);
			foreach($result as $key){
					$key2 = $key['Navn'];
					$key3 = $key['personNR'];
					$personer .= "<option value='$key3'>$key2</options>";
			}
		
		$medlemmer = '';
			$query = "SELECT * FROM medlem
							INNER JOIN person ON person.personNR = medlem.Person_personNR";
			$result = $db->query($query);
			foreach($result as $key){
				$key2 = $key['Navn'];
				$key3 = $key['personNR'];
				$medlemmer .= "<option value='$key3'>$key2</options>";
			}
		
		echo"</br><h3><b> Legg inn ny eiendel </b></h3>
			<form action='' method='post'>
                Ansk. dato$s$s$s$s$s <input id='dato' name='dato' type='text' size='11' value='dd-mm-yyyy'>
					<a href=\"javascript:NewCal('dato','ddmmyyyy')\">
						<img src='datetimepick/cal.gif' width='16' height='16' border='0' alt='Pick a date'>
					</a><br><br>				
				Verdi $l$l$l$l$l$l$s <input type='text' name='verdi' size='5'/>,- NOK <br><br>

				Kategori $l$l$l$l$s$s <select name='kategori' id='kategori' onChange=\"checkKategory(this.value)\">
					<option selected value='tog'> Tog</option>
					<option value='skinner'> Skinner</option> 
					<option value='miniatyrer'> Miniatyrer</option>
				</select><br><br>
				
				Detaljer<br>
				<span id='besk1' style='position:relative;left:20px;'>Tog-Modell</span> 
					<input type='text' name='detalj1' size='10' style='position:relative;left:20px;'/><br>
				<span id='besk2' style='position:relative;left:20px;'>Tog-Årgang</span> 
					<input type='text' name='detalj2' size='10' style='position:relative;left:20px;'/><br><br>
					
				Oppbevaringssted $s
				<select name='sted' id='sted'>
					<option value='ukjent'> Ukjent</option>
					$steder
				</select>
				$l$l <br><br>Innlånt fra medlem/ikke-medlem 
					<select name='fra' id='fra' onChange=\"checkLaan(this.id, this.value)\">
						<option selected value='nei'> nei</option>
						$personer
					</select>
				$l$l Utlånt til medlem 
					<select name='til' id='til' onChange=\"checkLaan(this.id, this.value)\">
						<option selected value='nei'> nei</option>
						$medlemmer
					</select><br><br>
				<span id='LaanD' style='display:none;'>
					Lånedato $s$s$s$s$s$s 
						<input id='laaneDato' name='laaneDato' type='text' size='11' value='dd-mm-yyyy'>
						<a href=\"javascript:NewCal('laaneDato','ddmmyyyy')\">
							<img src='datetimepick/cal.gif' width='16' height='16' border='0' alt='Pick a date'>
						</a><br><br>
					Lånevarighet $l$l$s$s<select name='varighet' id='varighet'>
						<option value='ingen'> Ingen</option>
						<option value='15'> 15 dager</option>
						<option value='30'> 30 dager</option>
						<option value='60'> 60 dager</option>
						<option value='180'> 120 dager</option>
					</select><br><br>
				</span>
				<input type='submit' name='submission' value='Legg inn' /><br>
            </form>
		";
	
		if(isset($_POST['submission'])){
		
			if(!empty($_POST['dato']) && !empty($_POST['kategori']) && !empty($_POST['verdi'])
				&& !empty($_POST['detalj1']) && !empty($_POST['detalj2'])){
			
	//		&&		!empty($_POST['sted']) && !empty($_POST['fra'])&& !empty($_POST['til'])&& 
	//		!empty($_POST['l_dag'])&& !empty($_POST['l_mnd'])&& !empty($_POST['l_aar'])&& !empty($_POST['varighet'])){	
			
	//if(!empty($_POST['a_dag']) && !empty($_POST['a_mnd']) && !empty($_POST['a_aar'])){

				$dato = $_POST['dato'];
				
				$f_kategori = $_POST['kategori'];
				$f_verdi = $_POST['verdi'];
				$f_detalj1 = $_POST['detalj1'];
				$f_detalj2 = $_POST['detalj2'];
				$f_sted = $_POST['sted'];
				$f_fra = $_POST['fra'];
				$f_til = $_POST['til'];
				
				$laaneDato = $_POST['laaneDato'];
				
				$f_varighet = $_POST['varighet'];

				//echo"$f_a_dato $f_a_mnd $f_a_aar $f_kategori $f_verdi $f_detalj1 $f_detalj2 $f_sted $f_fra $f_til $f_l_dato $f_l_mnd $f_l_aar $f_varighet";
				
				$svar = getDato($dato);
				$svar2 = getDato($laaneDato);
		
				if(!$svar || !$svar2){
					echo "<h2>Resultat</h2><i>Det er ikke så mange dager i den måneden!</i>";
					exit;
				}

				if(!(checkValidInteger($f_verdi))){
					echo "<h2>Resultat</h2><i>Verdi må oppgis som et heltall!</i>";
					exit;
				}

				if(($f_kategori == 'miniatyrer') && !(checkValidInteger($f_detalj1) && checkValidInteger($f_detalj2))){
					echo "<h2>Resultat</h2><i>Detaljer må oppgis som heltall for miniatyrer!</i>";
					exit;
				}

				if($f_fra!='nei' && $f_til!='nei'){
					echo "<h2>Resultat</h2><i>Eiendel kan ikke både være innlånt og utlånt samtidig!</i>";
					exit;
				}

				echo "<h2>Resultat</h2>";

			//	echo "$svar";

				$query1 = "INSERT INTO eiendel(Anskafelsesdato, Verdi) VALUES ('$svar', $f_verdi)";
				$result1 = $db->query($query1);

				echo"Registerer eiendel anskaffet dato: $svar, med verdi: $f_verdi,- NOK <br>";

				if($f_kategori=='tog'){
					$d1 = 'Modell';
					$d2 = 'Aargang';
					$f_detalj1 = "'$f_detalj1'";
					$f_detalj2 = "'$f_detalj2'";
				}
				elseif($f_kategori=='skinner'){
					$d1 = 'Type';
					$d2 = 'Lengde';
					$f_detalj1 = "'$f_detalj1'";
					$f_detalj2 = "'$f_detalj2'";
				}
				elseif($f_kategori=='miniatyrer'){
					$d1 = 'Bredde';
					$d2 = 'Hoyde';
				}

				//echo"$f_detalj1";
				//echo"$f_detalj2";
				$query2 = "INSERT INTO $f_kategori(Eiendel_ID, $d1, $d2) VALUES(LAST_INSERT_ID(), $f_detalj1, $f_detalj2)";
				$result2 = $db->query($query2);

				echo"Registert eiendel tilhører kategori: $f_kategori, med detaljer: $f_detalj1. $f_detalj2. <br>";

				$query3 = "INSERT INTO oppbevares(Eiendel_ID, Sted_Adress) VALUES(LAST_INSERT_ID(), '$f_sted')";
				$result3 = $db->query($query3);
				//echo($f_sted);

				echo"Registert eiendel oppbevares på $f_sted <br>";

				if($f_fra!='nei'){
					$query4 = "INSERT INTO innlaant_fra(Person_PersonNR, Eiendel_ID, Utlaansdato, Utlaansperiode) VALUES($f_fra, LAST_INSERT_ID(), '$svar2', $f_varighet)";
					$result4 = $db->query($query4);
					echo"Registert eiendel er innlånt fra $f_fra, fra gjeldende dato $svar2 i $f_varighet dager <br>";
				}

				if($f_til!='nei'){
					$query5 = "INSERT INTO utlaant_til(Medlem_Person_PersonNR, Eiendel_ID, Utlaansdato, Utlaansperiode) VALUES($f_til, LAST_INSERT_ID(), '$svar2', $f_varighet)";
					$result5 = $db->query($query5);
					echo"Registert eiendel er utlånt til $f_til, fra gjeldende dato $svar2 i $f_varighet dager <br>";
				}

				echo "<i>Great success!</i>";
			}else{
				echo "<h2>Resultat</h2>";
				echo "<i>Du må minst oppgi anskaffelsdato, verdi, kategori og detaljer!</i>";
			}
		}
		
	?>
</body>
</html>