<?php
require_once( "../includes/initialize.php");

if (empty($_POST)){
	redirect_to(URL_THELIA);
}

$mail = PrevenirClient::envoyer_mail($_POST['produit']);

$_SESSION['message']="Les mails ont été envoyés avec succès.";
redirect_to('../produits_attendus.php');

?>