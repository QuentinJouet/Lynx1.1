<?php

// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(CLASS_PATH.DS.'database.php');

class PrevenirClient extends DatabaseObject {

  protected static $database="db_cakeshop";
  protected static $table_name="prevenir_client";
  protected static $champs_db=array('id','produit','client','mail_envoye');

public $id;
public $produit;
public $client;
public $mail_envoye;


static public function attentes_produit($id_produit){
$attentes=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE produit=".$id_produit." AND mail_envoye=0");
return $attentes;
}

static public function nb_attentes_produit($id_produit){
global $db_cakeshop;
	$attentes=$db_cakeshop->query("SELECT count(distinct(client))  FROM ".self::$table_name." WHERE mail_envoye=0 AND produit=".$id_produit);
	return array_shift(mysql_fetch_array($attentes));
}

static public function nb_produits_attente(){
	global $db_cakeshop;
	$attentes=$db_cakeshop->query("SELECT count(distinct(produit)) FROM  ".self::$table_name." WHERE mail_envoye=0");
	return array_shift(mysql_fetch_array($attentes));
}

static public function nb_clients_attente(){
global $db_cakeshop;
		$attentes=$db_cakeshop->query("SELECT count(distinct(client))  FROM ".self::$table_name." WHERE mail_envoye=0");
	return array_shift(mysql_fetch_array($attentes));
}

public function existe(){
	global $db_cakeshop;
	$attentes=$db_cakeshop->query("SELECT count(*) FROM  ".self::$table_name." WHERE mail_envoye=0 AND produit={$this->produit} AND client={$this->client}");
	return (array_shift(mysql_fetch_array($attentes))>0)? true:false;
}

static public function envoyer_mail($id_produit){
	$mail=self::generer_mail($id_produit,1);
	$mail->send();
	
	
}

static public function generer_mail($id_produit,$envoi=0){
	$attentes=self::attentes_produit($id_produit);
	$produit=Produit::produit_par_id($id_produit);
	
	$sujet = 'Le produit que vous attendiez est désormais disponible !';
	$titre = $produit->titre . ' est en stock.';
	$soustitre= '<a href="'.$produit->get_public_url().'" target="_blank">Voir la fiche du produit sur TheCakeShop.fr</a>';
	$texte =  'Vous aviez demandé à être prévenu(e) lorsque '.$produit->titre.' serait disponible. Nous en avons désormais '.$produit->stock_web.' en stock, les premiers arrivés seront les premiers servis ! <br/> <br/> Merci pour votre fidélité et votre confiance. <br/>Bien cordialement,</br></br>L\'équipe du Cake Shop.';
	
	$destinataires=array();
	
	foreach($attentes as $attente){
		$attente->mail_envoye=$envoi;
		$attente->save();
		$client=Client::find_by_id($attente->client);
			$destinataires[$client->email]=$client->nom_complet();
	}
	
	$mail=new Mail();
	
	$mail->message_titre=$titre;
	$mail->sujet=$sujet;
	$mail->message_soustitre=$soustitre;
	$mail->message_texte=$texte;
	$mail->destinataires=$destinataires;
	
	$mail=$mail->generer();
	
	return $mail;

}

}