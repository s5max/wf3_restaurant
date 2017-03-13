<?php

	//inclure le header

	//Marquer les messages comme étant lu ou non

	//inclure le footer

session_start(); // Permet de démarrer la session
require_once '../../inc/connect.php';



if(!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] == false || $_SESSION['role'] != 'role_admin'){
// Redirection vers la page de connexion si non connecté
header('Location: ../login.php');
die;
}


$errors = [];
$post = []; // Contiendra les données épurées <3 <3
$title = 'Liste des messages';
$displayformlist=true;
$displayformsearch=true;
$donnees= [];

// On selectionne les toutes les colonnes de la table users
$select = $bdd->prepare('SELECT * FROM contact_user ORDER BY id DESC');
if($select->execute()){
	$users = $select->fetchAll(PDO::FETCH_ASSOC);
}
else {
	// Erreur de développement
	var_dump($select->errorInfo());
	die; // alias de exit(); => die('Hello world');
}

?>
<?php
require_once '../../inc/header.php';
?>

	<h1>Liste des messages de contact</h1>
    
    <br>
	<table>
		<thead>
			<tr>
                <th>Vue</th>
                <th>Objet</th>
                <th>Email</th>
                <th>Lire le message</th>
			</tr>
		</thead>

		<tbody>
			<!-- foreach permettant d'avoir une ligne <tr> par ligne SQL -->
			<?php foreach($users as $user): ?>
			    <tr>
			        <td><?php 
                        if ($user['checked']==false){
                            echo 'Non lu';
                        } else{
                            echo 'Lu';
                        } ?></td>
					<td><?=$user['object'] ?></td>
					<td><?=$user['email'] ?></td>
					<td>
						<!-- view_menu.php?id=6 -->
						<a href="view_message.php?id=<?=$user['id']; ?>">voir</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
    <?php if ($users==[]){
        echo 'Il n\'y a pas de résultat';
    }
     ; ?>
    
   <?php
require_once '../../inc/footer.php';
?>