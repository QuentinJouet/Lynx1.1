<?php require_once(CLASS_PATH.DS.'database.php');

class Acces extends DatabaseObject {

  protected static $database="db_cakeshop";
  protected static $table_name="acces";
  protected static $champs_db=array('id','user','page','auth');

public $id;
public $user; //id de l'utilisateur
public $page; //nom_page() de la forme "blabla.php"
public $auth; //c'est 0 ou 1


public function auth_ok(){
	$auth = self::find_by_sql("SELECT * FROM acces WHERE user=$this->user AND page='$this->page'");
	if (empty($auth)){
		return false;
	}
	elseif(array_shift($auth)->auth==1){
		return true;
	}else{
		return false;
	}
	
}

}

?>