<?php
	
	session_start();

	$title = 'Accueil Editeur';


	//inclure le header
	require_once '../../inc/header.php';
	
	//Connexion à la base de donnée
	require_once '../../inc/connect.php';

	

/*	//Afficher les recettes de l'utilisateur
	if(isset($_GET['userId'])){

		$select = $bdd->prepare(SELECT * FROM recipes WHERE userId = :userId );

			$select->bindValue(':userId',$_GET['id']);

			$select->execute();

			$recipes = $select->fetchAll(PDO::FETCH_ASSOC);

	}
*/
?>
<!--
	<table>

		<tr>
			<th></th>
			<th></th>
			<th></th>
		</tr>
-->
<?php
	/*
	foreach($recipes as $value):



	endforeach;
	*/
?>

<!--
	</table>
-->

//Modifier le mot de passe

	<form action="#" method="post">

		<input type="password" name="password" id="password">
		<input type="submit" name="modifier" value="modifier le mot de passe">
		<input type="submit" name="newMdp" value="Générer un mot de passe">	

	</form>

<?php

		

	//inclure le footer

?>