<?php require_once( "../includes/initialize.php"); 
$aujourdhui=time()*1000;
$date=new Date('ticket',$aujourdhui);
global $session;
$ticketid=false;
if (!empty($_POST)){
	
	//Création d'un nouveau ticket :
	if(isset($_POST['urgence'])){
		$ticket=new Ticket;
		$ticket->titre=$_POST['titre'];
		$ticket->urgence=$_POST['urgence'];
		$ticket->date_ouverture=$date->sql;
		$ticket->statut=0;
		
		$ticket->client=$session->user->username;
		$ticket->save();
		$ticketid=$ticket->id;
			//création du premier message du ticket
		$ticket_message= new TicketMessage;
		$ticket_message->ticket=$ticket->id;
		$ticket_message->date=$date->sql;
		$ticket_message->redacteur=$session->user->nom;
		$ticket_message->message=$_POST['message'];
		$ticket_message->save();
	}
	
	
	//Ajout d'un message à un ticket :
	elseif(isset($_POST['ticket'])){
		$ticketid=$_POST['ticket'];
		$ticket_message= new TicketMessage;
		$ticket_message->ticket=$_POST['ticket'];		
		$ticket_message->date=$date->sql;
		$ticket_message->redacteur=$session->user->nom;
		$ticket_message->message=$_POST['message'];
		$ticket_message->save();
		}

redirect_to('../awi.php'.($ticketid? "#ticket$ticketid":''));
}


?>