<?php 
require_once("includes/initialize.php");

$id_c=$_GET['id_c'];
$commande=CommandeFournisseur::find_by_id($id_c);
$commande->statut=3;
$commande->date_commande_recue=Date::timestamp_to_sql(time()*1000);
$commande->save();



$urlretour='reception.php';
redirect_to($urlretour);


?>
