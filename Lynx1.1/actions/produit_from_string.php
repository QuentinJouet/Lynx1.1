<?php
require_once("../ressources/session.php");
require_once("../ressources/fonctions.php");
confirm_logged_in();
require_once("../ressources/connection.php");
// PRODUIT 1
if (empty($_POST['recherche_nom1'])){	

}
else {
	
	$_SESSION['produit1'] = (produit_par_nom_code($_POST['recherche_nom1']));
	echo 'recherche produit 1';
	}	
	if (empty($_POST['recherche_nom2'])){
		}
	else {$_SESSION['produit2']=produit_par_nom_code($_POST['recherche_nom2']);}			

header("Location: ../comparatif.php");
exit;
?>