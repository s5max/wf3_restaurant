
<?php

	//inclure le header
    //Demande de confirmation

	//Demande de confirmation
session_start();

require_once '../inc/header.php';
	//inclure le footer
if(isset($_GET['logout']) && ($_GET['logout'] == 'yes')){
	unset($_SESSION['nom'], $_SESSION['prenom'], $_SESSION['email'], $_SESSION['userId']); 
	header('Location: login.php');
	die();
}


?>


<?php if(isset($_SESSION['prenom']) && isset($_SESSION['nom']) && isset($_SESSION['email']) && isset($_SESSION['userId'])): ?>
	<p style="text-align:center;">
		<?php echo $_SESSION['nom']; ?>, veux-tu te déconnecter ? Vraiment ?

		<br><br>

	
		<br><br>

		<a href="logout.php?logout=yes">Oui, je veux me déconnecter</a>
	</p>

<?php else: ?>
	<p style="text-align:center;">
		Tu es déjà déconnecté, tu n'existes pas !!

		<br><br>
		<img src="../assets/img/2376d801c93f9ba4cbc8788258abf247.gif" style="height:200px;border-radius:10px;">
	</p>
<?php endif; ?>
<!--inclure le footer-->


</body>
</html>	
	
?>