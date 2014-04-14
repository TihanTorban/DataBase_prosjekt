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
		
		echo"</br><h3><b> Legg inn ny eiendel </b></h3>
			<form action='' method='post'>
                Anskaffelsesdato <input type='text' name='anskaffelsesdato' size='20'/>
				Verdi <input type='text' name='anskaffelsesdato' size='20'/>
				Beskrivelse <input type='text' name='anskaffelsesdato' size='20'/>
				Eier <input type='text' name='anskaffelsesdato' size='20'/>
				Oppbevaringssted <input type='text' name='verdi' size='20'/> </br><br>
				<input type='submit' name='submission' value='Legg inn' /><br>
            </form>
		";
		
		
	?>
</body>
</html>