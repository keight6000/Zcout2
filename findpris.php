<!DOCTYPE html>
<html>
<head>

	<meta charset="UTF-8"> <!-- Vi bruger Unicode Transformation Format 8-bit som supplere nordikse bogstaver mm. -->
	
		<title>Zcout</title>
		
	<link href="Stylesheet.css" rel="stylesheet" type="text/css"> <!-- Forbinder til stylesheet -->
	<link rel="shortcut icon" href="ecube.ico">
	<script type="text/javascript" src="skout.js"></script>

	<link href="https://fonts.googleapis.com/css?family=Squada+One" rel="stylesheet"> <!-- Loader font til title -->
	
	
</head>
<body>

	<div id="head"> <span style="cursor:default"> <!-- Gør så man ikke får skrive-markør når musen er over titlen -->
		<div id="title">
			<h1>Zcout</h1>
		</div>
	</div>	</span>
	
	<div id="nav">
	
			<!-- ========== Buttons ========== -->
	<div class="b1"><a href="index.html" class="button"><div class=botfix>Forside</div></a></div>
	
	<div class="b1"><a class="onbutton"><div class=botfix>Søgning</div></a></div>
	
	<div class="b1"><a class="button"><div class=botfix></div></a></div>
	
	<div class="box"> <!-- Søgefelt - Kode fået fra w3schools.com -->
		<div class="searchfield">
			<span class="icon"><i class="fa fa-search"></i></span>
			<form action="./findpris.php" method="get">
			  <input type="text" name="game" placeholder="Search game...">
			  <!-- <input type="submit" value="Submit"> Submit knappen fandt vi ikke nødvendig -->
			</form>
		</div>
	</div>

	</div>
	
	
			<!-- ========== Indhold ========== -->
	<div id="content">
	
	<div id="sidebanner"> <!-- Sidebanner, men bruger den ikke til noget pt. -->
	
		<div class="boxx">
		
		<div class="header">Populære søgninger:</div> <!-- Boksen med spil og links til dem -->
		
		<br><br>
			<ul>
				<li><a href="findpris.php?game=dark+souls+prepare+to+die+edition">Dark Souls</a></li>
					
				<li><a href="findpris.php?game=dishonored">Dishonored</a></li>
					
				<li><a href="findpris.php?game=tom+clancys+rainbow+six+siege">Rainbow 6 Siege</a></li>
					
				<li><a href="findpris.php?game=elex">Elex</a></li>
			</ul>
			
			<div class="header">Andre spillesider:</div>
			
		<br><br>
			<ul>
				<li><a href="https://www.humblebundle.com/" target="blank">Humble Bundle</a></li>
					
				<li><a href="https://www.fanatical.com/en/" target="blank">Fanatical</a></li>
					
				<li><a href="https://www.g2a.com/" target="blank">G2A</a></li>
					
				<li><a href="https://www.kinguin.net/" target="blank">Kinguin</a></li>
			</ul>
				<center><font color="white">(Disse sider søger vi pt. ikke på.)</font><center>
		</div>
	
	</div>
	
		<div id="text">	<span style="cursor:default"> <!-- Gør så man ikke får skrive-markør når musen er over titlen -->
	<br>		
			<font face="Squada One" size="20px">Her er de spil vi fandt</font>
	<br>	
			
	<br>
		<div class="boxx">
		<?php 	//Starter php til indsamling af pris-data fra nedestående hjemmesider
				//Følgene kode er fået fra Bikash Guragai på YouTube og Gustav Falkenthros <===

		require("simple_html_dom.php"); //Indlæser en HTML DOM parser skrevet i PHP5+ som lader en
										//manepulere HTML på en meget nem måde (Lavet af S.C. Chen)

		$spil = $_GET["game"]; //Sætter variablen $spil lig med "game" som bliver difineret i søgefeltet
		
		echo '<div class="header">' . $spil . "</div>" . "<br>"; //Skriver i toppen af boksen spillet du har søgt
		
	//GreenManGaming	==============================================================
		$spil = str_replace(" ", "-", $spil); //Ændre mellemrum til bindestreg i din søgning

		$ch = curl_init(); //Starter en cURL session

		//Angiver en mulighed for en cURL-overførsel 
		curl_setopt($ch, CURLOPT_URL, "https://www.greenmangaming.com/games/$spil");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($ch); //Sætter variablen $result til koden indsamlet i de overstående linjer kode

		$html = str_get_html($result); 	//Sætter variablen $html til funktionen "str_get_html" fået fra "simple_html_dom"
										//Funktionen lader en få HTML dom fra en string
										
		$ret = $html->find("price");	//Sætter variablen $html til funktionen "find" fået fra "simple_html_dom"

		echo "<br><a href='https://www.greenmangaming.com/games/$spil' target='blank'> 
		GreenManGaming</a><br>"; //Skriver "GreenManGaming" med link til deres hjemmeside
		
		if(isset($ret[0])){ //Skriver prisen (hvis en er fundet) eller "Pris ikke fundet" hvis intet er fundet (NULL)
			echo $ret[0] . "<br><br>";
		}else{
			echo "Pris Ikke Fundet <br><br>";
		}
		curl_close($ch); //Stopper cURL session

					//SAMME FOREGÅR FOR "STEAM" og "FANBOY"

	//Steam		======================================================================
		$spil = str_replace(" ", "%20", $spil);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "http://store.steampowered.com/search/?term=$spil");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($ch);

		$html = str_get_html($result);

		$ret = $html->find('div[class="col search_price  responsive_secondrow"]');

		echo "<a href='http://store.steampowered.com/search/?term=$spil' target='blank'>
		Steam</a><br>";
		
		if(isset($ret[0])){
			echo $ret[0] . "<br>";
		}else{
			echo "Pris Ikke Fundet <br><br>";
		}
		curl_close($ch);

	//Fanboy	======================================================================
		$spil = str_replace(" ", "-", $spil);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://fanboy.dk/produkt/$spil");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($ch);

		$html = str_get_html($result);

		$ret = $html->find('span[class="price"]');

		echo "<a href='https://fanboy.dk/produkt/$spil' target='blank'>
		Fanboy</a><br>";
		
		if(isset($ret[0])){
			echo $ret[0] . "kr.";
		}else{
			echo "Pris Ikke Fundet";
		}
		curl_close($ch);

		?> <!-- Afslutter php -->

	<br>
	 
		</div>
	<br>
	
	<div class="box"> <!-- Søgefelt - Kode fået fra w3schools.com-->
			<center>
		<div class="searchfield2">
			<form action="./findpris.php" method="get">
			  <input type="text" name="game" placeholder="Søg spil...">
			  <!-- <input type="submit" value="Submit"> Submit knappen fandt vi ikke nødvendig -->
			</form>
		</div>
			</center>
	</div>
	
	<br>
	</div></div>	</span>
	
	<div id="footer">	<span style="cursor:default"> <!-- Sidefod med kontakt oplysninger -->
	<br>
		Slotshaven Gymnasium, 4300 Holbæk. Tlf: 11 61 11 eller 70 20 12 01 - E-Mail: kralle1000@gmail.com
	</div> 				</span>
	
	
	
</body>
</html>