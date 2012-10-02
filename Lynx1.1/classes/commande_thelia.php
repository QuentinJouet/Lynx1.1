<?php

// If it's going to need the database, then it's
// probably smart to require it before we start.
require_once(CLASS_PATH.DS.'database.php');

class CommandeThelia extends DatabaseObject {

	public static $table_name="commande";
	static public $database = 'db_cakeshop_thelia';
	public static $champs_db=array('id', 'client', 'adrfact', 'adrlivr', 'date', 'datefact', 'ref', 'transaction', 'livraison','facture', 'transport', 'port', 'datelivraison', 'remise', 'devise', 'taux', 'colis', 'paiement','statut','lang');

  public static $elements_tri=array('id'=>'Date de creation','total_ttc'=>"Total",'statut'=>"Statut",'paiement'=>"Mode de paiement");


	//Champs DB Thelia
	public $id;
	public $client;
	public $adrfact;
	public $adrlivr;
	public $date;
	public $datefact;
	public $ref;
	public $transaction;
	public $livraison;
	public $facture;
	public $transport;
	public $port;
	public $datelivraison;
	public $remise;
	public $devise;
	public $taux;
	public $colis;
	public $paiement;
	public $statut;
	public $lang;


	//Champs pour fonction
	public $lignes=false;
	public $moyenpaiement=array(31=>'PayPal',12=>'Paypal',1=>'Chèque');
	public $statuts=array('Erreur','Non Payée','Payée','En traitement','Expédiée','Annulée');


	public function statut(){
		return utf8_encode($this->statuts[(int)$this->statut]);
	}
	
	public function moyenpaiement(){
		return utf8_encode($this->moyenpaiement[(int)$this->paiement]);
	}

	public function get_client(){
		return Client::find_by_id($this->client);

	}

	public static function commande_par_ref($ref='') {


	}

	public static function find_by_client($id){
	global $session;
		$sql = "SELECT * FROM ".self::$table_name." WHERE client={$id} AND date BETWEEN '".$session->datedebut->sql."' AND '".$session->datefin->sql."' ORDER BY date ASC";
		$commandes=self::find_by_sql($sql);
				return $commandes;
	}

	public function lignes_pour_commande() {
		$this->lignes=LigneCommandeThelia::lignes_pour_commande($this->id);
		return $this->lignes;
	}

	public function nb_produits(){
		if($this->lignes==false){
			$this->lignes_pour_commande();
		}
		$nbprod=0;
		foreach($this->lignes as $ligne){
			$nbprod+=$ligne->quantite;
		}
		return $nbprod;
	}

	public function prix_produits(){
		if($this->lignes==false){
			$this->lignes_pour_commande();
		}
		$prixprod=0;
		foreach($this->lignes as $ligne){
			$prixprod+=$ligne->prix_total();
		}
		return $prixprod;
	}

	public function tva_val(){
		if($this->lignes==false){
			$this->lignes_pour_commande();
		}
		$tvaval=0;
		foreach($this->lignes as $ligne){
			$tvaval+=$ligne->tva_val();
		}
		return $tvaval;
	}

	public function total_ttc(){
		return $this->prix_produits()+$this->port-$this->remise;
	}

	public function try_to_send_notification() {
		$mail = new PHPMailer();

		$mail->IsSMTP();
		$mail->Host     = "your.host.com";
		$mail->Port     = 25;
		$mail->SMTPAuth = false;
		$mail->Username = "your_username";
		$mail->Password = "your_password";

		$mail->FromName = "Photo Gallery";
		$mail->From     = "";
		$mail->AddAddress("", "Photo Gallery Admin");
		$mail->Subject  = "New Photo Gallery Comment";
		$created = datetime_to_text($this->created);
		$mail->Body     =<<<EMAILBODY

A new comment has been received in the Photo Gallery.

  At {$created}, {$this->author} wrote:

{$this->body}

EMAILBODY;

		$result = $mail->Send();
		return $result;

	}



}

?>