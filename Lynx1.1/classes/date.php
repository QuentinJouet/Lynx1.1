<?php 
class Date {
	static public $premier_jour=1341093600000;
	static public $un_jour=86400000;
	
	
	public $nom;
	public $timestamp;
	public $sql;
	
	public function __construct($nom='default',$timestamp){
		$this->timestamp=$timestamp;
		$this->sql=self::timestamp_to_sql($timestamp);
		$this->nom=$nom;
	}	
	
	static public function timestamp_to_sql($time){
		return date("Y-m-d H:i:s",($time / 1000));
	}
	
	static public function ajd(){
		return (time()*1000);
	}
	
	public function jour_sql(){
	return substr($this->sql,0,10);
	}
	
	
	public function lendemain_sql(){
		return self::timestamp_to_sql($timestamp+self::$un_jour);
	}
	
	public function lendemain_date(){
		return new self($this->nom,$this->timestamp+self::$un_jour);
	}

	public function date_sql_to_minutes_sql($date){
	return substr($date,0,10);
	}
	
	public static function date_sql_to_timestamp($date){
	return strtotime($date)*1000;
	}
	
	public static function date_from_sql($chainesql){
		$timestamp = self::date_sql_to_timestamp($chainesql);
		$date=new Date("fromsql",$timestamp);
		return $date;
	}
	
	public static function liste_jours(){
		//RETOURNE UN TABLEAU AVEC LA LISTE DES JOURS SELECTIONNES SOUS LE FORMAT : 2012-12-31
		global $session;
		$premier=$session->datedebut;
		$dernier=$session->datefin;
		$tableau=array();
		$compteur=$premier->timestamp;
		
		while($compteur<=$dernier->timestamp){
			$tableau[]=$compteur;
			$compteur+=self::$un_jour;		
			
		}
		
		foreach($tableau as &$timestamp){
			
			$timestamp = substr(self::timestamp_to_sql($timestamp), 0, 10); 
			
		}
		
		return $tableau;
		
		
		
	}

	
	//fonction qui retourne un array avec les deux dates 0: datedebut et 1: date fin envoyées grace au slider dans le choix des dates.
	public static function analyse_chdate($chaine){
	$deuxdates=explode('au',$chaine);
	
		foreach ($deuxdates as &$chaine){
			$chaine=explode('/',$chaine);
			foreach ($chaine as &$chiffre){
			$chiffre = filtrer_nombres($chiffre);
			}
		}
	if (count($deuxdates)==2){
		if (count($deuxdates[0])==3 && count($deuxdates[1])==3){
			//C'est bon :
			$d1=$deuxdates[0][2]."-".$deuxdates[0][1]."-".$deuxdates[0][0];
			$d2=$deuxdates[1][2]."-".$deuxdates[1][1]."-".$deuxdates[1][0];
			return array(new Date('datedebut',strtotime($d1)*1000),new Date('datefin',strtotime($d2)*1000));			
		}
		//Pas bon
		else return false;
		}
		else return false;	
	}
	
	public function texte() {
	  $unixdatetime = $this->timestamp / 1000;
	  return strftime("%a %d/%m/%y", $unixdatetime);
	
	}	
	
	public function datetime_to_text($datetime="") {
	  $unixdatetime = strtotime($datetime);
	  return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
	
	}	
	
	
	public function to_session(){	
		$_SESSION[$his->nom]=serialize($this);
	}
	
	public function from_session($nom='date'){
		return unserialize($_SESSION[$nom]);
	}
	
}

?>