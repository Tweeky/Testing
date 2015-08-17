<?php
//******* Inloggen & sessies*******/
// Het hele sessie gedeelte moet voor alle html staan!
// start de sessie
	session_start();
	$sessionid = session_id();
	$_SESSION['login'];
//inloggen
//De waarden voor gebruikersnaam en wachtwoord, je kunt ze ook in de database zetten in een aparte tabel.
	$gebruikersnaam="admin";
	$wachtwoord="wachtwoord";
	$gn=$_POST['gn'];
	$ww=$_POST['ww'];
	if($gebruikersnaam == $gn && $wachtwoord == $ww){
	$_SESSION['login']=1;
	}else{ } 
//Als de sessie login 1 is dan ben je ingelogd en als de sessie login 0 is dan ben je niet ingelogd.
?>
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
//Als je niet ingelog bent het inlogscherm tonen.
	if ($_SESSION['login']=="0"){
?>
<form method="post" action="">
	<input type="name" name="gn"><br>
	<input type="name" name="ww">
	<input type="submit" value="Inloggen">
</form>
<?php

	}else{//als je wel bent ingelogd de pagina laten zien.
//********* De pagina's *********
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
	$query="select menu_item, tekst from inhoud where id='$id'";
	$resultaat = mysql_query($query);
	while($rij = mysql_fetch_array($resultaat))
	{
		$menu_item = $rij['menu_item'];
		$tekst = $rij['tekst'];
	};
//Formulier om de inhoud van de database aan te passen
?>
<form method="post" action="">
	Menu_item:<br>
	<input type="name" name="menu_item" value="<?php echo $menu_item; ?>">
	<br>Tekst<br>
	<textarea rows="6"  name="tekst">
		<?php echo $tekst; ?>
	</textarea>
	<br>
	<input type="submit" name="knop" value="Wijzig">
	<input type="submit" name="knop" value="Nieuw">
	<input type="submit" name="knop" value="Verwijder">
	<hr>
	<input type="submit" name="knop" value="Loguit">
</form>
<?php
//**** script om de acties uit het formulier uit te voeren: ******
//Het formulier uitlezen
	$menu_item=$_POST['menu_item']; echo $menu_item;
	$tekst=$_POST['tekst']; echo $tekst;
	$knop=$_POST['knop'];
//wijzigen van de inhoud van een pagina
	if ($knop == "Wijzig"){
	$sql_update="UPDATE inhoud SET menu_item='$menu_item',
	tekst='$tekst' WHERE id=$id;";
	echo $sql_update;
	$uitvoer = mysql_query ($sql_update) or die (mysql_error ());
	}
//Nieuwe pagina toevoegen
	if ($knop == "Nieuw"){
//maximale id waarde uit de database halen.
		$sql="SELECT max( id ) FROM inhoud ";
		$result=mysql_query($sql);
		$ja=mysql_fetch_array($result);
		$maxid=$ja[0];
//de nieuwe id wordt 1 hoger dan de maximale id.
		$id=$maxid + 1;
		$sql_insert="INSERT INTO inhoud (id, menu_item, tekst)
		VALUES ('$id', '$menu_item', '$tekst');";
		$uitvoer = mysql_query ($sql_insert) or die (mysql_error ());
	}
//Pagina verwijderen
	if ($knop == "Verwijder"){
		$sql_delete="DELETE FROM inhoud WHERE id=$id;";
		$uitvoer = mysql_query ($sql_delete) or die (mysql_error ());
	}
}//einde else van inloggen
//Uitloggen
	if($knop == "Loguit"){
		$_SESSION['login']=0;
	}
?>
</body>
</html>
