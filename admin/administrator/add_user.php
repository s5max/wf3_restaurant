<?php

	//inclure le header

	//traitement et vérification du formulaire

	//Formulaire d'ajout utilisateur

	//inclure le footer

require_once '../../inc/connect.php';

$errors = [];
$post = []; // Contiendra les données épurées <3 <3
$displayForm = true;
$title = 'Inscrire un utilisateur';

if(!empty($_POST)){

	// équivalent au foreach de nettoyage
	$post = array_map('trim', array_map('strip_tags', $_POST)); 

	

	if(strlen($post['firstname']) < 2 || strlen($post['firstname']) > 50){
		$errors[] = 'Le Prénom doit comporter entre 5 et 50 caractères';
	}

    if(strlen($post['lastname']) < 2 || strlen($post['lastname']) > 50){
		$errors[] = 'Le Nom doit comporter entre 5 et 50 caractères';
	}

    if(!preg_match('/^[\w\d]{8,20}$/', $post['password'])){
		$errors[] = "Le champ Password doit contenir entre 8 et 20 caractères";
	}
    
    $pattern  = "/^([^@\s<&>]+)@(?:([-a-z0-9]+)\.)+([a-z]{2,})$/iD";
    
     if(!preg_match($pattern, $post['email']))
    {
        $errors[] = "Le champ Email n'est vraiment pas conforme";
    }

    if(empty($post['role'])) {
		$errors[] = "Un rôle doit être attribué à l'utilisateur";
	}

	if(count($errors) === 0)
	{
		$insert = $bdd->prepare('INSERT INTO users (firstname, lastname, password, email, role) VALUES (:firstname, :lastname, :password, :email, :role)');
		$insert->bindValue(':firstname', $post['firstname']);
		$insert->bindValue(':lastname', $post['lastname']);
		$insert->bindValue(':password', password_hash($post['password'], PASSWORD_DEFAULT));
		$insert->bindValue(':email', $post['email']);
		$insert->bindValue(':role', $post['role']);
	

		if($insert->execute())
		{
			$success = 'Félicitations vous êtes inscrit';
            $displayForm = false;
		}
		else
		{
			var_dump($insert->errorInfo());
		}
	}
	else
	{
		$textErrors = implode('<br>', $errors);
	}

}
?>
<?php
require_once '../../inc/header.php';
?>

<?php
		if(isset($textErrors)){
           
			echo '<p style="color:red">'.$textErrors.'</p>';
		}

		if(isset($success)){
			echo '<p style="color:green">'.$success.'</p>';
		}
	?>
	
	<?php if($displayForm === true): ?>
    <fieldset>
	<form method="post">
	
		<label for="firstname">Prénom</label>
		<input type="text" name="firstname" id="firstname">

		<label for="lastname">Nom</label>
		<input type="text" name="lastname" id="lastname">

		<label for="email">Adresse email</label>
		<input type="text" name="email" id="email">
		
		<label for="password">Mot de passe</label>
		<input type="password" name="password" id="password">
		
		<label for="role">Rôle de l'utilisateur</label>    
            <select name="role">
            <option value="" selected="selected">--Sélectionnez--</option>
                <option value="role_editor">Editeur</option>
                <option value="role_admin">Administrateur</option>
                
            </select> 

		<input type="submit" value="Ajouter le membre">

	</form>
	</fieldset>
    <?php endif; ?>
	

<?php
require_once '../../inc/footer.php';
?>