
<?php require_once( "includes/initialize.php");?>

<?php 


//j'ajoute un autre truc



$tickets=Ticket::find_by_sql('SELECT * FROM ticket ORDER BY id DESC');

?>


<?php include(LIB_PATH.DS."header.php");?>
<div class="nine columns" id="contenu">

<br/>

<h4>Nouveau ticket :</h4>
<form method="post" action="actions/ticket.php">
Titre : <input  type="text" name="titre" value=""><br/>
Importance : <SELECT name="urgence">
		<OPTION VALUE=0>Normal</OPTION>
		<OPTION VALUE=1>Urgent</OPTION>
		<OPTION VALUE=2>Critique</OPTION>
		</SELECT>
Message : <textarea  name="message" value=""></textarea>
<button type="submit" class="success button"> Créer </button>
</form>

<h3>Liste des tickets</h3>


<div id="accordion">
	<?php foreach($tickets as $ticket):?>
	    <h3><a href="#ticket<?php echo $ticket->id;?>"> <?php echo $ticket->titre;?> ouvert le Ouvert le : <?php echo substr($ticket->date_ouverture, 1,10) ;?> Statut :  <?php echo Ticket::$nom_statuts[$ticket->statut];?>  </a></h3>
	    <div> 

		    <div class="content_wrap">
			    <?php $tickets_message = TicketMessage::find_by_ticket($ticket->id);?>
			    
					<?php foreach($tickets_message as $ticket_message):?>
					<div class="row">
						<div class="three columns">
						<p><strong><?php echo $ticket_message->redacteur;?></strong>,<br/>le <?php echo $ticket_message->date;?></p> 
						</div>
				
					<div class="nine columns panel">
						<p><?php echo $ticket_message->message;?></p>
					</div>
					</div>
									<?php endforeach;?>
				
					
					<?php if ($ticket->statut!=1):?>
					
						<form method="post" action="actions/ticket.php">
						<input type="hidden" name="ticket" value=<?php echo $ticket->id;?> >
						<li>Répondre :<br/> <textarea  name="message" value=""></textarea><button type="submit" class="radius button"> Envoyer </button></li>
						</form>
					
					<?php endif;?>
			</div>

			
			
		</div>
	<?php endforeach;?>
</div>





<!--

<?php foreach($tickets as $ticket):?>
	<h5>TITRE  : <?php echo $ticket->titre;?> </h5>
	Ouvert le : <?php echo $ticket->date_ouverture;?><br/>
	Importance : <?php echo Ticket::$nom_urgences[$ticket->urgence];?><br/>
	Statut : <?php echo Ticket::$nom_statuts[$ticket->statut];?><br/> 
	 
	<br/> 
	 <?php $tickets_message = TicketMessage::find_by_ticket($ticket->id);?>
	<ul>
	<?php foreach($tickets_message as $ticket_message):?>
	<li> Le <?php echo $ticket_message->date;?>, <?php echo $ticket_message->redacteur;?> : <?php echo $ticket_message->message;?></li>
	<?php endforeach;?>
	<?php if ($ticket->statut!=1):?>
	<form method="post" action="awi.php">
	<input type="hidden" name="ticket" value=<?php echo $ticket->id;?> >
	<li>Le <?php echo $date->sql;?>, <?php echo $session->user->nom;?> : <textarea  name="message" value=""></textarea><button type="submit" class="radius button"> Envoyer </button></li>
	</form>
	<?php endif;?>
	</ul>
	<br/>

<?php endforeach;?>
-->



<?php include(LIB_PATH.DS."footer.php");?>
<?php include(LIB_PATH.DS."finalize.php");?>



