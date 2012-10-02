<?php
require_once('/var/www/vhosts/anotherwayin.fr/sitesweb/client/1.1/includes/initialize.php');


//ON ENVOIE LES MAILS d'ALERTE DE STOCKS



function tableau_html_from_produits_pour_mail($produits){
	$tableau='<table>
	<thead>
		<tr>
		<th>Ref</th><th>Produit</th><th>StockWeb</th><th>Stockcible</th><th>Voir dans Thelia</th>
		</tr>
	</thead>
	<tbody>';
	
	foreach($produits as $produit){
	$tableau.='<tr>';
	$tableau.='<td>'.$produit->ref.'</td>
		<td>'.$produit->titre.'</td>
		<td>'.$produit->stock_web.'</td>
		<td>'.$produit->stock_cible.'</td>
		<td><a href="'.$produit->url_thelia().'">Voir dans Thelia</a></td>';
	$tableau.='<tr/>';
	}
	
	$tableau.='</tbody></table>';
	
	return $tableau;
	
}



$produits=Produit::produits_par_sql();

$tableau_ruptures=array();
$tableau_urgences=array();
$tableau_alertes=array();

foreach($produits as $produit){
$alerte=$produit->alerte_stock();
 	if ($alerte==2){
	 	//A commander
	 $tableau_alertes[]=$produit;	
	 	
 	}
 	elseif($alerte==3){
	 	//Urgence
	 	$tableau_urgences[]=$produit;
 	}
 	elseif($alerte==4){
	 	//Rupture
	 	$tableau_ruptures[]=$produit;
 	}
 }

$mail_alertes=new MailLynx();
$mail_alertes->sujet='Alerte : produits à commander';
$mail_alertes->message_titre='Produits sous le seuil d\'alerte.';
$mail_alertes->message_soustitre='Il y a '.count($tableau_alertes).' produits en statut : A commander';
$mail_alertes->message_texte=tableau_html_from_produits_pour_mail($tableau_alertes);
$mail1=$mail_alertes->generer();
$mail1->send();


$mail_urgences=new MailLynx();
$mail_urgences->sujet='Alerte : stocks sous le seuil de sécurité';
$mail_urgences->message_titre='Attention : Produits sous le stock de sécurité.';
$mail_urgences->message_soustitre='Il y a '.count($tableau_urgences).' produits en statut : Urgence';
$mail_urgences->message_texte=tableau_html_from_produits_pour_mail($tableau_urgences);
$mail2=$mail_urgences->generer();
$mail2->send();



$mail_ruptures=new MailLynx();
$mail_ruptures->sujet='Alerte : ruptures de stocks';
$mail_ruptures->message_titre='Urgent : Produits en rupture de stock';
$mail_ruptures->message_soustitre='Il y a '.count($tableau_ruptures).' produits en statut : Rupture totale';
$mail_ruptures->message_texte=tableau_html_from_produits_pour_mail($tableau_ruptures);
$mail3=$mail_ruptures->generer();
$mail3->send();



?>