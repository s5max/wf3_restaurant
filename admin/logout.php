@@ -1,9 +1,44 @@
<?php

	//inclure le header
    //Demande de confirmation

	//Demande de confirmation
session_start();

	//inclure le footer
if(isset($_GET['logout']) && ($_GET['logout'] == 'yes')){
	unset($_SESSION['nom'], $_SESSION['prenom'], $_SESSION['email']); 
	header('Location: index.php');
	die();
}

require_once '../inc/header.php'
?>


<?php if(isset($_SESSION['firstname']) && isset($_SESSION['lastname']) && isset($_SESSION['email'])): ?>
	<p style="text-align:center;">
		<?php echo $_SESSION['lastname']; ?>, veux-tu te déconnecter ? Vraiment ?

		<br><br>
		<img src="../assets/img/2376d801c93f9ba4cbc8788258abf247.gif" style="height:200px;border-radius:10px;">
	
		<br><br>

		<a href="<?=$title;?>">Oui, je veux me déconnecter</a>
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
\ No newline at end of file