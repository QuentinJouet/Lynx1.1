


<?php 
//Finalize sert a regrouper les scripts et à enregistrer ce qu'il faut en session en association avec l'objet $session

?>



<div id="date" class="reveal-modal">
  <h4>Choix des dates de calcul</h4>
  <p>Choisissez la date de début et de fin à l'aide du slider : </p>

  	<script>

	$(function() {
		$( "#slider-range" ).slider({
			range: true,
			min: 1346493600000,
			max: <?php echo Date::ajd();?>,
			step:86400000,
			values: [ <?php echo $session->datedebut->timestamp;?> , <?php echo $session->datefin->timestamp;?> ],
			slide: function( event, ui ) {
			var d1=new Date(ui.values[ 0 ]);
			var d2=new Date(ui.values[ 1 ]);
			var sd1=d1.getDate()+"/"+(d1.getMonth()+1)+"/"+(d1.getFullYear());
			var sd2=d2.getDate()+"/"+(d2.getMonth()+1)+"/"+(d2.getFullYear());
				$( "#amount" ).val( "Du " + sd1 + " au " + sd2  );
			}
		});
		var d1=new Date($( "#slider-range" ).slider( "values", 0 ));
		var d2=new Date($( "#slider-range" ).slider( "values", 1 ));
		var sd1=d1.getDate()+"/"+(d1.getMonth()+1)+"/"+(d1.getFullYear());
		var sd2=d2.getDate()+"/"+(d2.getMonth()+1)+"/"+(d2.getFullYear());
		$( "#amount" ).val( "Du " + sd1 + " au " + sd2 );
	});
	</script>
	

<form method="post" action="<?php echo nom_page_complet();?>">
	<div class="demo">
	<p>
		<label for="amount">Choix date:</label>
		<input type="text" id="amount" name="chdate" style="border:0; font-weight:bold;" />
	</p>
	
	<div id="slider-range"></div>
	  <br/>
	  <br/>
	  <div class="row">
		  <div class="twelve columns">
			  <ul class="button-group even " >
	            <li>
	                <button type="submit" class="success radius button">Valider</button>                        
	            </li>
			  </ul>
		  </div>
	  </div>
</form>
  <a class="close-reveal-modal">&#215;</a>
</div>


        
        
        <script>
        var availableTags = <?php 
		echo Produit::autocomplete_liste();
		?>;

	$(function() {
		$( "#autocomplete" ).autocomplete({
			source: availableTags
		});
	});
	$(function() {
		$( "#autocomplete2" ).autocomplete({
			source: availableTags
		});
	});
	</script>
    
	<script>
	$(function() {
		$( "#accordion" ).accordion({
			autoHeight: false,
			navigation: true,
			collapsible: true
		});
	});
	</script>
		
<?php global $graph;
if (!empty($graph))	{
	echo $graph->generer();
	echo Graph::$source;
}
?>
		
	
	
<?php
//on met les dates en session en ms pour la bonne construction de l'objet Session suivant :
global $session;
$date1=$session->datedebut;
$date2=$session->datefin;
$_SESSION['datedebut']=$date1->timestamp;
$_SESSION['datefin']=$date2->timestamp;
?>

</body>
</html>