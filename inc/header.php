<?php

	require_once 'connect.php';

	//Requete sql from options

	$select = $bdd->prepare('SELECT * FROM options');
   if($select->execute()){
	$options = $select->fetch(PDO::FETCH_ASSOC); 
   }

?><!DOCTYPE html>
<html lang='fr'>

	<head>
	
		<meta charset="utf-8">
		
		<title><?=$title;?></title>
		 <!-- Pour Internet Explorer: s'assurer qu'il utilise la dernière version du moteur de rendu -->
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    
    <!-- Affichage sans zoom pour les mobiles -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!--Latest compiled and minified CSS // Bootstrap CSS-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
    <!-- hmtl5 shiv -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" integrity="sha256-3Jy/GbSLrg0o9y5Z5n1uw0qxZECH7C6OQpVBgNFYa0g=" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" type="text/css" href="<?= $css;?>">

	</head>

	<body>

<!--Barre de navigation-->		
	<nav>

		<header>

			<h1><?php echo $options['name'];?></h1>

			<address><?=$options['address'];?></address>

			<p><?=$options['tel'];?></p>

		</header>

<!--
		<ul>
			<li><a href="../contact.php">Nous contacter</a></li>
		</ul>
-->

	</nav>

