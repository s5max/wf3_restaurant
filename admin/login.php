<?php 

session_start();

$title = 'Connexion utilisateur';

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
	}
	else {
		$req = $bdd->prepare('SELECT * FROM users WHERE email = :login LIMIT 1');
		$req->bindValue(':login', $post['ident']);
		if($req->execute()){
			$user = $req->fetch();
			if(!empty($user)){

				if(password_verify($post['passwd'], $user['password'])){
					$_SESSION = array(
						'nom' 	=> $user['lastname'],
						'prenom'=> $user['firstname'],
						'email' => $user['email'],
						'role'	=> $user['role']
					);
				//var_dump($_SESSION);
                header('Location: ../home_page.php');
                }
				else {
					$errorLogin = true;

					$forget = true;

					$_SESSION = array(
						
						'email' => $user['email'],
						'token' => md5($user['email'])
					);

				}
			}
			else {
				$errorLogin = true;
			}
		}
	}

}
?>
<?php
require_once '../inc/header.php'; 
?>

	<?php 
		if(isset($formError) && $formError){
			echo '<p class="error">'.implode('<br>', $err).'</p>';
		}
		if(isset($errorLogin) && $errorLogin){
			echo '<p class="error">Erreur d\'identifiant ou de mot de passe</p>';
		}

		if(isset($errorLogin) && isset($forget)){

			echo'<a href="">J\'ai oublié mon mot de passe!</a>';

		}

		if(isset($_SESSION['nom']) && isset($_SESSION['prenom']) && isset($_SESSION['email'])){
			echo '<p class="success">Salut '.$_SESSION['prenom']. ' ' . $_SESSION['nom'];
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
		<input type="submit" value="Se connecter">
	</form>
</body>
</html>



