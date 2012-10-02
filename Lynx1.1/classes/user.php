<?php

// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(CLASS_PATH.DS.'database.php');

class User extends DatabaseObject {
  protected static $database="db_cakeshop";
  protected static $table_name="user";
  protected static $champs_db=array('id','username','password','nom','espace','niveau');
 //attriuts base de donnée
public $id;
public $username;
public $password;
public $nom;
public $espace;
public $niveau;


public function verifier(){
	
 $sql="SELECT * FROM ".self::$table_name." WHERE username='$this->username' AND password='$this->password'";
 echo $sql;
 $user=self::find_by_sql($sql);
 return (empty($user)? false : array_shift($user)->id );	
	
}



}