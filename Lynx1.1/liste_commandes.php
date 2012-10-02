<?php require_once( "includes/initialize.php"); ?>
<?php


//4. On rappatrie les objets qui nous interesse (pas optimisé, mais plus souple pour nb objet <<10 000)
//$commandes = CommandeThelia::find_all();
global $datedebut_sql;
global $datefin_sql;
$commandes = CommandeThelia::find_by_sql("SELECT * FROM ".CommandeThelia::$table_name." WHERE date BETWEEN '".$session->datedebut->sql."' AND '".$session->datefin->sql."'");

?>
<?php include(LIB_PATH.DS."header.php");?>

<div class="nine columns" id="contenu">
            <h2>Commandes</h2>

                 <div class="row">

                <div class="five columns">
                    <a href="#" class="small secondary button" data-reveal-id="date">Analyse du <?php echo $session->datedebut->texte() . ' au '.$session->datefin->texte();?></a>
                </div>
                 </div>


                 <div class="row">
                 <div class="twelve columns">

		            <table class="nice" id="tableautri">
		            <thead>
		                <tr>
		                    <th>ID</th>
		
		                    <th>Client</th>
		
		                    <th>Date</th>
		
		                    <th>Ref</th>
		
		                    <th>Montant ttc</th>
		
		                    <th>Statut</th>
		                </tr>
		            </thead>
		            <tbody>
		            <?php foreach($commandes as $commande): ?>
		                <tr>
		                    <td><?php echo $commande->id; ?></td>
		<?php /*
		                    <td><a href="detail_client.php?id_c=&lt;?php echo $commande-&gt;client; ?&gt;"><?php  $client=$commande->get_client(); echo $client->nom_complet(); ?></a></td>
		                    
		 */ ?>
		 
		 					<td><a href="detail_client.php?id_c=<?php echo $commande->client; ?>"><?php  $client=$commande->get_client(); echo $client->nom_complet(); ?></a></td>

		
		                    <td><?php echo $commande->date; ?></td>
		
		                    <td>
		                        <a href="commande_detail.php?ref_c=<?php echo $commande->ref; ?>"> <p><?php echo $commande->ref; ?></p> </a>
		
		                    </td>
		
		                    <td><?php echo $commande->total_ttc(); ?></td>
		
		                    <td><?php echo $commande->statut(); ?></td>
		                </tr>
		                <?php endforeach; ?>
		            </tbody>
		            </table>
                 </div>
                 </div>
        </div>
    </div><?php // IL FAUT PEUT ETRE RAMENER AU GLOBAL SCOPE LES VARIABLE NEXT ET PREV PAGE ?><script type="text/javascript">
$(function() {
    $(document).keydown(function(event) {
        //alert(event.keyCode);
        switch (event.keyCode) {
            case 37: case 74:
                window.location.href = '<?php echo URL_SITE.$prevpage; ?>';
                break;
            case 39: case 75:
                window.location.href = '<?php echo URL_SITE.$nextpage; ?>';
                break;
        }
    });
    });

    </script><?php include(LIB_PATH.DS."footer.php");?>
    <?php include(LIB_PATH.DS."finalize.php");?>
