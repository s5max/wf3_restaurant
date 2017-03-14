<?php
	
	session_start();

	$title = 'Accueil Editeur';
    require_once '../../inc/connect.php';



	//inclure le header
	require_once '../../inc/header.php';
	
	//Connexion à la base de donnée


    if(!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] == false || $_SESSION['role'] != 'role_admin' && $_SESSION['role'] != 'role_editor'){
// Redirection vers la page de connexion si non connecté
header('Location: ../login.php');
die;
}

	

	
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