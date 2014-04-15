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
				}
			}
			if (id == 'til'){
				document.getElementById('fra').selectedIndex='0';
				if (value != 'nei'){
					document.getElementById('LaanD').style.display="list-item";
				}else if(document.getElementById('til').value=='nei'){
					document.getElementById('LaanD').style.display="none";
				}
			}
		}
	</script>
	<a href="index.html">Oppgaver</a>
	<?php
		include_once("mysql.php");
		db_connnect();
		
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
							$personer .= "<option value='$key2'>$key2</options>";
			}
		
		$medlemmer = '';
			$query = "SELECT * FROM medlem
							INNER JOIN person ON person.personNR = medlem.Person_personNR";
			$result = $db->query($query);
			foreach($result as $key){
							$key2 = $key['Navn'];
							$medlemmer .= "<option value='$key2'>$key2</options>";
			}
		
		
		echo"</br><h3><b> Legg inn ny eiendel </b></h3>
			<form action='' method='post'>
                Ansk. dato$s$s$s$s$s <input id='dato' type='text' size='11' value='dd-mm-yyyy'>
					<a href=\"javascript:NewCal('dato','ddmmyyyy')\">
						<img src='datetimepick/cal.gif' width='16' height='16' border='0' alt='Pick a date'>
					</a><br><br>				
				Verdi $l$l$l$l$l$l$s <input type='text' name='verdi' size='5'/>,- NOK <br><br>
				Kategori $l$l$l$l$s$s <select name='kategori' id='kategori' onChange=\"checkKategory(this.value)\">
					<option value='tog'> Tog</option>
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
						<input id='laaneDato' type='text' size='11' value='dd-mm-yyyy'>
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
	?>
</body>
</html>