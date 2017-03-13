<?php

	//inclure le header

	//formulaire de connexion

session_start();

require_once '../inc/connect.php';

$err = array();

	if(!empty($_POST)){
	foreach($_POST as $key => $value){
		$post[$key] = trim(strip_tags($value));
	}

	if(empty($post['ident'])){
	$err[] = 'Veuillez saisir votre identifiant';
}

	if(empty($post['passwd'])){
		$err[] = 'Veuillez saisir votre mot de passe';
	}

	if(count($err) > 0){		
        $formError = true;
    }else{
		$req = $bdd->prepare('SELECT * FROM users WHERE email = :login LIMIT 1');
		$req->bindValue(':login', $post['ident']);
		if($req->execute()){
		$user = $req->fetch();
			if(!empty($user)){
                if(password_verify($post['passwd'], $user['password'])){
					$_SESSION = array(
                        'userId'=> $user['userId'],
				        'nom' 	=> $user['lastname'],
						'prenom'=> $user['firstname'],
						'email' => $user['email'],
					);
                header('Location: user/add_recipe.php'); // On redirige vers la page de deconnexion
			    die();
				}		
            else { $errorLogin = true;}
			}
			else { $errorLogin = true; }
		}
	}

}
require_once '../inc/header.php'	

?>


	<?php 
		if(isset($formError)) {
			echo '<p class="error">'.implode('<br>', $err).'</p>';
		}
		if(isset($errorLogin)) {
			echo '<p class="error">Erreur d\'identifiant ou de mot de passe</p>';
		}

		if(isset($_SESSION['lastname']) && isset($_SESSION['firstname']) && isset($_SESSION['email'])){
			echo '<p class="success">Salut '.$_SESSION['firstame']. ' ' . $_SESSION['lastname'];
			echo '<br>Tu es déjà connecté :-)</p>';
		}
	?>

	<form method="POST">
		<label for="ident">Identifiant</label>
		<input type="email" id="ident" name="ident" placeholder="votre@email.fr">

		<br>
		<label for="passwd">Mot de passe</label>
		<input type="password" id="passwd" name="passwd" placeholder="Votre mot de passe">

		<br>
		<input type="submit" value="connexion">
		<input type="submit" value="deconnecter">
	</form>
	
<!--inclure le footer-->
	
</body>
</html>




