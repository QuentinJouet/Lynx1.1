<?php require_once( "../includes/initialize.php"); ?>

 <?php 
 function genererjson(){
 	$tableau=array();
 	$clients = Client::find_all();

foreach($clients as $client){
	$tableau[]=array("<a href=detail_client.php?id_c=" . $client->id . ">" . $client->ref . "</a>",
							$client->nom_complet(),
							$client->ca(),
							$client->email,
							$client->nb_commandes());
	}
 
 return json_encode(array('aaData'=>$tableau));
 	
 	}
 	
echo genererjson(); 	
 	
 ?>
 
 
 