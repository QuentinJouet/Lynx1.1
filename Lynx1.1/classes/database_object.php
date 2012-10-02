<?php
require_once(CLASS_PATH.DS.'database.php');

class DatabaseObject {

	// Late Static Bindings 
	// http://www.php.net/lsb
	
	public function recuperer_post(){
		foreach (static::$champs_db as $champ){
		(empty($_POST[$champ]))? false : $this->$champ=$_POST[$champ];
		echo $champ;
		}
	}
	
	public static function find_all() {
			global $db_cakeshop;
			global $db_cakeshop_thelia;
		return static::find_by_sql("SELECT * FROM ".static::$table_name,${static::$database},static::$champs_db);
  }
  
	public static function find_by_id($id=0,$database=false,$champs=false) {
  			global $db_cakeshop;
			global $db_cakeshop_thelia;
		  if ($champs==false) {$champs=static::$champs_db;}	 
		    if ($database==false) {$database=${static::$database};}	 
		  //if ($database==false) {$database=${static::$database};} 
    $result_array = static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE id={$id} LIMIT 1",$database,$champs);
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  
  	public static function find_by_ref($ref=0,$database=false,$champs=false) {
		  	global $db_cakeshop;
			global $db_cakeshop_thelia;
		  if ($champs==false) {$champs=static::$champs_db;}	  
		  //if ($database==false) {$database=${static::$database};}
    $result_array = static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE ref='{$ref}' LIMIT 1",${static::$database},$champs);
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  
  	public static function find_by_sql($sql="",$database=false,$champs=false) {
	  if ($champs==false) {$champs=static::$champs_db;}
	  	 	global $db_cakeshop;
			global $db_cakeshop_thelia;
		if ($database==false) {$database=${static::$database};}	
			//POUR DEBUG
		//var_dump($sql);
    $result_set = $database->query($sql);
    $object_array = array();
	//POUR DEBUG
	//var_dump($champs);
	
    while ($row = $database->fetch_array($result_set)) {
      $object_array[] = static::instantiate($row,$database,$champs);
    }
    return $object_array;
  }

	public static function count_all($database=false) {
	global $db_cakeshop;
			global $db_cakeshop_thelia;
		if ($database==false) {$database=${static::$database};}	
	 	  $sql = "SELECT COUNT(*) FROM ".static::$table_name;
    $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}
	
	public static function count_date($database=false) {
		global $session;		
		global $db_cakeshop;
		global $db_cakeshop_thelia;
		if ($database==false) {$database=${static::$database};}	
		$sql = "SELECT COUNT(*) FROM ".static::$table_name." WHERE date BETWEEN '".$session->datedebut->sql."' AND '".$session->datefin->sql."'";
    $result_set = $database->query($sql);
	$row = $database->fetch_array($result_set);
    return array_shift($row);		
	}

	private static function instantiate($record,$database,$champs) {
			  if ($champs==false) {$champs=static::$champs_db;}
		// Could check that $record exists and is an array
    $object = new static;
		// Simple, long-form approach:
		// $object->id 				= $record['id'];
		// $object->username 	= $record['username'];
		// $object->password 	= $record['password'];
		// $object->first_name = $record['first_name'];
		// $object->last_name 	= $record['last_name'];
		
		// More dynamic, short-form approach:
			//POUR DEBUG
	//var_dump($record);
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute,$database,$champs)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	public function remplir_attributs($tableau_associatif) {
		if (empty($tableau_associatif)) {return false;}
	foreach($tableau_associatif as $attribut=>$value){
		  if(property_exists('Produit',$attribut)) {
			  //J'avais mis utf8
		    $this->$attribut = ($value);
		  }
		}	
		
	}
	
	public function remplir_attributs_vides($tableau_associatif) {
		if (empty($tableau_associatif)) {return false;}
	foreach($tableau_associatif as $attribut=>$value){
		  if(property_exists('Produit',$attribut)) {
			  //J'avais mis utf8
			  if (empty($this->$attribut))
			  {$this->$attribut = ($value);}
		  }
		}	
		
	}
	
	private function has_attribute($attribute) {
	 	return property_exists($this,$attribute);

	}

	protected function attributes() { 
		// return an array of attribute names and their values
	  $attributes = array();
	  foreach(static::$champs_db as $field) {
	    if(property_exists($this, $field)) {
	      $attributes[$field] = $this->$field;
	    }
	  }
	  return $attributes;
	}
	
	protected function sanitized_attributes() {
	  global $db_cakeshop;
	  global $db_cakeshop_thelia;
	  $database=${static::$database};
	   $clean_attributes = array();
	  // sanitize the values before submitting
	  // Note: does not alter the actual value of each attribute
	  foreach($this->attributes() as $key => $value){
	    $clean_attributes[$key] = $database->escape_value($value);
	  }
	  return $clean_attributes;
	}

	public static function clean_tableau($tableau,$database) {
	$clean_tableau = array();
	  // sanitize the values before submitting
	  // Note: does not alter the actual value of each attribute
	  foreach($tableau as $key => &$value){
	    $clean_tableau[$key] = utf8_encode($database->escape_value($value));
	  }
	  return $clean_tableau;
	}
	
	public function save() {
	  // A new record won't have an id yet.
	  return isset($this->id) ? $this->update() : $this->create();
	}
	
	public function create() {

	global $db_cakeshop;
	  global $db_cakeshop_thelia;
	  $database=${static::$database};
		// Don't forget your SQL syntax and good habits:
		// - INSERT INTO table (key, key) VALUES ('value', 'value')
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
	  $sql = "INSERT INTO ".static::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	  $sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
	  if($database->query($sql)) {
	    $this->id = $database->insert_id();
	    return true;
	  } else {
	    return false;
	  }
	}

	public function update() {
	  global $db_cakeshop;
	  global $db_cakeshop_thelia;
	  $database=${static::$database};
		// Don't forget your SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".static::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($this->id);
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}

	public function delete() {
		global $db_cakeshop;
	  global $db_cakeshop_thelia;
	  $database=${static::$database};
		// Don't forget your SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
	  $sql = "DELETE FROM ".static::$table_name;
	  $sql .= " WHERE id=". $database->escape_value($this->id);
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	
		// NB: After deleting, the instance of User still 
		// exists, even though the database entry does not.
		// This can be useful, as in:
		//   echo $user->first_name . " was deleted";
		// but, for example, we can't call $user->update() 
		// after calling $user->delete().
	}
	
}