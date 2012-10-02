<?php
require_once( "../includes/initialize.php"); 
$fav=$_POST['favoris'];
$url=$_POST['url'];
$id=$_POST['id_p'];

if ($fav==0) {
Favori::supprimer_favori($id);
}
if($fav==1) {
Favori::ajouter_favori($id);	
}

redirect_to(URL_SITE.$url);
exit;


?>