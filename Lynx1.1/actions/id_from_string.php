<?php

// PRODUIT 1
if (empty($_POST['recherche_nom1'])){
	
}
else {
	$_SESSION['produit1'] = (id_produit_par_nom_code($_POST['recherche_nom1']));
	}
	
	if (empty($_POST['recherche_nom2'])){
		}
	else {$_SESSION['produit2']=id_produit_par_nom_code($_POST['recherche_nom2']);}

		
	
	header('Location: espace_client.php');

?>