<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 TRANSITIONAL//EN">
<html>
	<head>
	<title></title>
	</head>
<body>
<?php
//******** Contact met de database ********
//De variabelen van database als je de database op de localhost hebt.
	$host="localhost"; //host van de database
	$database="cms"; // naam van de database
	$user="root"; //gebruikersnaam van de database
	$wachtwoord=""; // wachtwoord van de database
 // Hier maken we een verbinding met de server
	$connection = mysql_connect($host, $user, $wachtwoord)
	or die ("Kan geen verbinding met de server maken, omdat:" . mysql_error());
// Hier selecteren we de goede database  //En weer een foumelding als het niet lukt.
	$cms = mysql_select_db($database, $connection)  or die ("Kan de database niet selecteren.");
//********* De pagina's*********
//Het menu
	echo "<ul>";
	$query="select * from inhoud";
	$resultaat = mysql_query($query);
	while($rij = mysql_fetch_array($resultaat))
	{
		$id=$rij['id'];
		$menu_item=$rij['menu_item'];
		echo "<li><a href=\"?id=$id\">$menu_item</a></li>";
	};
	echo "</ul>";
//id van de pagina uit de url uitlezen, als er geen id nummer in de url staat dan de homepage weergeven.
	$id=(isset($_GET['id'])) ? $_GET['id'] : '0';
//Inhoud van de pagina uit de database ophalen
	$query="select tekst from inhoud where id='$id'";
	$resultaat = mysql_query($query);
	while($rij = mysql_fetch_array($resultaat))
	{
		$inhoud = $rij['tekst'];
		echo $rij['tekst'];
	};
?>
</body>
</html>
//Uitloggen if($knop == “Loguit”){ $_SESSION[‘login’]=0; }
