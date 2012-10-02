<?php

require_once(CLASS_PATH.DS.'database.php');

class Ticket extends DatabaseObject {

public static $table_name="ticket";
	static public $database = 'db_cakeshop';
	public static $champs_db=array('id', 'client', 'ref', 'date_ouverture', 'date_fermeture', 'statut', 'urgence', 'titre');

	public $id;
	public $client;
	public $ref;	
	public $date_ouverture;	
	public $date_fermeture;
	public $statut;
	public $urgence;	
	public $titre;	
	
	
	public static $nom_statuts=array('En cours','Terminé');
	public static $nom_urgences=array('Normal','Urgent','Critique');

	

	


}

?>