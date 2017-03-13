<?php

//pour la validation du téléphone
if(!preg_match('/^[0-9]{10}$/', $post['tel'])){
		$errors[] = "Le numéro de téléphone doit contenir obligatoirement 10 chiffres
        ";
	}

//pour la validation de l'email
 $pattern  = "/^([^@\s<&>]+)@(?:([-a-z0-9]+)\.)+([a-z]{2,})$/iD";
    
     if(!preg_match($pattern, $post['email']))
    {
        $errors[] = "Le champ Email n'est vraiment pas conforme";
    }