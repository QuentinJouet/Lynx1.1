<?php

require_once(CLASS_PATH.DS.'database.php');

class TicketMessage extends DatabaseObject {

public static $table_name="ticket_message";
	static public $database = 'db_cakeshop';
	public static $champs_db=array('id', 'ticket', 'message', 'date', 'redacteur');
	
	public $id;
	public $ticket;
	public $message;	
	public $date;	
	public $redacteur;

public static function find_by_ticket($id_ticket){
	global $db_cakeshop;
	$sql='SELECT * FROM ' . self::$table_name . ' WHERE ticket=' . $id_ticket . ' ORDER BY id ASC';
	$tickets_message = self::find_by_sql($sql);
	return $tickets_message;
	}
	
}

?>
